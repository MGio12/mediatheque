<div class="container">
    <a href="index.php?controller=catalogue&action=index" class="btn-link" style="display: inline-block; margin-bottom: 20px;">← Retour au catalogue</a>

    <div class="content">
        <div class="ressource-grid">
            <!-- Image -->
            <div class="image-container">
                <?php
                $imgPath = Ressource::buildImagePath($ressource);
                ?>
                <img src="<?= htmlspecialchars($imgPath, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <!-- Informations -->
            <div>
                <span class="badge badge-<?= htmlspecialchars($ressource['type'], ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($ressource['type'] === 'livre' ? 'Livre' : 'Film', ENT_QUOTES, 'UTF-8') ?>
                </span>

                <h1>
                    <?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?>
                </h1>

                <div class="rating" style="font-size: 1.8em; margin-bottom: 20px;">
                    <?php
                    $note = round($ressource['note_moyenne']);
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $note ? '★' : '☆';
                    }
                    ?>
                    <span class="rating-text" style="font-size: 0.5em; margin-left: 10px;">
                        <?= htmlspecialchars(number_format($ressource['note_moyenne'], 1), ENT_QUOTES, 'UTF-8') ?>/5
                        (<?= htmlspecialchars($ressource['nb_evaluations'], ENT_QUOTES, 'UTF-8') ?> évaluation<?= $ressource['nb_evaluations'] > 1 ? 's' : '' ?>)
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">
                        <?= $ressource['type'] === 'livre' ? 'Auteur :' : 'Réalisateur :' ?>
                    </span>
                    <?= htmlspecialchars($ressource['auteur_realisateur'], ENT_QUOTES, 'UTF-8') ?>
                </div>

                <div class="info-row">
                    <span class="info-label">Année :</span>
                    <?= htmlspecialchars($ressource['annee'], ENT_QUOTES, 'UTF-8') ?>
                </div>

                <?php if ($ressource['type'] === 'livre'): ?>
                    <?php if (!empty($ressource['isbn'])): ?>
                        <div class="info-row">
                            <span class="info-label">ISBN :</span>
                            <?= htmlspecialchars($ressource['isbn'], ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($ressource['editeur'])): ?>
                        <div class="info-row">
                            <span class="info-label">Éditeur :</span>
                            <?= htmlspecialchars($ressource['editeur'], ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($ressource['nombre_pages'])): ?>
                        <div class="info-row">
                            <span class="info-label">Nombre de pages :</span>
                            <?= htmlspecialchars($ressource['nombre_pages'], ENT_QUOTES, 'UTF-8') ?> pages
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if (!empty($ressource['duree'])): ?>
                        <div class="info-row">
                            <span class="info-label">Durée :</span>
                            <?= htmlspecialchars($ressource['duree'], ENT_QUOTES, 'UTF-8') ?> minutes
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($ressource['support'])): ?>
                        <div class="info-row">
                            <span class="info-label">Support :</span>
                            <?= htmlspecialchars($ressource['support'], ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($ressource['langue'])): ?>
                        <div class="info-row">
                            <span class="info-label">Langue :</span>
                            <?= htmlspecialchars($ressource['langue'], ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Genres -->
                <?php if (!empty($ressource['genres'])): ?>
                    <div style="margin-top: 20px;">
                        <span class="info-label">Genres :</span><br>
                        <?php foreach ($ressource['genres'] as $genre): ?>
                            <span class="badge-static">
                                <?= htmlspecialchars($genre['nom'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Thèmes -->
                <?php if (!empty($ressource['themes'])): ?>
                    <div style="margin-top: 15px;">
                        <span class="info-label">Thèmes :</span><br>
                        <?php foreach ($ressource['themes'] as $theme): ?>
                            <span class="badge-static">
                                <?= htmlspecialchars($theme['nom'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Résumé -->
                <?php if (!empty($ressource['resume'])): ?>
                    <div class="resume">
                        <h3>Résumé</h3>
                        <p><?= nl2br(htmlspecialchars($ressource['resume'], ENT_QUOTES, 'UTF-8')) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Formulaire d'évaluation -->
        <?php if ($canEvaluate): ?>
            <div class="evaluation-form">
                <h3>Évaluer cette ressource</h3>
                <form method="POST" action="index.php?controller=evaluation&action=createPost">
                    <input type="hidden" name="id_ressource" value="<?= htmlspecialchars($ressource['id_ressource'], ENT_QUOTES, 'UTF-8') ?>">

                    <div class="form-group">
                        <label>Note <span style="color: #e74c3c;">*</span></label>
                        <div class="rating-selector">
                            <div class="rating-option">
                                <input type="radio" name="note" value="0" id="note-0">
                                <label for="note-0">0 ☆</label>
                            </div>
                            <div class="rating-option">
                                <input type="radio" name="note" value="1" id="note-1">
                                <label for="note-1">1 ★</label>
                            </div>
                            <div class="rating-option">
                                <input type="radio" name="note" value="2" id="note-2">
                                <label for="note-2">2 ★</label>
                            </div>
                            <div class="rating-option">
                                <input type="radio" name="note" value="3" id="note-3">
                                <label for="note-3">3 ★</label>
                            </div>
                            <div class="rating-option">
                                <input type="radio" name="note" value="4" id="note-4">
                                <label for="note-4">4 ★</label>
                            </div>
                            <div class="rating-option">
                                <input type="radio" name="note" value="5" id="note-5">
                                <label for="note-5">5 ★</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="critique">Commentaire (optionnel)</label>
                        <textarea
                            name="critique"
                            id="critique"
                            class="form-control"
                            maxlength="1000"
                            placeholder="Votre avis..."
                            oninput="updateCharCounter()"
                        ></textarea>
                        <div class="char-counter">
                            <span id="char-count">0</span> / 1000 caractères
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Publier</button>
                </form>
            </div>
        <?php elseif ($hasEvaluated): ?>
            <div class="alert alert-info">
                Vous avez évalué cette ressource
            </div>
        <?php elseif (!Auth::check()): ?>
            <div class="alert alert-info">
                <a href="index.php?controller=auth&action=login" class="alert-link">Connectez-vous</a> pour évaluer cette ressource
            </div>
        <?php endif; ?>

        <!-- Évaluations -->
        <div class="section">
            <h3 class="section-title" style="font-size: 1.5em; border-bottom: 2px solid var(--color-primary); padding-bottom: 10px;">
                Évaluations
            </h3>

            <?php if (empty($evaluations)): ?>
                <div class="no-evaluations">
                    <p>Aucune évaluation pour le moment</p>
                </div>
            <?php else: ?>
                <?php foreach ($evaluations as $eval): ?>
                    <div class="evaluation-card">
                        <div class="evaluation-header">
                            <span class="evaluation-author">
                                <?= htmlspecialchars($eval['prenom'], ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($eval['nom'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                            <span class="evaluation-stars">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $eval['note'] ? '★' : '☆';
                                }
                                ?>
                            </span>
                        </div>

                        <?php if (!empty($eval['critique'])): ?>
                            <div class="evaluation-critique">
                                <?= nl2br(htmlspecialchars($eval['critique'], ENT_QUOTES, 'UTF-8')) ?>
                            </div>
                        <?php endif; ?>

                        <div class="evaluation-date">
                            <?= date('d/m/Y à H:i', strtotime($eval['date_evaluation'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
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
