<div class="container">
    <div class="page-header">
        <div class="container">
            <h1>Administration</h1>
            <p>Bienvenue, <?= htmlspecialchars(Auth::user()['prenom'] . ' ' . Auth::user()['nom'], ENT_QUOTES, 'UTF-8') ?> | Rôle : <?= htmlspecialchars(Auth::user()['role'], ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Ressources</h3>
            <div class="stat-value"><?= htmlspecialchars($stats['total_ressources'], ENT_QUOTES, 'UTF-8') ?></div>
        </div>
        <div class="stat-card">
            <h3>Livres</h3>
            <div class="stat-value"><?= htmlspecialchars($stats['total_livres'], ENT_QUOTES, 'UTF-8') ?></div>
        </div>
        <div class="stat-card">
            <h3>Films</h3>
            <div class="stat-value"><?= htmlspecialchars($stats['total_films'], ENT_QUOTES, 'UTF-8') ?></div>
        </div>
        <div class="stat-card">
            <h3>Évaluations</h3>
            <div class="stat-value"><?= htmlspecialchars($stats['total_evaluations'], ENT_QUOTES, 'UTF-8') ?></div>
        </div>
        <div class="stat-card">
            <h3>Genres</h3>
            <div class="stat-value"><?= htmlspecialchars($stats['total_genres'], ENT_QUOTES, 'UTF-8') ?></div>
        </div>
        <div class="stat-card">
            <h3>Thèmes</h3>
            <div class="stat-value"><?= htmlspecialchars($stats['total_themes'], ENT_QUOTES, 'UTF-8') ?></div>
        </div>
    </div>

    <!-- Navigation rapide -->
    <div class="grid-3" style="margin-bottom: 40px;">
        <a href="index.php?controller=livre&action=index" class="card" style="text-decoration: none;">
            <div class="card-body">
                <h3 style="color: #3498db; margin-bottom: 10px;">Livres</h3>
                <p style="color: #7f8c8d; margin: 0;">Gérer les livres</p>
            </div>
        </a>
        <a href="index.php?controller=film&action=index" class="card" style="text-decoration: none;">
            <div class="card-body">
                <h3 style="color: #e74c3c; margin-bottom: 10px;">Films</h3>
                <p style="color: #7f8c8d; margin: 0;">Gérer les films</p>
            </div>
        </a>
        <a href="index.php?controller=genre&action=index" class="card" style="text-decoration: none;">
            <div class="card-body">
                <h3 style="color: #9b59b6; margin-bottom: 10px;">Genres</h3>
                <p style="color: #7f8c8d; margin: 0;">Gérer les genres</p>
            </div>
        </a>
        <a href="index.php?controller=theme&action=index" class="card" style="text-decoration: none;">
            <div class="card-body">
                <h3 style="color: #1abc9c; margin-bottom: 10px;">Thèmes</h3>
                <p style="color: #7f8c8d; margin: 0;">Gérer les thèmes</p>
            </div>
        </a>
    </div>

    <!-- Top 5 ressources -->
    <div class="content" style="margin-bottom: 30px;">
        <h2 style="color: #2c3e50; margin-bottom: 20px;">Meilleures ressources</h2>
        <?php if (empty($topRessources)): ?>
            <p style="color: #7f8c8d; text-align: center;">Aucune ressource évaluée</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Titre</th>
                        <th>Auteur / Réalisateur</th>
                        <th style="text-align: center;">Note</th>
                        <th style="text-align: center;">Évaluations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topRessources as $ressource): ?>
                        <tr>
                            <td><?= htmlspecialchars($ressource['id_ressource'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <span class="badge badge-<?= htmlspecialchars($ressource['type'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars(ucfirst($ressource['type']), ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($ressource['auteur_realisateur'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td style="text-align: center; font-weight: 600; color: #f39c12;">
                                <?= htmlspecialchars(number_format($ressource['moyenne'], 1), ENT_QUOTES, 'UTF-8') ?>/5
                            </td>
                            <td style="text-align: center;"><?= htmlspecialchars($ressource['nb_evaluations'], ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Dernières évaluations -->
    <div class="content">
        <h2 style="color: #2c3e50; margin-bottom: 20px;">Dernières évaluations</h2>
        <?php if (empty($dernieresEvaluations)): ?>
            <p style="color: #7f8c8d; text-align: center;">Aucune évaluation</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Utilisateur</th>
                        <th>Ressource</th>
                        <th>Type</th>
                        <th style="text-align: center;">Note</th>
                        <th>Commentaire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dernieresEvaluations as $eval): ?>
                        <tr>
                            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($eval['date_evaluation'])), ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($eval['utilisateur_prenom'] . ' ' . $eval['utilisateur_nom'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($eval['ressource_titre'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <span class="badge badge-<?= htmlspecialchars($eval['ressource_type'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars(ucfirst($eval['ressource_type']), ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </td>
                            <td style="text-align: center; font-weight: 600;">
                                <?= htmlspecialchars($eval['note'], ENT_QUOTES, 'UTF-8') ?>/5
                            </td>
                            <td>
                                <?php if (!empty($eval['critique'])): ?>
                                    <?= htmlspecialchars(mb_substr($eval['critique'], 0, 100), ENT_QUOTES, 'UTF-8') ?>
                                    <?= (mb_strlen($eval['critique']) > 100) ? '...' : '' ?>
                                <?php else: ?>
                                    <em style="color: #95a5a6;">Aucun commentaire</em>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div style="text-align: center; margin-top: 40px;">
        <a href="index.php" class="btn-link">← Retour à l'accueil</a>
    </div>
</div>
