<?php
// ============================================================
// views/infos/index.php — Infos pratiques et horaires
// COUCHE : Vue
// Variables disponibles : $infos, $horaires
// ============================================================

// On transforme le tableau $infos en tableau associatif clé → valeur
// pour pouvoir accéder facilement à chaque info par sa clé
$infosParCle = [];
foreach ($infos as $info) {
    $infosParCle[$info['cle']] = $info['valeur'];
}
?>

<h1>Infos pratiques</h1>

<div class="info-grille">

    <!-- Bloc infos générales -->
     <div class="info-bloc">
        <h2>Nous trouver</h2>

        <?php if (!empty($infosParCle['adresse'])) : ?>
                        <p>📍 <?= htmlspecialchars($infosParCle['adresse']) ?></p>
        <?php endif; ?>

        <?php if (!empty($infosParCle['telephone'])) : ?>
            <p>📞 <?= htmlspecialchars($infosParCle['telephone']) ?></p>
        <?php endif; ?>

        <?php if (!empty($infosParCle['email'])) : ?>
            <p>✉️ <?= htmlspecialchars($infosParCle['email']) ?></p>
        <?php endif; ?>

        <?php if (!empty($infosParCle['instagram'])) : ?>
            <p>📷 <?= htmlspecialchars($infosParCle['instagram']) ?></p>
        <?php endif; ?>
    </div>

    <!-- Bloc horaires -->
    <div class="info-bloc">
        <h2>Nos horaires</h2>
        <table>
            <tbody>
                <?php foreach ($horaires as $horaire) : ?>
                    <tr>
                        <th><?= htmlspecialchars($horaire['jour']) ?></th>
                        <td>
                            <?php if ($horaire['est_ouvert']) : ?>
                                <?= $horaire['heure_ouverture'] ?>
                                — <?= $horaire['heure_fermeture'] ?>
                            <?php else : ?>
                                <span class="ferme">Fermé</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Description du bar -->
<?php if (!empty($infosParCle['description'])) : ?>
    <div class="info-bloc" style="margin-top: 2rem;">
        <h2>À propos</h2>
        <p><?= htmlspecialchars($infosParCle['description']) ?></p>
    </div>
<?php endif; ?>
