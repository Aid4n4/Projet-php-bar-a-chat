<?php
// ============================================================
// views/accueil/index.php — Page d'accueil
// Variables disponibles : $horaires, $infos
// ============================================================
?>

<!-- Hero : grande image d'accueil -->
<section class="hero">
    <div class="hero-contenu">
        <h1>Bienvenue au Ronron Café !</h1>
        <p class="hero-sous-titre">Un bar à chats cosy au cœur de Lyon</p>
        <a href="index.php?page=reservation" class="btn btn-principal" style="margin-top: 1rem; color: white;">
            Réserver une place
        </a>
    </div>
</section>

<div class="separateur">✦ ✦ ✦</div>

<!-- Description du bar -->
<section class="accueil-description">
    <h2>Notre histoire</h2>
    <p>
        Le Ronron Café est un lieu chaleureux où vous pouvez déguster
        de délicieuses boissons tout en profitant de la compagnie de
        nos adorables résidents félins. Un moment de détente garanti !
    </p>
    <a href="index.php?page=residents" class="btn btn-principal" style="margin-top: 1rem; color: white;">
        Rencontrer nos résidents
    </a>
</section>

<div class="separateur">✦ ✦ ✦</div>

<!-- Horaires récupérés depuis la BDD via $horaires -->
<section class="accueil-horaires">
    <h2>Nos horaires</h2>
    <table>
        <tbody>
            <?php foreach ($horaires as $horaire) : ?>
                <tr>
                    <td>
                        <?php if ($horaire['est_ouvert']) : ?>
                            <?= htmlspecialchars($horaire['jour']) ?>
                            — <?= substr($horaire['heure_ouverture'], 0, 5) ?>
                            à <?= substr($horaire['heure_fermeture'], 0, 5) ?>
                        <?php else : ?>
                            <span class="ferme">
                                <?= htmlspecialchars($horaire['jour']) ?> — Fermé
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
