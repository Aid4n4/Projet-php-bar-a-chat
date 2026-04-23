<?php
// ============================================================
// controllers/AccueilController.php
// Gère la page d'accueil publique
// ============================================================

require_once 'models/Horaire.php';
require_once 'models/InfoPratique.php';

class AccueilController {

    private Horaire $modelHoraire;
    private InfoPratique $modelInfo;

    public function __construct() {
        $this->modelHoraire = new Horaire();
        $this->modelInfo = new InfoPratique();
    }

    public function index(): void {
        $horaires = $this->modelHoraire->getAll();
        $infos = $this->modelInfo->getAll();

        include 'views/templates/header.php';
        include 'views/accueil/index.php';
        include 'views/templates/footer.php';
    }
}

?>