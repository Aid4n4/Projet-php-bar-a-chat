<?php
// ============================================================
// views/admin/form_chat.php — Formulaire ajout/édition d'un chat
// Variables disponibles : $erreurs, $chat (si édition)
// ============================================================

// Détermine si on est en mode édition ou ajout
$edition = isset($chat) && !empty($chat);
$action  = $edition
    ? 'index.php?page=admin&action=edit_chat&id=' . $chat['id_chat']
    : 'index.php?page=admin&action=add_chat';
?>

<div class="admin-header">
    <h1><?= $edition ? 'Modifier un résident' : 'Ajouter un résident' ?></h1>
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
    <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Informations générales</legend>

            <div class="champ">
                <label for="nom">Nom *</label>
                <input type="text" id="nom" name="nom" required
                       value="<?= htmlspecialchars($chat['nom'] ?? '') ?>">
            </div>

            <div class="champ">
                <label for="race">Race</label>
                <input type="text" id="race" name="race"
                       value="<?= htmlspecialchars($chat['race'] ?? '') ?>">
            </div>

            <div class="champ">
                <label for="date_de_naissance">Date de naissance</label>
                <input type="date" id="date_de_naissance" name="date_de_naissance"
                       value="<?= htmlspecialchars($chat['date_de_naissance'] ?? '') ?>">
            </div>

            <div class="champ">
                <label for="sexe">Sexe *</label>
                <select id="sexe" name="sexe" required>
                    <option value="Mâle"
                        <?= (($chat['sexe'] ?? '') === 'Mâle') ? 'selected' : '' ?>>
                        Mâle
                    </option>
                    <option value="Femelle"
                        <?= (($chat['sexe'] ?? '') === 'Femelle') ? 'selected' : '' ?>>
                        Femelle
                    </option>
                </select>
            </div>

            <div class="champ">
                <label for="photo">Photo *</label>
                <input type="file" id="photo" name="photo"
                    accept="image/jpeg, image/png, image/webp"
                    <?= $edition ? '' : 'required' ?>>
                <?php if ($edition && $chat['photo']) : ?>
                    <p>Photo actuelle :
                        <img src="public/images/<?= htmlspecialchars($chat['photo']) ?>"
                            style="width:100px; border-radius:8px; margin-top:0.5rem;">
                    </p>
                <?php endif; ?>
            </div>
            
        </fieldset>

        <fieldset style="margin-top: 1rem;">
            <legend>Caractéristiques (0 à 5)</legend>

            <div class="champ">
                <label for="car_joueur">Joueur</label>
                <input type="number" id="car_joueur" name="car_joueur"
                       min="0" max="5"
                       value="<?= $chat['car_joueur'] ?? 0 ?>">
            </div>

            <div class="champ">
                <label for="car_calin">Câlin</label>
                <input type="number" id="car_calin" name="car_calin"
                       min="0" max="5"
                       value="<?= $chat['car_calin'] ?? 0 ?>">
            </div>

            <div class="champ">
                <label for="car_gourmand">Gourmand</label>
                <input type="number" id="car_gourmand" name="car_gourmand"
                       min="0" max="5"
                       value="<?= $chat['car_gourmand'] ?? 0 ?>">
            </div>

            <div class="champ">
                <label for="car_paresseux">Paresseux</label>
                <input type="number" id="car_paresseux" name="car_paresseux"
                       min="0" max="5"
                       value="<?= $chat['car_paresseux'] ?? 0 ?>">
            </div>
        </fieldset>

        <fieldset style="margin-top: 1rem;">
            <legend>Descriptions</legend>

            <div class="champ">
                <label for="desc_nom">Son nom</label>
                <textarea id="desc_nom" name="desc_nom"><?=
                    htmlspecialchars($chat['desc_nom'] ?? '')
                ?></textarea>
            </div>

            <div class="champ">
                <label for="desc_vie_avant">Sa vie avant</label>
                <textarea id="desc_vie_avant" name="desc_vie_avant"><?=
                    htmlspecialchars($chat['desc_vie_avant'] ?? '')
                ?></textarea>
            </div>

            <div class="champ">
                <label for="desc_vie_au_bar">Sa vie au bar</label>
                <textarea id="desc_vie_au_bar" name="desc_vie_au_bar"><?=
                    htmlspecialchars($chat['desc_vie_au_bar'] ?? '')
                ?></textarea>
            </div>

            <div class="champ">
                <label for="desc_aime">Il/Elle aime</label>
                <textarea id="desc_aime" name="desc_aime"><?=
                    htmlspecialchars($chat['desc_aime'] ?? '')
                ?></textarea>
            </div>
        </fieldset>

        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-principal">
                <?= $edition ? 'Enregistrer les modifications' : 'Ajouter le résident' ?>
            </button>
        </div>
    </form>
</div>
