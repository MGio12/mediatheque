<?php
/**
 * Contrôleur Ressource
 * SAE R307 - Médiathèque
 */

require_once __DIR__ . '/../models/Ressource.php';
require_once __DIR__ . '/../models/Evaluation.php';

class RessourceController extends Controller {

    private $ressourceModel;
    private $evaluationModel;

    public function __construct() {
        $this->ressourceModel = new Ressource();
        $this->evaluationModel = new Evaluation();
    }

    public function index() {
        // Rediriger vers le catalogue
        header('Location: index.php?controller=catalogue&action=index');
        exit;
    }

    public function show() {
        // Vérifier que l'ID est fourni et valide
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: index.php?controller=catalogue&action=index');
            exit;
        }

        $id = (int)$_GET['id'];

        // Récupérer la ressource
        $ressource = $this->ressourceModel->findById($id);

        // Vérifier que la ressource existe
        if (!$ressource) {
            header('Location: index.php?controller=catalogue&action=index');
            exit;
        }

        // Récupérer les données supplémentaires
        $ressource['note_moyenne'] = $this->ressourceModel->getAverageRating($id);
        $ressource['nb_evaluations'] = $this->ressourceModel->getEvaluationCount($id);
        $ressource['genres'] = $this->ressourceModel->getGenres($id);
        $ressource['themes'] = $this->ressourceModel->getThemes($id);
        $evaluations = $this->ressourceModel->getEvaluations($id);

        // Vérifier si l'utilisateur peut évaluer
        $canEvaluate = false;
        $hasEvaluated = false;

        if (Auth::check()) {
            $idUser = $_SESSION['user']['id_utilisateur'];
            $hasEvaluated = $this->evaluationModel->hasUserEvaluated($idUser, $id);
            $canEvaluate = !$hasEvaluated;
        }

        $this->render('ressource/show', [
            'ressource' => $ressource,
            'evaluations' => $evaluations,
            'canEvaluate' => $canEvaluate,
            'hasEvaluated' => $hasEvaluated
        ], $ressource['titre']);
    }
}
