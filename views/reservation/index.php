<?php
// ============================================================
// views/reservation/index.php — Formulaire de réservation
// Variables disponibles : $erreurs, $succes
// ============================================================
?>

<h1>Réserver une place</h1>

<!-- Message de confirmation après soumission réussie -->
<?php if ($succes) : ?>
    <div class="message-succes">
        Votre réservation a bien été prise en compte !
        Nous vous contacterons pour la confirmer.
    </div>
<?php endif; ?>

<!-- Affichage des erreurs de validation -->
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
    <form action="index.php?page=reservation" method="post">
        <fieldset>
            <legend>Vos informations</legend>

            <div class="champ">
                <label for="nom_client">Nom *</label>
                <input type="text" id="nom_client" name="nom_client"
                       value="<?= htmlspecialchars($_POST['nom_client'] ?? '') ?>"
                       required>
            </div>

            <div class="champ">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       required>
            </div>

            <div class="champ">
                <label for="telephone">Téléphone</label>
                <input type="text" id="telephone" name="telephone"
                       value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>">
            </div>
        </fieldset>

        <fieldset style="margin-top: 1rem;">
            <legend>Votre réservation</legend>

            <div class="champ">
                <label for="date_reservation">Date *</label>
                <input type="date" id="date_reservation" name="date_reservation"
                      value="<?= htmlspecialchars($_POST['date_reservation'] ?? '') ?>"
                      min="<?= date('Y-m-d') ?>"
                      required>
            </div>

            <div class="champ">
                <label for="heure">Heure *</label>
                <input type="time" id="heure" name="heure"
                      value="<?= htmlspecialchars($_POST['heure'] ?? '') ?>"
                      min="12:00" max="21:00"
                      required>
            </div>

            <div class="champ">
                <label for="nb_personnes">Nombre de personnes *</label>
                <input type="number" id="nb_personnes" name="nb_personnes"
                      min="1" max="10"
                      value="<?= htmlspecialchars($_POST['nb_personnes'] ?? '') ?>"
                      required>
            </div>

            <div class="champ">
                <label for="commentaire">Commentaire</label>
                <textarea id="commentaire" name="commentaire"
                          placeholder="Allergies, occasions spéciales..."><?=
                    htmlspecialchars($_POST['commentaire'] ?? '')
                ?></textarea>
            </div>
        </fieldset>

        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-principal">
                Envoyer ma réservation
            </button>
        </div>
    </form>
</div>
