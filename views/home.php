<?php
/**
 * Page d'accueil
 */
?>

<div class="hero">
    <div class="container">
        <h2>📚 Bienvenue à la Médiathèque Numérique</h2>
        <p>Découvrez une collection exceptionnelle de livres et films, triés sur le volet pour vous offrir les meilleures expériences de lecture et de cinéma.</p>
        <div class="cta-buttons">
            <a href="?controller=catalogue&action=index" class="btn btn-primary">Explorez le Catalogue</a>
            <a href="?controller=catalogue&action=index" class="btn btn-secondary">Voir les Meilleures Évaluations</a>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h3 class="section-title">🌟 Nos Collections Vedettes</h3>
            <p class="section-subtitle">Des chefs-d'œuvre reconnus et des découvertes captivantes</p>
        </div>

        <div class="grid-3">
            <?php if (!empty($resources)): ?>
                <?php foreach (array_slice($resources, 0, 6) as $resource): ?>
                    <a href="?controller=ressource&action=detail&id=<?= $resource['id'] ?>" class="card">
                        <div class="card-image">
                            <?php if (!empty($resource['image_url'])): ?>
                                <img src="<?= htmlspecialchars($resource['image_url']) ?>" alt="<?= htmlspecialchars($resource['titre']) ?>">
                            <?php else: ?>
                                <span><?= ucfirst($resource['type']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <?php if ($resource['type'] === 'livre'): ?>
                                <span class="badge badge-livre">📖 Livre</span>
                            <?php elseif ($resource['type'] === 'film'): ?>
                                <span class="badge badge-film">🎬 Film</span>
                            <?php endif; ?>
                            <h3 class="card-title"><?= htmlspecialchars($resource['titre']) ?></h3>
                            <p class="card-author"><?= htmlspecialchars($resource['auteur'] ?? $resource['realisateur']) ?></p>
                            <p class="card-year"><?= htmlspecialchars($resource['annee_publication'] ?? $resource['annee_sortie']) ?></p>
                            <div class="rating">
                                <span class="stars">★★★★★</span>
                                <span class="rating-text"><?= number_format($resource['note_moyenne'] ?? 0, 1) ?>/5</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <h3>📭 Aucune ressource disponible</h3>
                </div>
            <?php endif; ?>
        </div>

        <div class="section-actions">
            <a href="?controller=catalogue&action=index" class="btn btn-link">Voir tout le catalogue →</a>
        </div>
    </section>

    <section class="section" style="background: linear-gradient(135deg, rgba(232, 241, 247, 0.5) 0%, rgba(245, 249, 252, 0.5) 100%);">
        <div class="container">
            <div class="section-header">
                <h3 class="section-title">✨ Pourquoi Nous Choisir ?</h3>
                <p class="section-subtitle">Une plateforme pensée pour les vrais amateurs de culture</p>
            </div>

            <div class="grid-3">
                <div class="card" style="border-top: 3px solid var(--color-primary);">
                    <div class="card-body">
                        <h3 class="card-title">📚 Sélection Curatée</h3>
                        <p>Chaque ressource est soigneusement sélectionnée pour garantir une qualité exceptionnelle et une pertinence thématique.</p>
                    </div>
                </div>
                <div class="card" style="border-top: 3px solid var(--color-accent-red);">
                    <div class="card-body">
                        <h3 class="card-title">💬 Avis Communautaire</h3>
                        <p>Partagez vos impressions, découvrez les critiques d'autres passionnés et trouvez vos prochaines lectures ou films.</p>
                    </div>
                </div>
                <div class="card" style="border-top: 3px solid var(--color-teal);">
                    <div class="card-body">
                        <h3 class="card-title">🌐 Accès Illimité</h3>
                        <p>Accédez à notre collection complète 24h/24, 7j/7, depuis n'importe quel appareil avec une connexion internet.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-header">
                <h3 class="section-title">🎯 Explorez par Genre</h3>
                <p class="section-subtitle">Trouvez exactement ce que vous cherchez</p>
            </div>

            <div class="theme-grid">
                <a href="?controller=catalogue&action=index&type=livre" class="theme-card">📖 Livres</a>
                <a href="?controller=catalogue&action=index&type=film" class="theme-card">🎬 Films</a>
                <a href="?controller=catalogue&action=index&genre=fiction" class="theme-card">✨ Fiction</a>
                <a href="?controller=catalogue&action=index&genre=aventure" class="theme-card">⚔️ Aventure</a>
                <a href="?controller=catalogue&action=index&genre=drame" class="theme-card">🎭 Drame</a>
                <a href="?controller=catalogue&action=index&genre=science-fiction" class="theme-card">🚀 Sci-Fi</a>
            </div>
        </div>
    </section>

    <section class="section" style="background: linear-gradient(135deg, rgba(231, 76, 60, 0.08) 0%, rgba(232, 241, 247, 0.5) 100%);">
        <div class="container">
            <div class="section-header">
                <h3 class="section-title">❤️ Rejoignez Notre Communauté</h3>
                <p class="section-subtitle">Partagez votre passion pour les livres et les films</p>
            </div>

            <div style="text-align: center; max-width: 600px; margin: 0 auto;">
                <p style="font-size: 1.2em; color: var(--text-secondary); line-height: 1.8; margin-bottom: 30px;">
                    Créez votre compte dès aujourd'hui pour accéder à des évaluations personnalisées, des recommandations adaptées et bien plus encore.
                </p>
                <a href="?controller=auth&action=login" class="btn btn-primary">Se Connecter</a>
            </div>
        </div>
    </section>
</div>
