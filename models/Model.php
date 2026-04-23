<?php
// ============================================================
// models/Model.php — Classe parente de tous les modèles
// Centralise la connexion PDO pour éviter de la répéter dans chaque classe fille.
// ============================================================

require_once 'config/database.php';

abstract class Model {

    protected PDO $pdo; // accessible dans toutes les classes filles

    public function __construct() {
        // Récupère la connexion unique définie dans config/database.php
        $this->pdo = getConnexion();
    }
}
?>