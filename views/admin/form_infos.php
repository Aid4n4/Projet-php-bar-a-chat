<?php
// ============================================================
// views/admin/form_infos.php — Formulaire édition des infos pratiques
// Variables disponibles : $infos
// ============================================================

// Labels lisibles pour chaque clé
$labels = [
    'adresse' => 'Adresse *',
    'telephone' => 'Téléphone *',
    'email' => 'Email *',
    'instagram' => 'Instagram',
    'description' => 'Description *',
];
?>

<div class="admin-header">
    <h1>Modifier les infos pratiques</h1>
    <a href="index.php?page=admin" class="btn btn-secondaire">← Retour</a>
</div>

<div class="formulaire">
    <form action="index.php?page=admin&action=edit_infos" method="post">
        <fieldset>
            <legend>Informations pratiques</legend>

            <?php foreach ($infos as $info) : ?>
                <div class="champ">
                    <label for="<?= $info['cle'] ?>">
                        <?= $labels[$info['cle']] ?? htmlspecialchars($info['cle']) ?>
                    </label>

                    <?php if ($info['cle'] === 'description') : ?>
                        <textarea id="<?= $info['cle'] ?>"
                                name="infos[<?= $info['cle'] ?>]"
                                required><?=
                            htmlspecialchars($info['valeur'])
                        ?></textarea>
                    <?php else : ?>
                        <input type="text"
                            id="<?= $info['cle'] ?>"
                            name="infos[<?= $info['cle'] ?>]"
                            value="<?= htmlspecialchars($info['valeur']) ?>"
                            required>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

        </fieldset>

        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-principal">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
