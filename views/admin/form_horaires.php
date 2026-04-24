<?php
// ============================================================
// views/admin/form_horaires.php — Formulaire édition des horaires
// Variables disponibles : $horaires
// ============================================================
?>

<div class="admin-header">
    <h1>Modifier les horaires</h1>
    <a href="index.php?page=admin" class="btn btn-secondaire">← Retour</a>
</div>

<div class="formulaire">
    <form action="index.php?page=admin&action=edit_horaires" method="post">
        <fieldset>
            <legend>Horaires d'ouverture</legend>

            <?php foreach ($horaires as $horaire) : ?>
                <div class="champ">
                    <label><?= htmlspecialchars($horaire['jour']) ?></label>

                    <div style="display: flex; align-items: center; gap: 1rem;">

                        <!-- Case à cocher ouvert/fermé -->
                        <label>
                            <input type="checkbox"
                                   name="horaires[<?= $horaire['id_horaire'] ?>][est_ouvert]"
                                   value="1"
                                   <?= $horaire['est_ouvert'] ? 'checked' : '' ?>>
                            Ouvert
                        </label>

                        <!-- Heure d'ouverture -->
                        <input type="time"
                               name="horaires[<?= $horaire['id_horaire'] ?>][heure_ouverture]"
                               value="<?= $horaire['heure_ouverture'] ?? '' ?>"
                               style="width: auto;">

                        <span>à</span>

                        <!-- Heure de fermeture -->
                        <input type="time"
                               name="horaires[<?= $horaire['id_horaire'] ?>][heure_fermeture]"
                               value="<?= $horaire['heure_fermeture'] ?? '' ?>"
                               style="width: auto;">
                    </div>
                </div>
            <?php endforeach; ?>

        </fieldset>

        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-principal">
                Enregistrer les horaires
            </button>
        </div>
    </form>
</div>