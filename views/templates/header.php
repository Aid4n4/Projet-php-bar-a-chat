<?php
// ============================================================
// views/templates/header.php — Entête commune à toutes les pages
// Inclus en haut de chaque vue avec include
// ============================================================
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Le Ronron Café</title>
        <link rel="stylesheet" href="public/css/style.css">
    </head>
    <body>

    <header>
        <nav>
            <a href="index.php?page=accueil" class="nav-logo">Le Ronron Café</a>
            <ul class="nav-liens">
                <li><a href="index.php?page=accueil">Accueil</a></li>
                <li><a href="index.php?page=residents">Les résidents</a></li>
                <li><a href="index.php?page=carte">La carte</a></li>
                <li><a href="index.php?page=reservation">Réservation</a></li>
                <li><a href="index.php?page=infos">Infos pratiques</a></li>
            </ul>
        </nav>
    </header>

<main>