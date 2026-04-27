<?php
// ============================================================
// views/admin/dashboard.php — Tableau de bord admin
// Variables disponibles : $chats, $reservations
// ============================================================
?>

<div class="admin-header">
    <h1>Tableau de bord</h1>
    <a href="index.php?page=logout" class="btn btn-danger">
        Se déconnecter
    </a>
</div>

<!-- Gestion des résidents -->
<section>
    <div class="admin-header">
        <h2>Les résidents</h2>
        <a href="index.php?page=admin&action=add_chat" class="btn btn-principal">
            + Ajouter un chat
        </a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Race</th>
                <th>Sexe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chats as $chat) : ?>
                <tr>
                    <td><?= htmlspecialchars($chat['nom']) ?></td>
                    <td><?= htmlspecialchars($chat['race'] ?? '') ?></td>
                    <td><?= htmlspecialchars($chat['sexe']) ?></td>
                    <td>
                        <a href="index.php?page=admin&action=edit_chat&id=<?= $chat['id_chat'] ?>"
                           class="btn btn-secondaire">
                            Modifier
                        </a>
                        <a href="index.php?page=admin&action=delete_chat&id=<?= $chat['id_chat'] ?>"
                           class="btn btn-danger"
                           onclick="return confirm('Supprimer <?= htmlspecialchars($chat['nom']) ?> ?')">
                            Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<div class="separateur">✦ ✦ ✦</div>

<!-- Gestion de la carte -->
<section>
    <div class="admin-header">
        <h2>La carte</h2>
        <a href="index.php?page=admin&action=add_article" class="btn btn-principal">
            + Ajouter un article
        </a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Catégorie</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article) : ?>
                <tr>
                    <td><?= htmlspecialchars($article['nom_categorie']) ?></td>
                    <td><?= htmlspecialchars($article['nom']) ?></td>
                    <td><?= number_format($article['prix'], 2, ',', '') ?> €</td>
                    <td>
                        <a href="index.php?page=admin&action=edit_article&id=<?= $article['id_article'] ?>"
                           class="btn btn-secondaire">
                            Modifier
                        </a>
                        <a href="index.php?page=admin&action=delete_article&id=<?= $article['id_article'] ?>"
                           class="btn btn-danger"
                           onclick="return confirm('Supprimer <?= htmlspecialchars($article['nom']) ?> ?')">
                            Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<div class="separateur">✦ ✦ ✦</div>

<!-- Gestion des horaires et infos -->
<section>
    <div class="admin-header">
        <h2>Paramètres</h2>
    </div>
    <a href="index.php?page=admin&action=edit_horaires" class="btn btn-secondaire">
        Modifier les horaires
    </a>
    <a href="index.php?page=admin&action=edit_infos" class="btn btn-secondaire"
       style="margin-left: 1rem;">
        Modifier les infos pratiques
    </a>
</section>

<div class="separateur">✦ ✦ ✦</div>

<!-- Gestion des réservations -->
<section>
    <div class="admin-header">
        <h2>Réservations</h2>
        <a href="index.php?page=admin&action=reservations" class="btn btn-secondaire">
            Voir toutes les réservations
        </a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Nom</th>
                <th>Personnes</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation) : ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['date_reservation']) ?></td>
                    <td><?= htmlspecialchars($reservation['heure']) ?></td>
                    <td><?= htmlspecialchars($reservation['nom_client']) ?></td>
                    <td><?= $reservation['nb_personnes'] ?></td>
                    <td>
                        <span class="statut statut-<?= $reservation['statut'] ?>">
                            <?= htmlspecialchars($reservation['statut']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
