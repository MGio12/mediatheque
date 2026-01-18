<!-- Hero Section -->
<div class="hero">
    <h2>Catalogue</h2>
    <p>Livres et films disponibles</p>
    <div class="cta-buttons">
        <a href="index.php?controller=catalogue&action=index" class="btn btn-primary">Explorer le catalogue</a>
        <a href="index.php?controller=catalogue&action=search" class="btn btn-secondary">Rechercher</a>
    </div>
</div>

<!-- Section Nouveautés -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Nouveautés</h2>
            <p class="section-subtitle">Dernières acquisitions</p>
        </div>

        <?php if (!empty($nouveautes)): ?>
            <div class="grid-3">
                <?php foreach ($nouveautes as $ressource): ?>
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
                            <p class="card-author">Par <?= htmlspecialchars($ressource['auteur_realisateur'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-year">Année : <?= htmlspecialchars($ressource['annee'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php if (isset($ressource['note_moyenne']) && $ressource['nb_evaluations'] > 0): ?>
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
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="section-actions">
                <a href="index.php?controller=catalogue&action=nouveautes" class="btn-link">Voir toutes les nouveautés</a>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3>Aucune nouveauté actuellement</h3>
                <p>Les nouvelles ressources apparaîtront ici</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Section Top -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Meilleures ressources</h2>
            <p class="section-subtitle">Ressources les mieux notées</p>
        </div>

        <?php if (!empty($topRessources)): ?>
            <div class="grid-3">
                <?php foreach ($topRessources as $ressource): ?>
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
                            <p class="card-author">Par <?= htmlspecialchars($ressource['auteur_realisateur'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-year">Année : <?= htmlspecialchars($ressource['annee'], ENT_QUOTES, 'UTF-8') ?></p>
                            <div class="rating">
                                <span class="stars">
                                    <?php
                                    $note = round($ressource['note_moyenne']);
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $note ? '★' : '☆';
                                    }
                                    ?>
                                </span>
                                <span class="rating-text" style="font-weight: 600; color: #2c3e50;">
                                    <?= htmlspecialchars(number_format($ressource['note_moyenne'], 1), ENT_QUOTES, 'UTF-8') ?>/5
                                    (<?= htmlspecialchars($ressource['nb_evaluations'], ENT_QUOTES, 'UTF-8') ?>)
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="section-actions">
                <a href="index.php?controller=catalogue&action=top" class="btn-link">Voir le classement complet</a>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3>Aucune ressource évaluée</h3>
                <p>Les évaluations apparaîtront ici</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Section Sélection par thème -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Sélections thématiques</h2>
            <p class="section-subtitle">Ressources par thème</p>
        </div>

        <?php if (!empty($themes)): ?>
            <div class="theme-grid">
                <?php foreach ($themes as $theme): ?>
                    <a href="index.php?controller=catalogue&action=selection&theme=<?= htmlspecialchars($theme['id_theme'], ENT_QUOTES, 'UTF-8') ?>" class="theme-card">
                        <div class="theme-name"><?= htmlspecialchars($theme['nom'], ENT_QUOTES, 'UTF-8') ?></div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3>Aucun thème disponible</h3>
                <p>Les thèmes seront ajoutés prochainement</p>
            </div>
        <?php endif; ?>
    </div>
</section>
