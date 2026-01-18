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
        // Bloc Nouveautés : récupération des 8 dernières ressources ajoutées
        // Enrichissement avec notes moyennes, nombre d'évaluations et genres pour affichage complet
        $nouveautes = $this->ressourceModel->getNewest(8);
        foreach ($nouveautes as &$ressource) {
            $ressource['note_moyenne'] = $this->ressourceModel->getAverageRating($ressource['id_ressource']);
            $ressource['nb_evaluations'] = $this->ressourceModel->getEvaluationCount($ressource['id_ressource']);
            $ressource['genres'] = $this->ressourceModel->getGenres($ressource['id_ressource']);
        }

        // Bloc Top Ressources : récupération des 8 ressources les mieux notées
        // Minimum 1 évaluation requise pour garantir un classement pertinent
        $topRessources = $this->ressourceModel->getTopRated(8, 1);
        foreach ($topRessources as &$ressource) {
            $ressource['genres'] = $this->ressourceModel->getGenres($ressource['id_ressource']);
        }

        // Bloc Sélection : Récupérer tous les thèmes pour affichage dans la navigation
        $themes = $this->themeModel->getAll();

        // Afficher la page d'accueil avec le layout commun
        $this->render('home/index', [
            'nouveautes' => $nouveautes,
            'topRessources' => $topRessources,
            'themes' => $themes
        ], 'Accueil');
    }
}
