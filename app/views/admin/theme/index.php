<div class="page-header">
    <div class="container">
        <h1>Gestion des thèmes</h1>
        <p>Administrez les thématiques associées aux ressources.</p>
    </div>
</div>

<div class="container">
    <div class="content">
        <div class="actions" style="justify-content: space-between;">
            <a href="index.php?controller=admin&action=index" class="btn btn-secondary">← Retour au dashboard</a>
            <a href="index.php?controller=theme&action=create" class="btn btn-success">+ Nouveau thème</a>
        </div>

        <?php if (empty($themes)): ?>
            <div class="empty-state">
                <h3>Aucun thème</h3>
                <p>Ajoutez un thème pour aider les utilisateurs à filtrer les contenus.</p>
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
                    <?php foreach ($themes as $theme): ?>
                        <tr>
                            <td><?= htmlspecialchars($theme['id_theme'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($theme['nom'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <div class="actions">
                                    <a href="index.php?controller=theme&action=edit&id=<?= htmlspecialchars($theme['id_theme'], ENT_QUOTES, 'UTF-8') ?>"
                                       class="btn btn-primary">Modifier</a>
                                    <a href="index.php?controller=theme&action=delete&id=<?= htmlspecialchars($theme['id_theme'], ENT_QUOTES, 'UTF-8') ?>"
                                       class="btn btn-danger"
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce thème ?')">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
