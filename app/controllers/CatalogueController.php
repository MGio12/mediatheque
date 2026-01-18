<?php
/**
 * Contrôleur Catalogue
 * SAE R307 - Médiathèque
 */

require_once __DIR__ . '/../models/Ressource.php';

class CatalogueController extends Controller {

    private $ressourceModel;

    public function __construct() {
        $this->ressourceModel = new Ressource();
    }

    public function index() {
        // Récupérer toutes les ressources
        $ressources = $this->ressourceModel->getAll();

        // Calculer la note moyenne et le nombre d'évaluations pour chaque ressource
        foreach ($ressources as &$ressource) {
            $ressource['note_moyenne'] = $this->ressourceModel->getAverageRating($ressource['id_ressource']);
            $ressource['nb_evaluations'] = $this->ressourceModel->getEvaluationCount($ressource['id_ressource']);
            $ressource['genres'] = $this->ressourceModel->getGenres($ressource['id_ressource']);
        }
        unset($ressource);

        $this->render('catalogue/index', [
            'ressources' => $ressources
        ], 'Catalogue');
    }

    /**
     * Page Nouveautés - Dernières ressources ajoutées
     */
    public function nouveautes() {
        $limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int)$_GET['limit'] : 20;
        $ressources = $this->ressourceModel->getNewest($limit);

        // Enrichir avec notes
        foreach ($ressources as &$ressource) {
            $ressource['note_moyenne'] = $this->ressourceModel->getAverageRating($ressource['id_ressource']);
            $ressource['nb_evaluations'] = $this->ressourceModel->getEvaluationCount($ressource['id_ressource']);
            $ressource['genres'] = $this->ressourceModel->getGenres($ressource['id_ressource']);
        }
        unset($ressource);

        $this->render('catalogue/nouveautes', [
            'ressources' => $ressources
        ], 'Nouveautés');
    }

    /**
     * Page Top - Ressources les mieux notées
     */
    public function top() {
        $limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int)$_GET['limit'] : 20;
        $ressources = $this->ressourceModel->getTopRated($limit, 0);

        // getTopRated retourne déjà note_moyenne et nb_evaluations
        // Enrichir avec genres
        foreach ($ressources as &$ressource) {
            $ressource['genres'] = $this->ressourceModel->getGenres($ressource['id_ressource']);
        }
        unset($ressource);

        $this->render('catalogue/top', [
            'ressources' => $ressources
        ], 'Top');
    }

    /**
     * Page Sélection - Ressources par thème
     */
    public function selection() {
        // Validation param theme
        if (!isset($_GET['theme']) || !is_numeric($_GET['theme'])) {
            header('Location: index.php?controller=catalogue&action=index');
            exit;
        }

        $themeId = (int)$_GET['theme'];

        // Charger le thème
        require_once __DIR__ . '/../models/Theme.php';
        $themeModel = new Theme();
        $theme = $themeModel->findById($themeId);

        if (!$theme) {
            header('Location: index.php?controller=catalogue&action=index');
            exit;
        }

        // Récupérer ressources du thème
        $ressources = $this->ressourceModel->getByTheme($themeId);

        // Enrichir avec notes
        foreach ($ressources as &$ressource) {
            $ressource['note_moyenne'] = $this->ressourceModel->getAverageRating($ressource['id_ressource']);
            $ressource['nb_evaluations'] = $this->ressourceModel->getEvaluationCount($ressource['id_ressource']);
            $ressource['genres'] = $this->ressourceModel->getGenres($ressource['id_ressource']);
        }
        unset($ressource);

        $this->render('catalogue/selection', [
            'ressources' => $ressources,
            'theme' => $theme
        ], 'Sélection');
    }

    /**
     * Page Recherche - Recherche multicritère
     */
    public function search() {
        // Récupérer et valider paramètres
        $searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';
        $type = isset($_GET['type']) ? trim($_GET['type']) : '';
        $genreId = !empty($_GET['genre']) && is_numeric($_GET['genre']) ? (int)$_GET['genre'] : null;
        $themeId = !empty($_GET['theme']) && is_numeric($_GET['theme']) ? (int)$_GET['theme'] : null;
        $anneeMin = !empty($_GET['annee_min']) && is_numeric($_GET['annee_min']) ? (int)$_GET['annee_min'] : null;
        $anneeMax = !empty($_GET['annee_max']) && is_numeric($_GET['annee_max']) ? (int)$_GET['annee_max'] : null;

        // Construire critères
        $criteria = [
            'search' => $searchTerm,
            'type' => ($type !== '' && in_array($type, ['livre', 'film'])) ? $type : null,
            'genreId' => $genreId,
            'themeId' => $themeId,
            'anneeMin' => $anneeMin,
            'anneeMax' => $anneeMax
        ];

        // Effectuer recherche
        $ressources = $this->ressourceModel->search($criteria);

        // Enrichir avec notes
        foreach ($ressources as &$ressource) {
            $ressource['note_moyenne'] = $this->ressourceModel->getAverageRating($ressource['id_ressource']);
            $ressource['nb_evaluations'] = $this->ressourceModel->getEvaluationCount($ressource['id_ressource']);
            $ressource['genres'] = $this->ressourceModel->getGenres($ressource['id_ressource']);
        }
        unset($ressource);

        // Charger genres/thèmes pour formulaire
        require_once __DIR__ . '/../models/Genre.php';
        require_once __DIR__ . '/../models/Theme.php';
        $genreModel = new Genre();
        $themeModel = new Theme();
        $genres = $genreModel->getAll();
        $themes = $themeModel->getAll();

        $this->render('catalogue/search', [
            'ressources' => $ressources,
            'genres' => $genres,
            'themes' => $themes
        ], 'Recherche');
    }
}
