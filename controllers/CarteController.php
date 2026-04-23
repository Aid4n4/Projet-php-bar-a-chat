<?php
// ============================================================
// controllers/CarteController.php
// Gère : affichage public de la carte, et le CRUD des articles et catégories côté admin
// ============================================================

require_once 'models/ArticleCarte.php';
require_once 'models/CategorieCarte.php';

class CarteController {

    private ArticleCarte $modelArticle;
    private CategorieCarte $modelCategorie;

    public function __construct() {
        $this->modelArticle = new ArticleCarte();
        $this->modelCategorie = new CategorieCarte();
    }

    // PAGE PUBLIQUE : affiche la carte groupée par catégorie
    public function index(): void {
        $categories = $this->modelCategorie->getAll();
        $articles = $this->modelArticle->getAll();

        include 'views/templates/header.php';
        include 'views/carte/index.php';
        include 'views/templates/footer.php';
    }

    // ADMIN : ajout d'un article
    public function addArticle(): void {
        $this->requireAdmin();

        $categories = $this->modelCategorie->getAll();
        $erreurs = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['nom'])) {
                $erreurs[] = 'Le nom est obligatoire.';
            }
            if (empty($_POST['prix'])) {
                $erreurs[] = 'Le prix est obligatoire.';
            }
            if (empty($erreurs)) {
                $this->modelArticle->insert([
                    ':nom' => htmlspecialchars(trim($_POST['nom'])),
                    ':description' => $_POST['description'] ?? '',
                    ':prix' => (float) $_POST['prix'],
                    ':id_categorie' => (int) $_POST['id_categorie'],
                ]);
                header('Location: index.php?page=admin');
                exit;
            }
        }

        include 'views/templates/header.php';
        include 'views/admin/form_article.php';
        include 'views/templates/footer.php';
    }

    // ADMIN : édition d'un article
    public function editArticle(int $id): void {
        $this->requireAdmin();

        $article = $this->modelArticle->getById($id);
        $categories = $this->modelCategorie->getAll();
        $erreurs = [];

        if (!$article) {
            header('Location: index.php?page=admin');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['nom'])) {
                $erreurs[] = 'Le nom est obligatoire.';
            }
            if (empty($erreurs)) {
                $this->modelArticle->update($id, [
                    ':nom' => htmlspecialchars(trim($_POST['nom'])),
                    ':description' => $_POST['description'] ?? '',
                    ':prix' => (float) $_POST['prix'],
                    ':id_categorie' => (int) $_POST['id_categorie'],
                ]);
                header('Location: index.php?page=admin');
                exit;
            }
        }

        include 'views/templates/header.php';
        include 'views/admin/form_article.php';
        include 'views/templates/footer.php';
    }

    // ADMIN : suppression d'un article
    public function deleteArticle(int $id): void {
        $this->requireAdmin();
        $this->modelArticle->delete($id);
        header('Location: index.php?page=admin');
        exit;
    }

    // Vérifie que l'admin est connecté, redirige vers login sinon
    private function requireAdmin(): void {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
    }
}
?>