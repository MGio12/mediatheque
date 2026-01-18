<div class="header">
    <div class="container">
        <h1>Médiathèque Numérique</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="index.php?controller=catalogue&action=index">Catalogue</a>
            <a href="index.php?controller=catalogue&action=search">Recherche</a>
            <?php if (Auth::check()): ?>
                <?php if (Auth::hasRole('bibliothecaire') || Auth::hasRole('administrateur')): ?>
                    <a href="index.php?controller=admin&action=index">Admin</a>
                <?php endif; ?>
                <a href="index.php?controller=auth&action=logout">Déconnexion</a>
            <?php else: ?>
                <a href="index.php?controller=auth&action=login">Connexion</a>
            <?php endif; ?>
            <button id="darkModeToggle" class="dark-mode-toggle" aria-label="Basculer le mode sombre">Mode sombre</button>
        </nav>
    </div>
</div>
