<?php
/**
 * Point d'entrée principal
 * SAE R307 - Médiathèque
 */

// Configuration environnement
$isProduction = (
    isset($_SERVER['HTTP_HOST']) && (
        strpos($_SERVER['HTTP_HOST'], 'unice.fr') !== false ||
        strpos($_SERVER['HTTP_HOST'], 'linserv') !== false ||
        strpos($_SERVER['HTTP_HOST'], 'iut') !== false
    )
);

// Gestion des erreurs selon environnement
if ($isProduction) {
    // PRODUCTION : Masquer les erreurs
    error_reporting(0);
    ini_set('display_errors', '0');
} else {
    // DÉVELOPPEMENT : Afficher toutes les erreurs
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

// Démarrer la session
session_start();

try {
    // Charger la configuration
    require_once __DIR__ . '/config/config.php';

    // Charger le core
    require_once __DIR__ . '/core/Controller.php';
    require_once __DIR__ . '/core/Database.php';
    require_once __DIR__ . '/core/Model.php';
    require_once __DIR__ . '/core/Router.php';
    require_once __DIR__ . '/core/Auth.php';

    // Récupérer et valider les paramètres de la requête
    $controller = $_GET['controller'] ?? 'home';
    $action = $_GET['action'] ?? 'index';

    // SÉCURITÉ : Valider le controller (uniquement caractères alphanumériques)
    if (!preg_match('/^[a-zA-Z]+$/', $controller)) {
        $controller = 'home';
    }

    // SÉCURITÉ : Valider l'action (uniquement caractères alphanumériques)
    if (!preg_match('/^[a-zA-Z]+$/', $action)) {
        $action = 'index';
    }

    // Lancer le routeur
    $router = new Router();
    $router->dispatch($controller, $action);

} catch (Exception $e) {
    // Logger l'erreur
    error_log("Erreur fatale dans index.php: " . $e->getMessage());

    // Afficher message selon environnement
    if ($isProduction) {
        // PRODUCTION : Message générique
        http_response_code(500);
        echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Erreur - Médiathèque</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        h1 { color: #e74c3c; }
    </style>
</head>
<body>
    <h1>Une erreur est survenue</h1>
    <p>Veuillez contacter l\'administrateur ou réessayer ultérieurement.</p>
    <p><a href="index.php">Retour à l\'accueil</a></p>
</body>
</html>';
    } else {
        // DÉVELOPPEMENT : Message détaillé
        http_response_code(500);
        echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Erreur - Mode Développement</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #f5f5f5; }
        .error { background: #fff; border: 2px solid #e74c3c; padding: 20px; border-radius: 8px; }
        h1 { color: #e74c3c; }
        pre { background: #2c3e50; color: #ecf0f1; padding: 15px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="error">
        <h1>Erreur 500 - Erreur serveur</h1>
        <p><strong>Message :</strong> ' . htmlspecialchars($e->getMessage()) . '</p>
        <p><strong>Fichier :</strong> ' . htmlspecialchars($e->getFile()) . '</p>
        <p><strong>Ligne :</strong> ' . $e->getLine() . '</p>
        <h3>Stack trace :</h3>
        <pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>
        <p><a href="index.php">Retour à l\'accueil</a></p>
    </div>
</body>
</html>';
    }
}
