<?php
/**
 * Contrôleur Admin (Dashboard)
 * SAE R307 - Médiathèque
 */

// Charger le modèle Evaluation
require_once __DIR__ . '/../models/Evaluation.php';

class AdminController extends Controller {

    public function index() {
        // Sécurité : réservé au staff
        Auth::requireStaff();

        $pdo = Database::getInstance();

        // Statistiques de base
        $stats = [];

        // Total ressources
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM ressource");
        $stats['total_ressources'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total livres
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM livre");
        $stats['total_livres'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total films
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM film");
        $stats['total_films'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total évaluations
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM evaluation");
        $stats['total_evaluations'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total genres
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM genre");
        $stats['total_genres'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total thèmes
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM theme");
        $stats['total_themes'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Top 5 ressources les mieux notées
        $stmt = $pdo->query("
            SELECT
                r.id_ressource,
                r.titre,
                r.type,
                r.auteur_realisateur,
                AVG(e.note) as moyenne,
                COUNT(e.id_evaluation) as nb_evaluations
            FROM ressource r
            LEFT JOIN evaluation e ON r.id_ressource = e.id_ressource
            GROUP BY r.id_ressource
            HAVING nb_evaluations > 0
            ORDER BY moyenne DESC, nb_evaluations DESC
            LIMIT 5
        ");
        $topRessources = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 10 dernières évaluations
        $stmt = $pdo->query("
            SELECT
                e.id_evaluation,
                e.note,
                e.critique,
                e.date_evaluation,
                r.titre as ressource_titre,
                r.type as ressource_type,
                u.nom as utilisateur_nom,
                u.prenom as utilisateur_prenom
            FROM evaluation e
            JOIN ressource r ON e.id_ressource = r.id_ressource
            JOIN utilisateur u ON e.id_utilisateur = u.id_utilisateur
            ORDER BY e.date_evaluation DESC
            LIMIT 10
        ");
        $dernieresEvaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('admin/index', [
            'stats' => $stats,
            'topRessources' => $topRessources,
            'dernieresEvaluations' => $dernieresEvaluations
        ], 'Dashboard');
    }

    /**
     * Suppression d'une évaluation (réservé aux administrateurs)
     */
    public function deleteEvaluation() {
        // Vérification manuelle du rôle administrateur (pas de middleware)
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'administrateur') {
            $_SESSION['error'] = "Accès interdit. Seuls les administrateurs peuvent supprimer des évaluations.";
            header('Location: index.php');
            exit;
        }

        // Récupération de l'ID
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "ID d'évaluation invalide.";
            header('Location: index.php?controller=admin&action=index');
            exit;
        }

        // Suppression via le modèle
        try {
            $evaluationModel = new Evaluation();
            $success = $evaluationModel->deleteEvaluation($id);

            if ($success) {
                $_SESSION['success'] = "L'évaluation a été supprimée avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression de l'évaluation.";
            }
        } catch (PDOException $e) {
            error_log("Erreur suppression évaluation: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la suppression de l'évaluation.";
        }

        header('Location: index.php?controller=admin&action=index');
        exit;
    }
}
