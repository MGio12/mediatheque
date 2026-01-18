<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h2>Votre Médiathèque Numérique</h2>
        <p>Gérez et consultez notre catalogue de livres, films et documents en un clic.</p>
        <div class="cta-buttons">
            <a href="?controller=catalogue&action=index" class="btn btn-primary">Parcourir le Catalogue</a>
            <a href="?controller=catalogue&action=search" class="btn btn-secondary">Rechercher</a>
        </div>
    </div>
</section>

<!-- Section Nouveautés -->
<?php if (!empty($nouveautes)): ?>
    <section class="section catalogue-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Nouveautés</h2>
                <p class="section-subtitle">Découvrez les derniers ajouts à notre collection</p>
            </div>

            <div class="grid-3">
                <?php foreach ($nouveautes as $ressource): ?>
                    <a href="index.php?controller=ressource&action=show&id=<?= htmlspecialchars($ressource['id_ressource'], ENT_QUOTES, 'UTF-8') ?>" class="card">
                        <div class="card-image">
                            <?php
                            // Construction du chemin d'image selon le type de ressource
                            $imgPath = Ressource::buildImagePath($ressource);
                            ?>
                            <img src="<?= htmlspecialchars($imgPath, ENT_QUOTES, 'UTF-8') ?>"
                                 alt="<?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?>">
                            <span class="badge badge-<?= htmlspecialchars($ressource['type'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($ressource['type'] === 'livre' ? 'Livre' : 'Film', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>

                        <div class="card-body">
                            <h3 class="card-title"><?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p class="card-author">
                                Par <?= htmlspecialchars($ressource['auteur_realisateur'], ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <p class="card-year">
                                Année : <?= htmlspecialchars($ressource['annee'], ENT_QUOTES, 'UTF-8') ?>
                            </p>

                            <?php if (!empty($ressource['genres'])): ?>
                                <p class="card-genres">
                                    Genres : <?= htmlspecialchars(implode(', ', array_column($ressource['genres'], 'nom')), ENT_QUOTES, 'UTF-8') ?>
                                </p>
                            <?php endif; ?>

                            <?php if (isset($ressource['note_moyenne']) && $ressource['nb_evaluations'] > 0): ?>
                                <div class="rating">
                                    <span class="stars">
                                        <?php
                                        // Affichage des étoiles selon la note moyenne
                                        $note = round($ressource['note_moyenne']);
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo $i <= $note ? '★' : '☆';
                                        }
                                        ?>
                                    </span>
                                    <span class="rating-text">
                                        <?= htmlspecialchars(number_format($ressource['note_moyenne'], 1), ENT_QUOTES, 'UTF-8') ?>/5
                                        (<?= htmlspecialchars($ressource['nb_evaluations'], ENT_QUOTES, 'UTF-8') ?>)
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="section-actions">
                <a href="?controller=catalogue&action=nouveautes" class="btn btn-primary">Voir Toutes les Nouveautés</a>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Section Meilleures Ressources -->
