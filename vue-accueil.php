<!--include file="vues/vue-header.php"-->

<!-- Hero : grande image d'accueil -->
 <section class="hero">
    <div class="hero-contenu">
        <h1>Bienvenue sur le site du Ronron Café !</h1>
        <p class="hero-sous-titre">Un bar à chats cosy au coeur de Lyon</p>
        <a href="controleur.php?page=reservation" class="btn btn-principal">
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
    <a href="controleur.php?page=residents" class="btn btn-principal" style="margin-top: 1rem;">
        Rencontrer nos résidents
    </a>
</section>

<div class="separateur">✦ ✦ ✦</div>

<!-- Horaires -->
 <section class="accueil-horaires">
    <h2>Nos horaires</h2>
    <table>
        <tbody>
            <tr b:name="horaire">
                <td>
                    <!-- Si le jour est fermé -> fermé en rouge -->
                    <span b:if="[horaire.est_ouvert]==0" class="ferme">
                        [horaire.jour] - fermé
                    </span>
                    <span b:if="[horaire.est_ouvert]==1">
                        [horaire.jour] - [horaire.heure_ouverture] à [horaire.heure_fermeture]
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</section>

<!--include file="vues/vue-footer.php"-->