<?php
// ============================================================
// views/admin/login.php — Formulaire de connexion admin
// Variables disponibles : $erreur
// ============================================================
?>

<h1>Espace administrateur</h1>

<!-- Affichage du message d'erreur si identifiants incorrects -->
<?php if ($erreur) : ?>
    <div class="message-erreur">
        <?= htmlspecialchars($erreur) ?>
    </div>
<?php endif; ?>

<div class="formulaire">
    <form action="index.php?page=login" method="post">
        <fieldset>
            <legend>Connexion</legend>

            <div class="champ">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" required>
            </div>

            <div class="champ">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <div style="margin-top: 1rem;">
                <button type="submit" class="btn btn-principal">
                    Se connecter
                </button>
            </div>

        </fieldset>
    </form>
</div>