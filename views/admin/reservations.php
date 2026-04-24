<?php
// ============================================================
// views/admin/reservations.php — Gestion des réservations
// Variables disponibles : $reservations
// ============================================================
?>

<div class="admin-header">
    <h1>Réservations</h1>
    <a href="index.php?page=admin" class="btn btn-secondaire">← Retour</a>
</div>

<?php if (empty($reservations)) : ?>
    <p>Aucune réservation pour le moment.</p>
<?php else : ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Personnes</th>
                <th>Commentaire</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation) : ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['date_reservation']) ?></td>
                    <td><?= htmlspecialchars($reservation['heure']) ?></td>
                    <td><?= htmlspecialchars($reservation['nom_client']) ?></td>
                    <td><?= htmlspecialchars($reservation['email']) ?></td>
                    <td><?= htmlspecialchars($reservation['telephone'] ?? '') ?></td>
                    <td><?= $reservation['nb_personnes'] ?></td>
                    <td><?= htmlspecialchars($reservation['commentaire'] ?? '') ?></td>
                    <td>
                        <span class="statut statut-<?= $reservation['statut'] ?>">
                            <?= htmlspecialchars($reservation['statut']) ?>
                        </span>
                    </td>
                    <td>
                        <!-- Changer le statut -->
                        <a href="index.php?page=admin&action=statut_reservation&id=<?= $reservation['id_reservation'] ?>&statut=confirmee"
                           class="btn btn-principal"
                           style="font-size: 0.75rem; padding: 0.4rem 0.8rem;">
                            ✓ Confirmer
                        </a>
                        <a href="index.php?page=admin&action=statut_reservation&id=<?= $reservation['id_reservation'] ?>&statut=annulee"
                           class="btn btn-secondaire"
                           style="font-size: 0.75rem; padding: 0.4rem 0.8rem;">
                            ✗ Annuler
                        </a>
                        <!-- Supprimer -->
                        <a href="index.php?page=admin&action=suppr_reservation&id=<?= $reservation['id_reservation'] ?>"
                           class="btn btn-danger"
                           style="font-size: 0.75rem; padding: 0.4rem 0.8rem;"
                           onclick="return confirm('Supprimer cette réservation ?')">
                            Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>