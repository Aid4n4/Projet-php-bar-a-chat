<?php
// ============================================================
// controllers/AdminController.php
// Gère : connexion, déconnexion, dashboard, horaires, infos pratiques, réservations
// ============================================================

require_once 'models/Admin.php';
require_once 'models/Chat.php';
require_once 'models/ArticleCarte.php';
require_once 'models/Horaire.php';
require_once 'models/InfoPratique.php';
require_once 'models/Reservation.php';

class AdminController {

    private Admin $modelAdmin;
    private Chat $modelChat;
    private ArticleCarte $modelArticle;
    private Horaire $modelHoraire;
    private InfoPratique $modelInfo;
    private Reservation $modelReservation;

    public function __construct() {
        $this->modelAdmin = new Admin();
        $this->modelChat = new Chat();
        $this->modelArticle = new ArticleCarte();
        $this->modelHoraire = new Horaire();
        $this->modelInfo = new InfoPratique();
        $this->modelReservation = new Reservation();
    }

    // ── Connexion ────────────────────────────────────────────
    public function login(): void {
        // Si déjà connecté → dashboard directement
        if (isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=admin');
            exit;
        }

        $erreur = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->modelAdmin->verifierLogin($_POST['login'], $_POST['mot_de_passe'])) {
                header('Location: index.php?page=admin');
                exit;
            } else {
                // Message volontairement vague pour ne pas donner d'indice
                $erreur = 'Identifiants incorrects.';
            }
        }

        include 'views/templates/header.php';
        include 'views/admin/login.php';
        include 'views/templates/footer.php';
    }

    // ── Déconnexion ──────────────────────────────────────────
    public function logout(): void {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }

    // ── Dashboard ────────────────────────────────────────────
    public function dashboard(): void {
        $this->requireAdmin();

        $chats        = $this->modelChat->getAll();
        $reservations = $this->modelReservation->getAll();
        $articles     = $this->modelArticle->getAll(); // ← ajouter

        include 'views/templates/header.php';
        include 'views/admin/dashboard.php';
        include 'views/templates/footer.php';
    }

    // ── Gestion des horaires ─────────────────────────────────
    public function editHoraires(): void {
        $this->requireAdmin();

        $horaires = $this->modelHoraire->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // $_POST['horaires'] est un tableau indexé par id_horaire
            foreach ($_POST['horaires'] as $id => $data) {
                $this->modelHoraire->updateById((int) $id, [
                    ':heure_ouverture' => $data['heure_ouverture'] ?: null,
                    ':heure_fermeture' => $data['heure_fermeture'] ?: null,
                    ':est_ouvert' => isset($data['est_ouvert']) ? 1 : 0,
                ]);
            }
            header('Location: index.php?page=admin');
            exit;
        }

        include 'views/templates/header.php';
        include 'views/admin/form_horaires.php';
        include 'views/templates/footer.php';
    }

    // ── Gestion des infos pratiques ──────────────────────────
    public function editInfos(): void {
        $this->requireAdmin();

        $infos = $this->modelInfo->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // $_POST['infos'] est un tableau indexé par clé
            foreach ($_POST['infos'] as $cle => $valeur) {
                $this->modelInfo->update($cle, $valeur);
            }
            header('Location: index.php?page=admin');
            exit;
        }

        include 'views/templates/header.php';
        include 'views/admin/form_infos.php';
        include 'views/templates/footer.php';
    }

    // ── Gestion des réservations ─────────────────────────────
    public function gererReservations(): void {
        $this->requireAdmin();

        $reservations = $this->modelReservation->getAll();

        include 'views/templates/header.php';
        include 'views/admin/reservations.php';
        include 'views/templates/footer.php';
    }

    public function updateStatutReservation(int $id): void {
        $this->requireAdmin();
        $statut = $_GET['statut'] ?? 'en_attente';
        $this->modelReservation->updateStatut($id, $statut);
        header('Location: index.php?page=admin&action=reservations');
        exit;
    }

    // ── Utilitaire : vérifie la session admin ────────────────
    private function requireAdmin(): void {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
    }
}
?>
