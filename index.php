<?php
// ============================================================
// index.php — Point d'entrée unique et routeur du site
// Toutes les URLs du site passent par ce fichier.
// Il lit le paramètre "page" dans l'URL et instancie le bon contrôleur pour afficher la bonne page.
// ============================================================

// Démarrage de la session pour toute l'application
// Doit être appelé avant tout autre code
session_start();

// Chargement de la connexion PDO et de tous les modèles
require_once 'config/database.php';
require_once 'models/Model.php';
require_once 'models/Chat.php';
require_once 'models/Admin.php';
require_once 'models/CategorieCarte.php';
require_once 'models/ArticleCarte.php';
require_once 'models/Horaire.php';
require_once 'models/Reservation.php';
require_once 'models/InfoPratique.php';

// Chargement de tous les contrôleurs
require_once 'controllers/AccueilController.php';
require_once 'controllers/ChatController.php';
require_once 'controllers/AdminController.php';
require_once 'controllers/CarteController.php';
require_once 'controllers/ReservationController.php';
require_once 'controllers/InfoController.php';

// Lecture du paramètre "page" dans l'URL
// Si aucun paramètre → page par défaut = 'accueil'
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

// On instancie le bon contrôleur selon la page demandée
switch ($page) {

    // ── Pages publiques ──────────────────────────────────────
    case 'accueil':
    $controller = new AccueilController();
    $controller->index();
    break;

    case 'residents':
        $controller = new ChatController();
        $controller->liste();
        break;

    case 'chat':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $controller = new ChatController();
        $controller->fiche($id);
        break;

    case 'carte':
        $controller = new CarteController();
        $controller->index();
        break;

    case 'reservation':
        $controller = new ReservationController();
        $controller->index();
        break;

    case 'infos':
        $controller = new InfoController();
        $controller->index();
        break;

    // ── Connexion admin ──────────────────────────────────────
    case 'login':
        $controller = new AdminController();
        $controller->login();
        break;

    case 'logout':
        $controller = new AdminController();
        $controller->logout();
        break;

    // ── Espace admin ─────────────────────────────────────────
    case 'admin':
        $action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';
        $controller = new AdminController();

        switch ($action) {

            case 'dashboard':
                $controller->dashboard();
                break;

            case 'add_chat':
                $controller->addChat();
                break;

            case 'edit_chat':
                $controller->editChat((int) ($_GET['id'] ?? 0));
                break;

            case 'delete_chat':
                $controller->deleteChat((int) ($_GET['id'] ?? 0));
                break;

            case 'add_article':
                $controller->addArticle();
                break;

            case 'edit_article':
                $controller->editArticle((int) ($_GET['id'] ?? 0));
                break;

            case 'delete_article':
                $controller->deleteArticle((int)($_GET['id']??0));
                break;

            case 'edit_horaires':
                $controller->editHoraires();
                break;

            case 'edit_infos':
                $controller->editInfos();
                break;

            case 'reservations':
                $controller->gererReservations();
                break;

            case 'statut_reservation':
                $controller->updateStatutReservation((int)($_GET['id']??0));
                break;

            default:
            $controller->dashboard();
            break;
        }
        break;

    // ── Page inconnue → redirection vers l'accueil ───────────
    default:
        header('Location: index.php?page=accueil');
        exit;
}
?>
