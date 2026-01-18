<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h2>Explorez Notre Univers Créatif</h2>
        <p>Plongez dans une collection exceptionnelle de livres, films et ressources. Découvrez, apprenez et inspirez-vous avec nos milliers de contenus sélectionnés.</p>
        <div class="cta-buttons">
            <a href="?controller=catalogue&action=index" class="btn btn-primary">Parcourir le Catalogue</a>
            <a href="?controller=catalogue&action=search" class="btn btn-secondary">Rechercher</a>
        </div>
    </div>
</section>

<?php if (!empty($ressources)): ?>
    <!-- Section Catalogue -->
    <section class="section catalogue-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">À Découvrir en Priorité</h2>
                <p class="section-subtitle">Nos meilleures sélections et derniers ajouts</p>
            </div>
            
            <div class="grid-3">
                <?php foreach ($ressources as $ressource): ?>
                    <a href="?controller=ressource&action=show&id=<?php echo htmlspecialchars($ressource['id']); ?>" class="card">
                        <div class="card-image">
                            <?php if (!empty($ressource['image'])): ?>
                                <img src="<?php echo htmlspecialchars($ressource['image']); ?>" alt="<?php echo htmlspecialchars($ressource['titre']); ?>">
                            <?php else: ?>
                                <span>Pas d'image</span>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title"><?php echo htmlspecialchars($ressource['titre']); ?></h3>
                            <p class="card-author"><?php echo htmlspecialchars($ressource['auteur']); ?></p>
                            <p class="card-year"><?php echo htmlspecialchars($ressource['annee']); ?></p>
                            <div class="rating">
                                <span class="stars">★★★★★</span>
                                <span class="rating-text"><?php echo htmlspecialchars($ressource['note'] ?? 'N/A'); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="section-actions">
                <a href="?controller=catalogue&action=index" class="btn btn-primary">Voir Tout le Catalogue</a>
            </div>
        </div>
    </section>
<?php endif; ?>
