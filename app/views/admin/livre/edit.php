<?php
$oldGenres = $_SESSION['old']['genres'] ?? null;
$oldThemes = $_SESSION['old']['themes'] ?? null;
$checkedGenres = is_array($oldGenres) ? $oldGenres : $selectedGenres;
$checkedThemes = is_array($oldThemes) ? $oldThemes : $selectedThemes;
?>

<div class="page-header">
    <div class="container">
        <h1>Modifier le livre</h1>
        <p><?= htmlspecialchars($livre['titre'], ENT_QUOTES, 'UTF-8') ?></p>
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

        <form method="POST" action="index.php?controller=livre&action=editPost">
            <input type="hidden" name="id" value="<?= htmlspecialchars($livre['id_ressource'], ENT_QUOTES, 'UTF-8') ?>">

            <h2 class="form-section-title">Informations générales</h2>

            <div class="form-group">
                <label for="titre">Titre *</label>
                <input
                    type="text"
                    id="titre"
                    name="titre"
                    class="form-control"
                    value="<?= htmlspecialchars($_SESSION['old']['titre'] ?? $livre['titre'], ENT_QUOTES, 'UTF-8') ?>"
                    maxlength="255"
                    required
                >
                <?php if (isset($_SESSION['errors']['titre'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['titre'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="auteur_realisateur">Auteur *</label>
                <input
                    type="text"
                    id="auteur_realisateur"
                    name="auteur_realisateur"
                    class="form-control"
                    value="<?= htmlspecialchars($_SESSION['old']['auteur_realisateur'] ?? $livre['auteur_realisateur'], ENT_QUOTES, 'UTF-8') ?>"
                    maxlength="255"
                    required
                >
                <?php if (isset($_SESSION['errors']['auteur'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['auteur'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="annee">Année de publication *</label>
                <input
                    type="number"
                    id="annee"
                    name="annee"
                    class="form-control"
                    value="<?= htmlspecialchars($_SESSION['old']['annee'] ?? $livre['annee'], ENT_QUOTES, 'UTF-8') ?>"
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
                ><?= htmlspecialchars($_SESSION['old']['resume'] ?? $livre['resume'], ENT_QUOTES, 'UTF-8') ?></textarea>
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
                    value="<?= htmlspecialchars($_SESSION['old']['image_url'] ?? $livre['image_url'], ENT_QUOTES, 'UTF-8') ?>"
                    maxlength="255"
                >
                <?php if (isset($_SESSION['errors']['image_url'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['image_url'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <h2 class="form-section-title">Informations livre</h2>

            <div class="form-group">
                <label for="isbn">ISBN *</label>
                <input
                    type="text"
                    id="isbn"
                    name="isbn"
                    class="form-control"
                    value="<?= htmlspecialchars($_SESSION['old']['isbn'] ?? $livre['isbn'], ENT_QUOTES, 'UTF-8') ?>"
                    maxlength="13"
                    required
                >
                <?php if (isset($_SESSION['errors']['isbn'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['isbn'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="editeur">Éditeur *</label>
                <input
                    type="text"
                    id="editeur"
                    name="editeur"
                    class="form-control"
                    value="<?= htmlspecialchars($_SESSION['old']['editeur'] ?? $livre['editeur'], ENT_QUOTES, 'UTF-8') ?>"
                    maxlength="255"
                    required
                >
                <?php if (isset($_SESSION['errors']['editeur'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['editeur'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="nombre_pages">Nombre de pages *</label>
                <input
                    type="number"
                    id="nombre_pages"
                    name="nombre_pages"
                    class="form-control"
                    value="<?= htmlspecialchars($_SESSION['old']['nombre_pages'] ?? $livre['nombre_pages'], ENT_QUOTES, 'UTF-8') ?>"
                    min="1"
                    max="10000"
                    required
                >
                <?php if (isset($_SESSION['errors']['nombre_pages'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['nombre_pages'], ENT_QUOTES, 'UTF-8') ?></div>
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
                                <?= in_array($genre['id_genre'], $checkedGenres, true) ? 'checked' : '' ?>
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
                                <?= in_array($theme['id_theme'], $checkedThemes, true) ? 'checked' : '' ?>
                            >
                            <?= htmlspecialchars($theme['nom'], ENT_QUOTES, 'UTF-8') ?>
                        </label>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="actions" style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary">Modifier</button>
                <a href="index.php?controller=livre&action=index" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php
unset($_SESSION['errors'], $_SESSION['old']);
?>
