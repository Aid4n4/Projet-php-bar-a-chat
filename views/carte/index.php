<?php
// ===========================================================
// views/carte/index.php - La carte dees boissons
// COUCHE : Vue
// Variable disponibles : $categorie, $articles
// ===========================================================
?>

<h1>Notre carte</h1>
<p>Découvrez nos boissons et gourmandises !</p>

<?php foreach ($categories as $categorie) : ?>
    <section class="section-categorie">

        <h2><?= htmlspecialchars($categorie['nom']) ?></h2>

        <div class="grille-articles">
            <?php foreach ($articles as $article) : ?>
                <?php if ($article['id_categorie'] === $categorie['id_categorie']) : ?>
                    <article class="carte-article">
                        <div class="article-info">
                            <h3><?= htmlspecialchars($article['nom']) ?></h3>
                            <?php if ($article['description']) : ?>
                                <p><?=htmlspecialchars($article['description']) ?></p>
                            <?php endif; ?>
                        </div>
                        <span class="article-prix">
                            <?= number_format($article['prix'], 2, ',','') ?> €
                        </span>
                    </article>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </section>
<?php endforeach; ?>
            