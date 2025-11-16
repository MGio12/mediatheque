<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Médiathèque Numérique', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap">
    <script>(function(){const t=localStorage.getItem('theme');if(t)document.documentElement.setAttribute('data-theme',t);})();</script>
</head>
<body>
    <?php require_once __DIR__ . '/partials/header.php'; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="container">
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="container">
            <div class="alert alert-error">
                <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
            </div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?= $content ?? '' ?>

    <?php require_once __DIR__ . '/partials/footer.php'; ?>

    <script>
    (function() {
        const toggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;

        const currentTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', currentTheme);

        if (toggle) {
            toggle.addEventListener('click', function() {
                const theme = html.getAttribute('data-theme');
                const newTheme = theme === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
            });
        }
    })();
    </script>
</body>
</html>
