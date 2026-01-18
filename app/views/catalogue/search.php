<section class="catalogue-section">
    <div class="page-header">
        <div class="container">
            <h1>Recherche multicritère</h1>
            <p>Rechercher parmi les ressources disponibles</p>
        </div>
    </div>

    <div class="container">
        <form method="GET" action="index.php" class="search-form">
            <input type="hidden" name="controller" value="catalogue">
            <input type="hidden" name="action" value="search">

            <div class="form-row">
                <div class="form-group">
                    <label for="q">Mot-clé</label>
                    <input type="text"
                           id="q"
                           name="q"
                           class="form-control"
                           placeholder="Titre, auteur, résumé..."
                           value="<?= htmlspecialchars($_GET['q'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label for="type">Type</label>
                    <select id="type" name="type" class="form-control">
                        <option value="">Tous les types</option>
                        <option value="livre" <?= (isset($_GET['type']) && $_GET['type'] === 'livre') ? 'selected' : '' ?>>Livre</option>
                        <option value="film" <?= (isset($_GET['type']) && $_GET['type'] === 'film') ? 'selected' : '' ?>>Film</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="genre">Genre</label>
                    <select id="genre" name="genre" class="form-control">
                        <option value="">Tous les genres</option>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?= htmlspecialchars($genre['id_genre'], ENT_QUOTES, 'UTF-8') ?>"
                                    <?= (isset($_GET['genre']) && $_GET['genre'] == $genre['id_genre']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($genre['nom'], ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="theme">Thème</label>
                    <select id="theme" name="theme" class="form-control">
                        <option value="">Tous les thèmes</option>
                        <?php foreach ($themes as $theme): ?>
                            <option value="<?= htmlspecialchars($theme['id_theme'], ENT_QUOTES, 'UTF-8') ?>"
                                    <?= (isset($_GET['theme']) && $_GET['theme'] == $theme['id_theme']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($theme['nom'], ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="annee_min">Année minimum</label>
                    <input type="number"
                           id="annee_min"
                           name="annee_min"
                           class="form-control"
                           placeholder="2000"
                           min="1800"
                           max="2100"
                           value="<?= htmlspecialchars($_GET['annee_min'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label for="annee_max">Année maximum</label>
                    <input type="number"
                           id="annee_max"
                           name="annee_max"
                           class="form-control"
                           placeholder="2024"
                           min="1800"
                           max="2100"
                           value="<?= htmlspecialchars($_GET['annee_max'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Rechercher</button>
                <a href="index.php?controller=catalogue&action=search" class="btn btn-secondary">Réinitialiser</a>
            </div>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'search'): ?>
            <div style="margin-top: 30px; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #e0e0e0;">
                <p style="font-size: 1.1em; color: #7f8c8d;">
                    <?= count($ressources) ?> résultat<?= count($ressources) > 1 ? 's' : '' ?> trouvé<?= count($ressources) > 1 ? 's' : '' ?>
                </p>
            </div>

            <?php if (empty($ressources)): ?>
                <div class="empty-state">
                    <h3>Aucun résultat trouvé</h3>
                    <p>Essayez de modifier vos critères de recherche</p>
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
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
