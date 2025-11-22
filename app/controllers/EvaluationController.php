<?php
/**
 * Contrôleur Evaluation
 * SAE R307 - Médiathèque
 */

require_once __DIR__ . '/../models/Evaluation.php';
require_once __DIR__ . '/../models/Ressource.php';

class EvaluationController extends Controller {
    private $evaluationModel;
    private $ressourceModel;

    public function __construct() {
        $this->evaluationModel = new Evaluation();
        $this->ressourceModel = new Ressource();
    }

    /**
     * Afficher le formulaire d'évaluation
     */
    public function create() {
        // Vérifier authentification
        Auth::requireAuth();

        // Récupérer l'ID de la ressource
        $idRessource = $_GET['id_ressource'] ?? null;

        // Validation ID ressource
        if (!$idRessource || !is_numeric($idRessource) || $idRessource <= 0) {
            $_SESSION['error'] = "Ressource invalide.";
            header("Location: index.php?controller=catalogue&action=index");
            exit;
        }

        // Vérifier que la ressource existe
        $ressource = $this->ressourceModel->findById($idRessource);
        if (!$ressource) {
            $_SESSION['error'] = "Ressource introuvable.";
            header("Location: index.php?controller=catalogue&action=index");
            exit;
        }

        // Vérifier que l'utilisateur n'a pas déjà évalué
        $idUser = $_SESSION['user']['id_utilisateur'];
        if ($this->evaluationModel->hasUserEvaluated($idUser, $idRessource)) {
            $_SESSION['error'] = "Vous avez déjà évalué cette ressource.";
            header("Location: index.php?controller=ressource&action=show&id=" . $idRessource);
            exit;
        }

        // Afficher le formulaire
        $this->render('evaluation/create', [
            'ressource' => $ressource
        ], 'Evaluer une ressource');
    }

    /**
     * Traiter la soumission du formulaire d'évaluation
     */
    public function createPost() {
        // PROTECTION : Bloquer les requêtes GET
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?controller=catalogue&action=index");
            exit;
        }

        // Vérifier authentification
        Auth::requireAuth();

        try {
            // Récupérer les données du formulaire
            $idRessource = $_POST['id_ressource'] ?? null;
            $note = $_POST['note'] ?? null;
            $critique = $_POST['critique'] ?? null;

            // Validation ID ressource
            if (!$idRessource || !is_numeric($idRessource) || $idRessource <= 0) {
                $_SESSION['error'] = "Ressource invalide.";
                header("Location: index.php?controller=catalogue&action=index");
                exit;
            }

            // Validation note
            if ($note === null || $note === '') {
                $_SESSION['error'] = "Veuillez sélectionner une note.";
                header("Location: index.php?controller=evaluation&action=create&id_ressource=" . $idRessource);
                exit;
            }

            // Convertir la note en float
            $note = floatval($note);

            // Vérifier que la note est dans la plage valide
            if ($note < 0.0 || $note > 5.0) {
                $_SESSION['error'] = "La note doit être comprise entre 0 et 5.";
                header("Location: index.php?controller=evaluation&action=create&id_ressource=" . $idRessource);
                exit;
            }

            // Validation critique (optionnelle, max 1000 caractères)
            if ($critique !== null && $critique !== '') {
                $critique = trim($critique);
                if (strlen($critique) > 1000) {
                    $_SESSION['error'] = "La critique ne peut pas dépasser 1000 caractères.";
                    header("Location: index.php?controller=evaluation&action=create&id_ressource=" . $idRessource);
                    exit;
                }
            } else {
                $critique = null;
            }

            // Vérifier que la ressource existe
            $ressource = $this->ressourceModel->findById($idRessource);
            if (!$ressource) {
                $_SESSION['error'] = "Ressource introuvable.";
                header("Location: index.php?controller=catalogue&action=index");
                exit;
            }

            // Créer l'évaluation
            $idUser = $_SESSION['user']['id_utilisateur'];
            $result = $this->evaluationModel->createEvaluation($idUser, $idRessource, $note, $critique);

            if ($result) {
                $_SESSION['success'] = "Votre évaluation a été enregistrée avec succès.";
                header("Location: index.php?controller=ressource&action=show&id=" . $idRessource);
                exit;
            } else {
                $_SESSION['error'] = "Une erreur est survenue lors de l'enregistrement de votre évaluation.";
                header("Location: index.php?controller=evaluation&action=create&id_ressource=" . $idRessource);
                exit;
            }

        } catch (PDOException $e) {
            // Gérer l'erreur de contrainte UNIQUE
            error_log("Erreur createPost évaluation: " . $e->getMessage());
            $_SESSION['error'] = "Vous avez déjà évalué cette ressource.";
            header("Location: index.php?controller=ressource&action=show&id=" . $idRessource);
            exit;

        } catch (Exception $e) {
            error_log("Erreur createPost évaluation: " . $e->getMessage());
            $_SESSION['error'] = "Une erreur est survenue lors de l'enregistrement de votre évaluation.";
            header("Location: index.php?controller=evaluation&action=create&id_ressource=" . $idRessource);
            exit;
        }
    }
}
