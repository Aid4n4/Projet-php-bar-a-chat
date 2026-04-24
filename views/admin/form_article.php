<?php
// ============================================================
// views/admin/form_article.php — Formulaire ajout/édition d'un article
// Variables disponibles : $categories, $erreurs, $article (si édition)
// ============================================================

$edition = isset($article) && !empty($article);
$action  = $edition
    ? 'index.php?page=admin&action=edit_article&id=' . $article['id_article']
    : 'index.php?page=admin&action=add_article';
?>

<div class="admin-header">
    <h1><?= $edition ? 'Modifier un article' : 'Ajouter un article' ?></h1>
    <a href="index.php?page=admin" class="btn btn-secondaire">← Retour</a>
</div>

<!-- Affichage des erreurs -->
<?php if (!empty($erreurs)) : ?>
    <div class="message-erreur">
        <ul>
            <?php foreach ($erreurs as $erreur) : ?>
                <li><?= htmlspecialchars($erreur) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="formulaire">
    <form action="<?= $action ?>" method="post">
        <fieldset>
            <legend>Informations de l'article</legend>

            <div class="champ">
                <label for="nom">Nom *</label>
                <input type="text" id="nom" name="nom" required
                       value="<?= htmlspecialchars($article['nom'] ?? '') ?>">
            </div>

            <div class="champ">
                <label for="description">Description</label>
                <textarea id="description" name="description"><?=
                    htmlspecialchars($article['description'] ?? '')
                ?></textarea>
            </div>

            <div class="champ">
                <label for="prix">Prix (€) *</label>
                <input type="number" id="prix" name="prix"
                       min="0" step="0.01" required
                       value="<?= $article['prix'] ?? '' ?>">
            </div>

            <div class="champ">
                <label for="id_categorie">Catégorie *</label>
                <select id="id_categorie" name="id_categorie" required>
                    <?php foreach ($categories as $categorie) : ?>
                        <option value="<?= $categorie['id_categorie'] ?>"
                            <?= (($article['id_categorie'] ?? 0) == $categorie['id_categorie'])
                                ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categorie['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </fieldset>

        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-principal">
                <?= $edition ? 'Enregistrer les modifications' : 'Ajouter l\'article' ?>
            </button>
        </div>
    </form>
</div>