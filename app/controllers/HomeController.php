<?php
/**
 * Contrôleur Home
 * SAE R307 - Médiathèque
 */

require_once __DIR__ . '/../models/Ressource.php';
require_once __DIR__ . '/../models/Theme.php';

class HomeController extends Controller {

    private $ressourceModel;
    private $themeModel;

    public function __construct() {
        $this->ressourceModel = new Ressource();
        $this->themeModel = new Theme();
    }

    public function index() {
        // Bloc Nouveautés : 6 dernières ressources
        $nouveautes = $this->ressourceModel->getNewest(6);
        foreach ($nouveautes as &$ressource) {
            $ressource['note_moyenne'] = $this->ressourceModel->getAverageRating($ressource['id_ressource']);
            $ressource['nb_evaluations'] = $this->ressourceModel->getEvaluationCount($ressource['id_ressource']);
        }

        // Bloc Top : 6 meilleures ressources
        $topRessources = $this->ressourceModel->getTopRated(6, 1);

        // Bloc Sélection : Récupérer tous les thèmes pour affichage
        $themes = $this->themeModel->getAll();

        // Afficher la page d'accueil avec le layout commun
        $this->render('home/index', [
            'nouveautes' => $nouveautes,
            'topRessources' => $topRessources,
            'themes' => $themes
        ], 'Accueil');
    }
}
