<div class="page-header">
    <div class="container">
        <h1>Gestion des livres</h1>
        <p>Administrez l'ensemble des livres disponibles dans la médiathèque.</p>
    </div>
</div>

<div class="container">
    <div class="content">
        <div class="actions" style="justify-content: space-between;">
            <a href="index.php?controller=admin&action=index" class="btn btn-secondary">← Retour au dashboard</a>
            <a href="index.php?controller=livre&action=create" class="btn btn-success">+ Nouveau livre</a>
        </div>

        <?php if (empty($livres)): ?>
            <div class="empty-state">
                <h3>Aucun livre</h3>
                <p>Ajoutez votre premier livre pour l'afficher dans le catalogue.</p>
            </div>
        <?php else: ?>
            <table class="table" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>ISBN</th>
                        <th style="width: 80px;">Année</th>
                        <th style="width: 80px;">Pages</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($livres as $livre): ?>
                        <tr>
                            <td><?= htmlspecialchars($livre['id_ressource'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($livre['titre'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($livre['auteur_realisateur'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($livre['isbn'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($livre['annee'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($livre['nombre_pages'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <div class="actions">
                                    <a href="index.php?controller=livre&action=edit&id=<?= htmlspecialchars($livre['id_ressource'], ENT_QUOTES, 'UTF-8') ?>"
                                       class="btn btn-primary">Modifier</a>
                                    <a href="index.php?controller=livre&action=delete&id=<?= htmlspecialchars($livre['id_ressource'], ENT_QUOTES, 'UTF-8') ?>"
                                       class="btn btn-danger"
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
