<?php
/**
 * Contrôleur Genre (Admin)
 * SAE R307 - Médiathèque
 */

require_once __DIR__ . '/../models/Genre.php';

class GenreController extends Controller {

    private $genreModel;

    public function __construct() {
        // Sécurité : réservé au staff
        Auth::requireStaff();
        $this->genreModel = new Genre();
    }

    /**
     * Liste des genres
     */
    public function index() {
        $genres = $this->genreModel->getAll();
        $this->render('admin/genre/index', [
            'genres' => $genres
        ], 'Gestion des genres');
    }

    /**
     * Formulaire de création
     */
    public function create() {
        $this->render('admin/genre/create', [], 'Créer un genre');
    }

    /**
     * Traitement création
     */
    public function createPost() {
        // Vérifier que c'est bien un POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=genre&action=index');
            exit;
        }

        // Récupérer et valider les données
        $nom = trim($_POST['nom'] ?? '');
        $errors = [];

        if (empty($nom)) {
            $errors['nom'] = 'Le nom est requis';
        } elseif (strlen($nom) > 100) {
            $errors['nom'] = 'Maximum 100 caractères';
        } elseif ($this->genreModel->existsByName($nom)) {
            $errors['nom'] = 'Ce genre existe déjà';
        }

        // Si erreurs, revenir au formulaire
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: index.php?controller=genre&action=create');
            exit;
        }

        // Créer le genre
        try {
            $this->genreModel->create($nom);
            $_SESSION['success'] = "Genre créé avec succès";
        } catch (Exception $e) {
            error_log("Erreur création genre: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la création du genre";
        }

        header('Location: index.php?controller=genre&action=index');
        exit;
    }

    /**
     * Formulaire d'édition
     */
    public function edit() {
        // Valider l'ID
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] <= 0) {
            $_SESSION['error'] = 'ID invalide';
            header('Location: index.php?controller=genre&action=index');
            exit;
        }

        $id = (int)$_GET['id'];
        $genre = $this->genreModel->findById($id);

        if (!$genre) {
            $_SESSION['error'] = 'Genre non trouvé';
            header('Location: index.php?controller=genre&action=index');
            exit;
        }

        $this->render('admin/genre/edit', [
            'genre' => $genre
        ], 'Modifier un genre');
    }

    /**
     * Traitement édition
     */
    public function editPost() {
        // Vérifier que c'est bien un POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=genre&action=index');
            exit;
        }

        // Récupérer et valider les données
        $id = (int)($_POST['id'] ?? 0);
        $nom = trim($_POST['nom'] ?? '');
        $errors = [];

        if ($id <= 0) {
            $errors['id'] = 'ID invalide';
        }

        if (empty($nom)) {
            $errors['nom'] = 'Le nom est requis';
        } elseif (strlen($nom) > 100) {
            $errors['nom'] = 'Maximum 100 caractères';
        } elseif ($this->genreModel->existsByName($nom, $id)) {
            $errors['nom'] = 'Ce genre existe déjà';
        }

        // Si erreurs, revenir au formulaire
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: index.php?controller=genre&action=edit&id=' . $id);
            exit;
        }

        // Mettre à jour le genre
        try {
            $this->genreModel->update($id, $nom);
            $_SESSION['success'] = "Genre modifié avec succès";
        } catch (Exception $e) {
            error_log("Erreur modification genre: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la modification du genre";
        }

        header('Location: index.php?controller=genre&action=index');
        exit;
    }

    /**
     * Suppression
     */
    public function delete() {
        // Valider l'ID
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] <= 0) {
            $_SESSION['error'] = 'ID invalide';
            header('Location: index.php?controller=genre&action=index');
            exit;
        }

        $id = (int)$_GET['id'];

        // Vérifier que le genre existe
        $genre = $this->genreModel->findById($id);
        if (!$genre) {
            $_SESSION['error'] = 'Genre non trouvé';
            header('Location: index.php?controller=genre&action=index');
            exit;
        }

        // Supprimer
        try {
            $this->genreModel->delete($id);
            $_SESSION['success'] = "Genre supprimé avec succès";
        } catch (Exception $e) {
            error_log("Erreur suppression genre: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la suppression (le genre est peut-être utilisé)";
        }

        header('Location: index.php?controller=genre&action=index');
        exit;
    }
}
