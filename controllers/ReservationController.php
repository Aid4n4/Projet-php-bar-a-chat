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
        $succes  = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validation du nom
            if (empty($_POST['nom_client'])) {
                $erreurs[] = 'Le nom est obligatoire.';
            }

            // Validation de l'email
            if (empty($_POST['email'])) {
                $erreurs[] = 'L\'email est obligatoire.';
            }

            // Validation de la date
            if (empty($_POST['date_reservation'])) {
                $erreurs[] = 'La date est obligatoire.';
            } else {
                // Vérifie que la date n'est pas dans le passé
                if ($_POST['date_reservation'] < date('Y-m-d')) {
                    $erreurs[] = 'La date ne peut pas être dans le passé.';
                }
                // Vérifie que ce n'est pas un lundi (jour fermé)
                $jour = date('N', strtotime($_POST['date_reservation']));
                if ($jour == 1) {
                    $erreurs[] = 'Le café est fermé le lundi, veuillez choisir un autre jour.';
                }
            }

            // Validation de l'heure
            if (empty($_POST['heure'])) {
                $erreurs[] = 'L\'heure est obligatoire.';
            }

            // Validation du nombre de personnes
            if (empty($_POST['nb_personnes'])) {
                $erreurs[] = 'Le nombre de personnes est obligatoire.';
            } else {
                if ((int) $_POST['nb_personnes'] < 1 || (int) $_POST['nb_personnes'] > 10) {
                    $erreurs[] = 'Le nombre de personnes doit être entre 1 et 10.';
                }
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
