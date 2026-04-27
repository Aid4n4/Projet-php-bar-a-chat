<?php
// ============================================================
// views/chats/liste.php — Liste des résidents
// Variables disponibles : $chats
// ============================================================
?>

<h1>Nos résidents</h1>
<p>Venez rencontrer nos adorables félins !</p>

<div class="grille-residents">
    <?php foreach ($chats as $chat) : ?>
        <article class="carte-chat">
            <img
                src="<?= htmlspecialchars($chat['photo'] ? 'public/images/' . $chat['photo'] : 'public/images/default.jpg') ?>"
                alt="Photo de <?= htmlspecialchars($chat['nom']) ?>">
            <div class="carte-chat-info">
                <h3><?= htmlspecialchars($chat['nom']) ?></h3>
                <p><?= htmlspecialchars($chat['race'] ?? '') ?></p>
                <a href="index.php?page=chat&id=<?= $chat['id_chat'] ?>">
                    Découvrir →
                </a>
            </div>
        </article>
    <?php endforeach; ?>
</div>
