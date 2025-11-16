<?php
/**
 * Classe Controller de base
 * Fournit des méthodes utilitaires pour tous les contrôleurs
 */

class Controller {

    /**
     * Rend une vue avec le layout
     * @param string $view Chemin vers la vue (ex: 'home/index')
     * @param array $data Données à passer à la vue
     * @param string $title Titre de la page
     */
    protected function render($view, $data = [], $title = null) {
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);

        // Capturer le contenu de la vue
        ob_start();
        require_once __DIR__ . '/../app/views/' . $view . '.php';
        $content = ob_get_clean();

        // Inclure le layout qui affichera $content
        require_once __DIR__ . '/../app/views/layout.php';
    }

    /**
     * Rend une vue sans layout (pour les cas particuliers)
     * @param string $view Chemin vers la vue
     * @param array $data Données à passer à la vue
     */
    protected function renderWithoutLayout($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../app/views/' . $view . '.php';
    }
}
