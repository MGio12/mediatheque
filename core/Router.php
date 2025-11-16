<?php
/**
 * Routeur simple
 * SAE R307 - Médiathèque
 */

class Router {

    /**
     * Dispatch la requête vers le bon contrôleur/action
     */
    public function dispatch($controller, $action) {
        // Construire le nom de la classe du contrôleur
        $controllerClass = ucfirst($controller) . 'Controller';
        $controllerFile = __DIR__ . '/../app/controllers/' . $controllerClass . '.php';

        // Vérifier si le fichier du contrôleur existe
        if (!file_exists($controllerFile)) {
            $this->error404();
            return;
        }

        // Charger le contrôleur
        require_once $controllerFile;

        // Vérifier si la classe existe
        if (!class_exists($controllerClass)) {
            $this->error404();
            return;
        }

        // Instancier le contrôleur
        $controllerInstance = new $controllerClass();

        // Vérifier si la méthode existe
        if (!method_exists($controllerInstance, $action)) {
            $this->error404();
            return;
        }

        // Appeler l'action
        $controllerInstance->$action();
    }

    /**
     * Affiche une page 404
     */
    private function error404() {
        http_response_code(404);
        echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>404 - Page non trouvée</title>
</head>
<body>
    <h1>404 - Page non trouvée</h1>
    <p><a href="index.php">Retour à l\'accueil</a></p>
</body>
</html>';
    }
}
