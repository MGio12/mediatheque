<?php
/**
 * Contrôleur Theme (Admin)
 * SAE R307 - Médiathèque
 */

require_once __DIR__ . '/../models/Theme.php';

class ThemeController extends Controller {

    private $themeModel;

    public function __construct() {
        // Sécurité : réservé au staff
        Auth::requireStaff();
        $this->themeModel = new Theme();
    }

    /**
     * Liste des thèmes
     */
    public function index() {
        $themes = $this->themeModel->getAll();
        $this->render('admin/theme/index', [
            'themes' => $themes
        ], 'Gestion des thèmes');
    }

    /**
     * Formulaire de création
     */
    public function create() {
        $this->render('admin/theme/create', [], 'Créer un thème');
    }

    /**
     * Traitement création
     */
    public function createPost() {
        // Vérifier que c'est bien un POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=theme&action=index');
            exit;
        }

        // Récupérer et valider les données
        $nom = trim($_POST['nom'] ?? '');
        $errors = [];

        if (empty($nom)) {
            $errors['nom'] = 'Le nom est requis';
        } elseif (strlen($nom) > 100) {
            $errors['nom'] = 'Maximum 100 caractères';
        } elseif ($this->themeModel->existsByName($nom)) {
            $errors['nom'] = 'Ce thème existe déjà';
        }

        // Si erreurs, revenir au formulaire
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: index.php?controller=theme&action=create');
            exit;
        }

        // Créer le thème
        try {
            $this->themeModel->create($nom);
            $_SESSION['success'] = "Thème créé avec succès";
        } catch (Exception $e) {
            error_log("Erreur création thème: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la création du thème";
        }

        header('Location: index.php?controller=theme&action=index');
        exit;
    }

    /**
     * Formulaire d'édition
     */
    public function edit() {
        // Valider l'ID
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] <= 0) {
            $_SESSION['error'] = 'ID invalide';
            header('Location: index.php?controller=theme&action=index');
            exit;
        }

        $id = (int)$_GET['id'];
        $theme = $this->themeModel->findById($id);

        if (!$theme) {
            $_SESSION['error'] = 'Thème non trouvé';
            header('Location: index.php?controller=theme&action=index');
            exit;
        }

        $this->render('admin/theme/edit', [
            'theme' => $theme
        ], 'Modifier un thème');
    }

    /**
     * Traitement édition
     */
    public function editPost() {
        // Vérifier que c'est bien un POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=theme&action=index');
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
        } elseif ($this->themeModel->existsByName($nom, $id)) {
            $errors['nom'] = 'Ce thème existe déjà';
        }

        // Si erreurs, revenir au formulaire
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: index.php?controller=theme&action=edit&id=' . $id);
            exit;
        }

        // Mettre à jour le thème
        try {
            $this->themeModel->update($id, $nom);
            $_SESSION['success'] = "Thème modifié avec succès";
        } catch (Exception $e) {
            error_log("Erreur modification thème: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la modification du thème";
        }

        header('Location: index.php?controller=theme&action=index');
        exit;
    }

    /**
     * Suppression
     */
    public function delete() {
        // Valider l'ID
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] <= 0) {
            $_SESSION['error'] = 'ID invalide';
            header('Location: index.php?controller=theme&action=index');
            exit;
        }

        $id = (int)$_GET['id'];

        // Vérifier que le thème existe
        $theme = $this->themeModel->findById($id);
        if (!$theme) {
            $_SESSION['error'] = 'Thème non trouvé';
            header('Location: index.php?controller=theme&action=index');
            exit;
        }

        // Supprimer
        try {
            $this->themeModel->delete($id);
            $_SESSION['success'] = "Thème supprimé avec succès";
        } catch (Exception $e) {
            error_log("Erreur suppression thème: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la suppression (le thème est peut-être utilisé)";
        }

        header('Location: index.php?controller=theme&action=index');
        exit;
    }
}
