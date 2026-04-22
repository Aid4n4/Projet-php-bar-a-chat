<?php
// ============================================================
// controleur.php — Point d'entrée unique du site
// ============================================================

session_start();

// Chargement des fichiers nécessaires
require("connect.inc.php");
require("tbs_class.php");
require("modele.class.php");
require("controleur.class.php");

// Création de l'objet TinyButStrong
$tbs = new clsTinyButStrong;
$tbs->NoErr = true; // désactive les messages d'erreur TBS dans la page

// Connexion à MariaDB
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $login, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Lancement de l'application
    $appli = new Appli($tbs, $pdo);
    $appli->moteur($pdo);

} catch (PDOException $erreur) {
    die("Erreur de connexion : " . $erreur->getMessage());
}

?>