<section class="catalogue-section">
    <div class="page-header">
        <div class="container">
            <h1>Meilleures ressources</h1>
            <p>Ressources les mieux notées</p>
        </div>
    </div>

    <div class="container">
        <?php if (empty($ressources)): ?>
            <div class="empty-state">
                <h3>Aucune ressource évaluée</h3>
                <p>Les évaluations apparaîtront ici</p>
            </div>
        <?php else: ?>
            <div class="grid-3">
                <?php foreach ($ressources as $ressource): ?>
                    <a href="index.php?controller=ressource&action=show&id=<?= htmlspecialchars($ressource['id_ressource'], ENT_QUOTES, 'UTF-8') ?>" class="card">
                        <div class="card-image">
                            <?php
                            $imgPath = Ressource::buildImagePath($ressource);
                            ?>
                            <img src="<?= htmlspecialchars($imgPath, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?>">
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
        <?php endif; ?>
    </div>
</section>
