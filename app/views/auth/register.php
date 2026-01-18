<div class="container" style="max-width: 500px; margin-top: 60px;">
    <div class="content">
        <h1 style="text-align: center; margin-bottom: 30px;">Inscription</h1>

        <?php if (isset($error) && $error): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success) && $success): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?controller=auth&action=registerPost">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input
                    type="text"
                    id="nom"
                    name="nom"
                    class="form-control"
                    required
                    placeholder="Votre nom"
                    value="<?= htmlspecialchars($_POST['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                >
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input
                    type="text"
                    id="prenom"
                    name="prenom"
                    class="form-control"
                    required
                    placeholder="Votre prénom"
                    value="<?= htmlspecialchars($_POST['prenom'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    required
                    placeholder="votre@email.com"
                    value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                >
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    required
                    placeholder="Minimum 8 caractères"
                    minlength="8"
                >
                <p style="font-size: 0.85em; color: #7f8c8d; margin-top: 5px;">Minimum 8 caractères</p>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    class="form-control"
                    required
                    placeholder="Confirmez votre mot de passe"
                >
            </div>

            <button type="submit" class="btn btn-success" style="width: 100%;">Créer mon compte</button>
        </form>

        <div style="margin-top: 20px; text-align: center;">
            <p>Déjà un compte ? <a href="index.php?controller=auth&action=login" style="color: #3498db; font-weight: 600;">Se connecter</a></p>
            <p><a href="index.php" style="color: #7f8c8d;">Retour à l'accueil</a></p>
        </div>
    </div>
</div>
