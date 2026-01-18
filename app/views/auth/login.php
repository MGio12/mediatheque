<div class="container" style="max-width: 500px; margin-top: 60px;">
    <div class="content">
        <h1 style="text-align: center; margin-bottom: 30px;">Connexion</h1>

        <?php if (isset($error) && $error): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?controller=auth&action=loginPost">
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
                    placeholder="Votre mot de passe"
                >
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Se connecter</button>
        </form>

        <div style="margin-top: 20px; text-align: center;">
            <p>Pas de compte ? <a href="index.php?controller=auth&action=register" style="color: #3498db; font-weight: 600;">Créer un compte</a></p>
            <p><a href="index.php" style="color: #7f8c8d;">Retour à l'accueil</a></p>
        </div>
    </div>
</div>