<?php if (!empty($topRessources)): ?>
    <section class="section catalogue-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Meilleures Ressources</h2>
                <p class="section-subtitle">Les titres préférés de notre communauté</p>
            </div>

            <div class="grid-3">
                <?php foreach ($topRessources as $ressource): ?>
                    <a href="index.php?controller=ressource&action=show&id=<?= htmlspecialchars($ressource['id_ressource'], ENT_QUOTES, 'UTF-8') ?>" class="card">
                        <div class="card-image">
                            <?php
                            // Construction du chemin d'image selon le type de ressource
                            $imgPath = Ressource::buildImagePath($ressource);
                            ?>
                            <img src="<?= htmlspecialchars($imgPath, ENT_QUOTES, 'UTF-8') ?>"
                                 alt="<?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?>">
                            <span class="badge badge-<?= htmlspecialchars($ressource['type'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($ressource['type'] === 'livre' ? 'Livre' : 'Film', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>

                        <div class="card-body">
                            <h3 class="card-title"><?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p class="card-author">
                                Par <?= htmlspecialchars($ressource['auteur_realisateur'], ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <p class="card-year">
                                Année : <?= htmlspecialchars($ressource['annee'], ENT_QUOTES, 'UTF-8') ?>
                            </p>

                            <?php if (!empty($ressource['genres'])): ?>
                                <p class="card-genres">
                                    Genres : <?= htmlspecialchars(implode(', ', array_column($ressource['genres'], 'nom')), ENT_QUOTES, 'UTF-8') ?>
                                </p>
                            <?php endif; ?>

                            <div class="rating">
                                <span class="stars">
                                    <?php
                                    // Affichage des étoiles selon la note moyenne
                                    $note = round($ressource['note_moyenne']);
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $note ? '★' : '☆';
                                    }
                                    ?>
                                </span>
                                <span class="rating-text">
                                    <?= htmlspecialchars(number_format($ressource['note_moyenne'], 1), ENT_QUOTES, 'UTF-8') ?>/5
                                    (<?= htmlspecialchars($ressource['nb_evaluations'], ENT_QUOTES, 'UTF-8') ?>)
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="section-actions">
                <a href="?controller=catalogue&action=top" class="btn btn-primary">Voir Toutes les Meilleures Ressources</a>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Section Fil d'actualité -->
<?php if (!empty($derniersAvis)): ?>
    <section class="section feed-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Derniers avis de la communaute</h2>
                <p class="section-subtitle">Decouvrez ce que pensent nos membres</p>
            </div>

            <div class="feed-list">
                <?php foreach ($derniersAvis as $avis): ?>
                    <div class="feed-item">
                        <div class="feed-avatar">
                            <?= strtoupper(substr($avis['utilisateur_prenom'], 0, 1) . substr($avis['utilisateur_nom'], 0, 1)) ?>
                        </div>

                        <div class="feed-content">
                            <div class="feed-header">
                                <span class="feed-user">
                                    <?= htmlspecialchars($avis['utilisateur_prenom'] . ' ' . $avis['utilisateur_nom'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                                <span class="feed-action">a note</span>
                                <a href="index.php?controller=ressource&action=show&id=<?= htmlspecialchars($avis['id_ressource'], ENT_QUOTES, 'UTF-8') ?>" class="feed-ressource">
                                    <span class="feed-badge feed-badge-<?= htmlspecialchars($avis['type'], ENT_QUOTES, 'UTF-8') ?>">
                                        <?= $avis['type'] === 'livre' ? 'Livre' : 'Film' ?>
                                    </span>
                                    <?= htmlspecialchars($avis['titre'], ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </div>

                            <div class="feed-rating">
                                <?php
                                $note = round($avis['note']);
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $note ? '<span class="star-filled">&#9733;</span>' : '<span class="star-empty">&#9734;</span>';
                                }
                                ?>
                                <span class="feed-note"><?= htmlspecialchars(number_format($avis['note'], 1), ENT_QUOTES, 'UTF-8') ?>/5</span>
                            </div>

                            <?php if (!empty($avis['critique'])): ?>
                                <div class="feed-critique">
                                    <?php
                                    $critique = $avis['critique'];
                                    if (strlen($critique) > 150) {
                                        $critique = substr($critique, 0, 150) . '...';
                                    }
                                    ?>
                                    "<?= htmlspecialchars($critique, ENT_QUOTES, 'UTF-8') ?>"
                                </div>
                            <?php endif; ?>

                            <div class="feed-date">
                                <?= date('d M Y a H:i', strtotime($avis['date_evaluation'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="section feed-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Derniers avis de la communaute</h2>
                <p class="section-subtitle">Decouvrez ce que pensent nos membres</p>
            </div>
            <div class="feed-empty">
                <p>Aucun avis pour le moment. Soyez le premier a donner votre avis !</p>
            </div>
        </div>
    </section>
<?php endif; ?>
