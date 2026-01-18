<div class="page-header">
    <div class="container">
        <h1>Créer un genre</h1>
        <p>Ajoutez un nouveau genre pour catégoriser les ressources.</p>
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

        <form method="POST" action="index.php?controller=genre&action=createPost">
            <div class="form-group">
                <label for="nom">Nom du genre *</label>
                <input
                    type="text"
                    id="nom"
                    name="nom"
                    class="form-control"
                    value="<?= htmlspecialchars($_SESSION['old']['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    maxlength="100"
                    required
                >
                <?php if (isset($_SESSION['errors']['nom'])): ?>
                    <div class="form-error"><?= htmlspecialchars($_SESSION['errors']['nom'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Créer</button>
                <a href="index.php?controller=genre&action=index" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php
unset($_SESSION['errors'], $_SESSION['old']);
?>
