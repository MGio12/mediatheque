<div class="page-header">
    <div class="container">
        <h1>Gestion des films</h1>
        <p>Administrez les films proposés aux usagers.</p>
    </div>
</div>

<div class="container">
    <div class="content">
        <div class="actions" style="justify-content: space-between;">
            <a href="index.php?controller=admin&action=index" class="btn btn-secondary">← Retour au dashboard</a>
            <a href="index.php?controller=film&action=create" class="btn btn-success">+ Nouveau film</a>
        </div>

        <?php if (empty($films)): ?>
            <div class="empty-state">
                <h3>Aucun film</h3>
                <p>Ajoutez un film pour alimenter le catalogue.</p>
            </div>
        <?php else: ?>
            <table class="table" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Titre</th>
                        <th>Réalisateur</th>
                        <th>Support</th>
                        <th style="width: 120px;">Durée (min)</th>
                        <th>Langue</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($films as $film): ?>
                        <tr>
                            <td><?= htmlspecialchars($film['id_ressource'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($film['titre'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($film['auteur_realisateur'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($film['support'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($film['duree'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($film['langue'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <div class="actions">
                                    <a href="index.php?controller=film&action=edit&id=<?= htmlspecialchars($film['id_ressource'], ENT_QUOTES, 'UTF-8') ?>"
                                       class="btn btn-primary">Modifier</a>
                                    <a href="index.php?controller=film&action=delete&id=<?= htmlspecialchars($film['id_ressource'], ENT_QUOTES, 'UTF-8') ?>"
                                       class="btn btn-danger"
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce film ?')">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
