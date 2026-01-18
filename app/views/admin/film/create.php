<?php
$oldGenres = $_SESSION['old']['genres'] ?? [];
$oldThemes = $_SESSION['old']['themes'] ?? [];
if (!is_array($oldGenres)) {
    $oldGenres = [];
}
if (!is_array($oldThemes)) {
    $oldThemes = [];
}
?>

<div class="page-header">
    <div class="container">
        <h1>Créer un film</h1>
        <p>Ajoutez un nouveau film et associez-le à ses genres et thèmes.</p>
    </div>
</div>

<div class="container">
    <div class="content">
        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?controller=film&action=createPost">
            <h2 class="form-section-title">Informations générales</h2>

            <div class="form-group">
                <label for="titre">Titre *</label>
                <input
                    type="text"
                    id="titre"
                    name="titre"
                    class="form-control"
                    value="<?= htmlspecialchars($_SESSION['old']['titre'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    maxlength="255"
                    required
                >
                <?php if (isset($_SESSION['errors']['titre'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['titre'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="auteur_realisateur">Réalisateur *</label>
                <input
                    type="text"
                    id="auteur_realisateur"
                    name="auteur_realisateur"
                    class="form-control"
                    value="<?= htmlspecialchars($_SESSION['old']['auteur_realisateur'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    maxlength="255"
                    required
                >
                <?php if (isset($_SESSION['errors']['realisateur'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['realisateur'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="annee">Année de sortie *</label>
                <input
                    type="number"
                    id="annee"
                    name="annee"
                    class="form-control"
                    value="<?= htmlspecialchars($_SESSION['old']['annee'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    min="1800"
                    max="2100"
                    required
                >
                <?php if (isset($_SESSION['errors']['annee'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['annee'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="resume">Résumé</label>
                <textarea
                    id="resume"
                    name="resume"
                    class="form-control"
                    maxlength="5000"
                ><?= htmlspecialchars($_SESSION['old']['resume'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                <?php if (isset($_SESSION['errors']['resume'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['resume'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="image_url">Image (URL)</label>
                <input
                    type="text"
                    id="image_url"
                    name="image_url"
                    class="form-control"
                    value="<?= htmlspecialchars($_SESSION['old']['image_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    maxlength="255"
                >
                <?php if (isset($_SESSION['errors']['image_url'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['image_url'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <h2 class="form-section-title">Informations film</h2>

            <div class="form-group">
                <label for="duree">Durée (minutes) *</label>
                <input
                    type="number"
                    id="duree"
                    name="duree"
                    class="form-control"
                    value="<?= htmlspecialchars($_SESSION['old']['duree'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    min="1"
                    max="1000"
                    required
                >
                <?php if (isset($_SESSION['errors']['duree'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['duree'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="support">Support *</label>
                <select id="support" name="support" class="form-control" required>
                    <option value="">-- Sélectionner un support --</option>
                    <option value="DVD" <?= (isset($_SESSION['old']['support']) && $_SESSION['old']['support'] === 'DVD') ? 'selected' : '' ?>>DVD</option>
                    <option value="Blu-ray" <?= (isset($_SESSION['old']['support']) && $_SESSION['old']['support'] === 'Blu-ray') ? 'selected' : '' ?>>Blu-ray</option>
                    <option value="Streaming" <?= (isset($_SESSION['old']['support']) && $_SESSION['old']['support'] === 'Streaming') ? 'selected' : '' ?>>Streaming</option>
                </select>
                <?php if (isset($_SESSION['errors']['support'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['support'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="langue">Langue *</label>
                <input
                    type="text"
                    id="langue"
                    name="langue"
                    class="form-control"
                    value="<?= htmlspecialchars($_SESSION['old']['langue'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    maxlength="50"
                    required
                >
                <?php if (isset($_SESSION['errors']['langue'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['langue'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <h2 class="form-section-title">Genres</h2>
            <div class="checkbox-grid">
                <?php if (empty($genres)): ?>
                    <p style="color: #7f8c8d;">Aucun genre disponible</p>
                <?php else: ?>
                    <?php foreach ($genres as $genre): ?>
                        <label>
                            <input
                                type="checkbox"
                                name="genres[]"
                                value="<?= htmlspecialchars($genre['id_genre'], ENT_QUOTES, 'UTF-8') ?>"
                                <?= in_array($genre['id_genre'], $oldGenres, true) ? 'checked' : '' ?>
                            >
                            <?= htmlspecialchars($genre['nom'], ENT_QUOTES, 'UTF-8') ?>
                        </label>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <h2 class="form-section-title">Thèmes</h2>
            <div class="checkbox-grid">
                <?php if (empty($themes)): ?>
                    <p style="color: #7f8c8d;">Aucun thème disponible</p>
                <?php else: ?>
                    <?php foreach ($themes as $theme): ?>
                        <label>
                            <input
                                type="checkbox"
                                name="themes[]"
                                value="<?= htmlspecialchars($theme['id_theme'], ENT_QUOTES, 'UTF-8') ?>"
                                <?= in_array($theme['id_theme'], $oldThemes, true) ? 'checked' : '' ?>
                            >
                            <?= htmlspecialchars($theme['nom'], ENT_QUOTES, 'UTF-8') ?>
                        </label>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="actions" style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary">Créer</button>
                <a href="index.php?controller=film&action=index" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php
unset($_SESSION['errors'], $_SESSION['old']);
?>
