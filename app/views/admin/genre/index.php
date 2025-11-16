<div class="page-header">
    <div class="container">
        <h1>Gestion des genres</h1>
        <p>Ajoutez, modifiez ou supprimez les genres du catalogue.</p>
    </div>
</div>

<div class="container">
    <div class="content">
        <div class="actions" style="justify-content: space-between;">
            <a href="index.php?controller=admin&action=index" class="btn btn-secondary">← Retour au dashboard</a>
            <a href="index.php?controller=genre&action=create" class="btn btn-success">+ Nouveau genre</a>
        </div>

        <?php if (empty($genres)): ?>
            <div class="empty-state">
                <h3>Aucun genre</h3>
                <p>Ajoutez votre premier genre pour organiser le catalogue.</p>
            </div>
        <?php else: ?>
            <table class="table" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Nom</th>
                        <th style="width: 220px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($genres as $genre): ?>
                        <tr>
                            <td><?= htmlspecialchars($genre['id_genre'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($genre['nom'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <div class="actions">
                                    <a href="index.php?controller=genre&action=edit&id=<?= htmlspecialchars($genre['id_genre'], ENT_QUOTES, 'UTF-8') ?>"
                                       class="btn btn-primary">Modifier</a>
                                    <a href="index.php?controller=genre&action=delete&id=<?= htmlspecialchars($genre['id_genre'], ENT_QUOTES, 'UTF-8') ?>"
                                       class="btn btn-danger"
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce genre ?')">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
