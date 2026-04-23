<?php
// ============================================================
// views/chats/fiche.php — Fiche détaillée d'un résident
// Variables disponibles : $chat
// ============================================================
?>

<a href="index.php?page=residents" class="btn btn-secondaire">
    ← Retour aux résidents
</a>

<div class="fiche-chat">

    <!-- Photo du chat -->
    <div class="fiche-chat-photo">
        <img
            src="<?= htmlspecialchars($chat['photo'] ?? 'public/images/default.jpg') ?>"
            alt="Photo de <?= htmlspecialchars($chat['nom']) ?>">
    </div>

    <!-- Informations du chat -->
    <div class="fiche-chat-infos">
        <h1><?= htmlspecialchars($chat['nom']) ?></h1>
        <p><em><?= htmlspecialchars($chat['race'] ?? '') ?></em></p>

        <!-- Calcul de l'âge depuis la date de naissance -->
        <?php if ($chat['date_de_naissance']) :
            $naissance = new DateTime($chat['date_de_naissance']);
            $age = $naissance->diff(new DateTime())->y;
        ?>
            <p><?= $age ?> an<?= $age > 1 ? 's' : '' ?></p>
        <?php endif; ?>

        <!-- Caractéristiques -->
        <div class="caracteristiques">
            <h2>Caractère</h2>

            <div class="car-ligne">
                <span class="car-label">Joueur</span>
                <div class="car-barre">
                    <div class="car-barre-remplie"
                         style="width: <?= ($chat['car_joueur'] / 5) * 100 ?>%">
                    </div>
                </div>
            </div>

            <div class="car-ligne">
                <span class="car-label">Câlin</span>
                <div class="car-barre">
                    <div class="car-barre-remplie"
                         style="width: <?= ($chat['car_calin'] / 5) * 100 ?>%">
                    </div>
                </div>
            </div>

            <div class="car-ligne">
                <span class="car-label">Gourmand</span>
                <div class="car-barre">
                    <div class="car-barre-remplie"
                         style="width: <?= ($chat['car_gourmand'] / 5) * 100 ?>%">
                    </div>
                </div>
            </div>

            <div class="car-ligne">
                <span class="car-label">Paresseux</span>
                <div class="car-barre">
                    <div class="car-barre-remplie"
                         style="width: <?= ($chat['car_paresseux'] / 5) * 100 ?>%">
                    </div>
                </div>
            </div>
        </div>

        <!-- Descriptions -->
        <?php if ($chat['desc_nom']) : ?>
            <h2>Son nom</h2>
            <p><?= htmlspecialchars($chat['desc_nom']) ?></p>
        <?php endif; ?>

        <?php if ($chat['desc_vie_avant']) : ?>
            <h2>Sa vie avant</h2>
            <p><?= htmlspecialchars($chat['desc_vie_avant']) ?></p>
        <?php endif; ?>

        <?php if ($chat['desc_vie_au_bar']) : ?>
            <h2>Sa vie au bar</h2>
            <p><?= htmlspecialchars($chat['desc_vie_au_bar']) ?></p>
        <?php endif; ?>

        <?php if ($chat['desc_aime']) : ?>
            <h2>Il/Elle aime</h2>
            <p><?= htmlspecialchars($chat['desc_aime']) ?></p>
        <?php endif; ?>

    </div>
</div>