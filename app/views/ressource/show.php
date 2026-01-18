<div class="container">
    <div class="breadcrumb-nav">
        <a href="index.php?controller=catalogue&action=index" class="back-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Retour au catalogue
        </a>
    </div>

    <div class="content-wrapper">
        <div class="ressource-header-card">
            <div class="ressource-grid">
                <!-- Image -->
                <div class="image-wrapper">
                    <?php
                    $imgPath = Ressource::buildImagePath($ressource);
                    ?>
                    <div class="image-blur-bg" style="background-image: url('<?= htmlspecialchars($imgPath, ENT_QUOTES, 'UTF-8') ?>');"></div>
                    <div class="image-container">
                        <img src="<?= htmlspecialchars($imgPath, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>

                <!-- Informations -->
                <div class="info-container">
                    <div class="header-badges">
                        <span class="badge badge-<?= htmlspecialchars($ressource['type'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($ressource['type'] === 'livre' ? 'Livre' : 'Film', ENT_QUOTES, 'UTF-8') ?>
                        </span>
                        
                        <!-- Genres inline -->
                        <?php if (!empty($ressource['genres'])): ?>
                            <?php foreach ($ressource['genres'] as $genre): ?>
                                <span class="badge-static">
                                    <?= htmlspecialchars($genre['nom'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <h1 class="ressource-title">
                        <?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?>
                    </h1>

                    <div class="main-meta">
                        <span class="author-name">
                            <?= $ressource['type'] === 'livre' ? 'De' : 'Réalisé par' ?> 
                            <strong><?= htmlspecialchars($ressource['auteur_realisateur'], ENT_QUOTES, 'UTF-8') ?></strong>
                        </span>
                        <span class="meta-separator">•</span>
                        <span class="year"><?= htmlspecialchars($ressource['annee'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>

                    <div class="rating-display">
                        <div class="stars">
                            <?php
                            $note = round($ressource['note_moyenne']);
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $note ? '★' : '☆';
                            }
                            ?>
                        </div>
                        <span class="rating-details">
                            <strong><?= htmlspecialchars(number_format($ressource['note_moyenne'], 1), ENT_QUOTES, 'UTF-8') ?></strong>/5
                            <span class="rating-count">(<?= htmlspecialchars($ressource['nb_evaluations'], ENT_QUOTES, 'UTF-8') ?> avis)</span>
                        </span>
                    </div>

                    <div class="details-grid">
                        <?php if (!empty($ressource['pays'])): ?>
                            <div class="detail-item">
                                <span class="detail-label">Pays</span>
                                <span class="detail-value"><?= htmlspecialchars($ressource['pays'], ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($ressource['type'] === 'livre'): ?>
                            <?php if (!empty($ressource['isbn'])): ?>
                                <div class="detail-item">
                                    <span class="detail-label">ISBN</span>
                                    <span class="detail-value"><?= htmlspecialchars($ressource['isbn'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($ressource['editeur'])): ?>
                                <div class="detail-item">
                                    <span class="detail-label">Éditeur</span>
                                    <span class="detail-value"><?= htmlspecialchars($ressource['editeur'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($ressource['nombre_pages'])): ?>
                                <div class="detail-item">
                                    <span class="detail-label">Pages</span>
                                    <span class="detail-value"><?= htmlspecialchars($ressource['nombre_pages'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($ressource['prix'])): ?>
                                <div class="detail-item">
                                    <span class="detail-label">Prix</span>
                                    <span class="detail-value"><?= htmlspecialchars(number_format($ressource['prix'], 2, ',', ' '), ENT_QUOTES, 'UTF-8') ?> €</span>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if (!empty($ressource['duree'])): ?>
                                <div class="detail-item">
                                    <span class="detail-label">Durée</span>
                                    <span class="detail-value"><?= htmlspecialchars($ressource['duree'], ENT_QUOTES, 'UTF-8') ?> min</span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($ressource['support'])): ?>
                                <div class="detail-item">
                                    <span class="detail-label">Support</span>
                                    <span class="detail-value"><?= htmlspecialchars($ressource['support'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($ressource['langue'])): ?>
                                <div class="detail-item">
                                    <span class="detail-label">Langue</span>
                                    <span class="detail-value"><?= htmlspecialchars($ressource['langue'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($ressource['propose_par'])): ?>
                                <div class="detail-item">
                                    <span class="detail-label">Proposé par</span>
                                    <span class="detail-value"><?= htmlspecialchars($ressource['propose_par'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($ressource['casting'])): ?>
                                <div class="detail-item">
                                    <span class="detail-label">Casting</span>
                                    <span class="detail-value"><?= htmlspecialchars($ressource['casting'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Thèmes -->
                    <?php if (!empty($ressource['themes'])): ?>
                        <div class="themes-container">
                            <?php foreach ($ressource['themes'] as $theme): ?>
                                <span class="theme-tag">
                                    #<?= htmlspecialchars($theme['nom'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Résumé Full Width en bas de la carte -->
            <?php if (!empty($ressource['resume'])): ?>
                <div class="resume-section-inline">
                    <h3 class="section-heading">Résumé</h3>
                    <div class="resume-content">
                        <?= nl2br(htmlspecialchars($ressource['resume'], ENT_QUOTES, 'UTF-8')) ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Formulaire d'évaluation -->
        <?php if ($canEvaluate): ?>
            <div class="evaluation-form-container">
                <h3 class="section-heading">Votre avis compte</h3>
                <form method="POST" action="index.php?controller=evaluation&action=createPost" class="modern-form">
                    <input type="hidden" name="id_ressource" value="<?= htmlspecialchars($ressource['id_ressource'], ENT_QUOTES, 'UTF-8') ?>">

                    <div class="rating-input-wrapper">
                        <label>Quelle note donnez-vous ?</label>
                        <div class="star-rating-input">
                            <?php for($i=5; $i>=1; $i--): ?>
                                <input type="radio" name="note" value="<?= $i ?>" id="star-<?= $i ?>">
                                <label for="star-<?= $i ?>">★</label>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="critique">Votre commentaire</label>
                        <textarea
                            name="critique"
                            id="critique"
                            class="form-control"
                            rows="4"
                            maxlength="1000"
                            placeholder="Partagez votre expérience..."
                            oninput="updateCharCounter()"
                        ></textarea>
                        <div class="char-counter">
                            <span id="char-count">0</span> / 1000
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg">Publier mon avis</button>
                </form>
            </div>
        <?php elseif ($hasEvaluated): ?>
            <div class="user-feedback-status success">
                <span class="icon">✓</span> Vous avez déjà donné votre avis sur cette œuvre.
            </div>
        <?php elseif (!Auth::check()): ?>
            <div class="user-feedback-status info">
                <a href="index.php?controller=auth&action=login">Connectez-vous</a> pour partager votre avis.
            </div>
        <?php endif; ?>

        <!-- Évaluations -->
        <div class="reviews-section">
            <h3 class="section-heading">
                Avis de la communauté
                <?php if (!empty($evaluations)): ?>
                    <span class="count-badge"><?= count($evaluations) ?></span>
                <?php endif; ?>
            </h3>

            <?php if (empty($evaluations)): ?>
                <div class="empty-reviews">
                    <div class="empty-icon">💬</div>
                    <p>Soyez le premier à donner votre avis !</p>
                </div>
            <?php else: ?>
                <div class="reviews-grid">
                    <?php foreach ($evaluations as $eval): ?>
                        <div class="review-card">
                            <div class="review-header">
                                <div class="reviewer-avatar">
                                    <?= strtoupper(substr($eval['prenom'], 0, 1)) ?>
                                </div>
                                <div class="reviewer-info">
                                    <span class="reviewer-name">
                                        <?= htmlspecialchars($eval['prenom'], ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($eval['nom'], ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                    <span class="review-date">
                                        <?= date('d M Y', strtotime($eval['date_evaluation'])) ?>
                                    </span>
                                </div>
                                <div class="review-rating">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $eval['note'] ? '★' : '☆';
                                    }
                                    ?>
                                </div>
                            </div>

                            <?php if (!empty($eval['critique'])): ?>
                                <div class="review-content">
                                    <?= nl2br(htmlspecialchars($eval['critique'], ENT_QUOTES, 'UTF-8')) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function updateCharCounter() {
    const textarea = document.getElementById('critique');
    const counter = document.getElementById('char-count');
    if (textarea && counter) {
        counter.textContent = textarea.value.length;
    }
}
</script>
