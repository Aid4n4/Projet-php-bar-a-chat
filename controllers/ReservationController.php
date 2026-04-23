<?php
// ============================================================
// controllers/ReservationController.php
// Gère : formulaire de réservation public
// ============================================================

require_once 'models/Reservation.php';

class ReservationController {

    private Reservation $model;

    public function __construct() {
        $this->model = new Reservation();
    }

    // PAGE PUBLIQUE : affiche le formulaire et traite la soumission
    public function index(): void {
        $erreurs = [];
        $succes = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validation basique
            if (empty($_POST['nom_client'])) {
                $erreurs[] = 'Le nom est obligatoire.';
            }
            if (empty($_POST['email'])) {
                $erreurs[] = 'L\'email est obligatoire.';
            }
            if (empty($_POST['date_reservation'])) {
                $erreurs[] = 'La date est obligatoire.';
            }
            if (empty($_POST['heure'])) {
                $erreurs[] = 'L\'heure est obligatoire.';
            }
            if (empty($_POST['nb_personnes'])) {
                $erreurs[] = 'Le nombre de personnes est obligatoire.';
            }

            if (empty($erreurs)) {
                $this->model->insert([
                    ':date_reservation' => $_POST['date_reservation'],
                    ':heure' => $_POST['heure'],
                    ':nb_personnes' => (int) $_POST['nb_personnes'],
                    ':nom_client' => htmlspecialchars(trim($_POST['nom_client'])),
                    ':email' => htmlspecialchars(trim($_POST['email'])),
                    ':telephone' => htmlspecialchars(trim($_POST['telephone'] ?? '')),
                    ':commentaire' => $_POST['commentaire'] ?? '',
                ]);
                // Redirection pour éviter une double soumission au rechargement
                header('Location: index.php?page=reservation&ok=1');
                exit;
            }
        }

        // ok=1 dans l'URL → message de confirmation après redirection
        $succes = isset($_GET['ok']);

        include 'views/templates/header.php';
        include 'views/reservation/index.php';
        include 'views/templates/footer.php';
    }
}
?>