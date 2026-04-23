<?php
// ============================================================
// controllers/InfoController.php
// Gère : affichage public des infos pratiques et des horaires
// ============================================================

require_once 'models/InfoPratique.php';
require_once 'models/Horaire.php';

class InfoController {

    private InfoPratique $modelInfo;
    private Horaire $modelHoraire;

    public function __construct() {
        $this->modelInfo = new InfoPratique();
        $this->modelHoraire = new Horaire();
    }

    // PAGE PUBLIQUE : affiche les infos pratiques et les horaires
    public function index(): void {
        $infos = $this->modelInfo->getAll();
        $horaires = $this->modelHoraire->getAll();

        include 'views/templates/header.php';
        include 'views/infos/index.php';
        include 'views/templates/footer.php';
    }
}
?>