<?php
/**
 * Contrôleur Livre (Admin)
 * SAE R307 - Médiathèque
 */

require_once __DIR__ . '/../models/Livre.php';
require_once __DIR__ . '/../models/Genre.php';
require_once __DIR__ . '/../models/Theme.php';

class LivreController extends Controller {

    private $livreModel;
    private $genreModel;
    private $themeModel;

    public function __construct() {
        $this->livreModel = new Livre();
        $this->genreModel = new Genre();
        $this->themeModel = new Theme();
    }

    /**
     * Liste des livres (admin)
     */
    public function index() {
        // Sécurité : réservé au staff
        Auth::requireStaff();

        $livres = $this->livreModel->getAllWithDetails();
        $this->render('admin/livre/index', [
            'livres' => $livres
        ], 'Gestion des livres');
    }

    /**
     * Formulaire de création
     */
    public function create() {
        // Sécurité : réservé au staff
        Auth::requireStaff();

        // Charger les listes pour les select/checkboxes
        $genres = $this->genreModel->getAll();
        $themes = $this->themeModel->getAll();

        $this->render('admin/livre/create', [
            'genres' => $genres,
            'themes' => $themes
        ], 'Créer un livre');
    }

    /**
     * Traitement création
     */
    public function createPost() {
        // Sécurité : réservé au staff
        Auth::requireStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=livre&action=index');
            exit;
        }

        // Récupérer les données
        $errors = [];

        // Données ressource
        $titre = trim($_POST['titre'] ?? '');
        $auteur = trim($_POST['auteur_realisateur'] ?? '');
        $annee = trim($_POST['annee'] ?? '');
        $resume = trim($_POST['resume'] ?? '');
        $image_url = trim($_POST['image_url'] ?? '');

        // Données livre
        $isbn = trim($_POST['isbn'] ?? '');
        $editeur = trim($_POST['editeur'] ?? '');
        $pages = trim($_POST['nombre_pages'] ?? '');

        // Relations
        $genreIds = $_POST['genres'] ?? [];
        $themeIds = $_POST['themes'] ?? [];

        // Validation ressource
        if (empty($titre)) {
            $errors['titre'] = 'Le titre est requis';
        } elseif (strlen($titre) > 255) {
            $errors['titre'] = 'Maximum 255 caractères';
        }

        if (empty($auteur)) {
            $errors['auteur'] = 'L\'auteur est requis';
        } elseif (strlen($auteur) > 255) {
            $errors['auteur'] = 'Maximum 255 caractères';
        }

        if (empty($annee) || !is_numeric($annee)) {
            $errors['annee'] = 'Année invalide';
        } elseif ($annee < 1800 || $annee > 2100) {
            $errors['annee'] = 'L\'année doit être entre 1800 et 2100';
        }

        if (strlen($resume) > 5000) {
            $errors['resume'] = 'Maximum 5000 caractères';
        }

        if (!empty($image_url) && strlen($image_url) > 255) {
            $errors['image_url'] = 'Maximum 255 caractères';
        }

        // Validation livre
        if (empty($isbn)) {
            $errors['isbn'] = 'L\'ISBN est requis';
        } elseif (!preg_match('/^\d{13}$/', $isbn)) {
            $errors['isbn'] = 'L\'ISBN doit contenir exactement 13 chiffres';
        } elseif ($this->livreModel->isbnExists($isbn)) {
            $errors['isbn'] = 'Cet ISBN existe déjà';
        }

        if (empty($editeur)) {
            $errors['editeur'] = 'L\'éditeur est requis';
        } elseif (strlen($editeur) > 255) {
            $errors['editeur'] = 'Maximum 255 caractères';
        }

        if (empty($pages) || !is_numeric($pages)) {
            $errors['nombre_pages'] = 'Nombre de pages invalide';
        } elseif ($pages <= 0 || $pages > 10000) {
            $errors['nombre_pages'] = 'Le nombre de pages doit être entre 1 et 10000';
        }

        // Validation genres/thèmes
        if (!is_array($genreIds)) {
            $genreIds = [];
        }
        if (!is_array($themeIds)) {
            $themeIds = [];
        }

        // Si erreurs, revenir au formulaire
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: index.php?controller=livre&action=create');
            exit;
        }

        // Créer le livre
        try {
            $dataRessource = [
                'titre' => $titre,
                'auteur_realisateur' => $auteur,
                'annee' => (int)$annee,
                'resume' => $resume,
                'image_url' => $image_url
            ];

            $dataLivre = [
                'isbn' => $isbn,
                'editeur' => $editeur,
                'nombre_pages' => (int)$pages
            ];

            $this->livreModel->create([
                'ressource' => $dataRessource,
                'livre' => $dataLivre,
                'genres' => $genreIds,
                'themes' => $themeIds
            ]);
            $_SESSION['success'] = "Livre créé avec succès";
        } catch (Exception $e) {
            error_log("Erreur création livre: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la création du livre";
        }

        header('Location: index.php?controller=livre&action=index');
        exit;
    }

    /**
     * Formulaire d'édition
     */
    public function edit() {
        // Sécurité : réservé au staff
        Auth::requireStaff();

        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] <= 0) {
            $_SESSION['error'] = 'ID invalide';
            header('Location: index.php?controller=livre&action=index');
            exit;
        }

        $id = (int)$_GET['id'];
        $livre = $this->livreModel->findByIdWithDetails($id);

        if (!$livre) {
            $_SESSION['error'] = 'Livre non trouvé';
            header('Location: index.php?controller=livre&action=index');
            exit;
        }

        // Charger les données pour les formulaires
        $genres = $this->genreModel->getAll();
        $themes = $this->themeModel->getAll();
        $selectedGenres = $this->livreModel->getGenreIds($id);
        $selectedThemes = $this->livreModel->getThemeIds($id);

        $this->render('admin/livre/edit', [
            'livre' => $livre,
            'genres' => $genres,
            'themes' => $themes,
            'selectedGenres' => $selectedGenres,
            'selectedThemes' => $selectedThemes
        ], 'Modifier un livre');
    }

    /**
     * Traitement édition
     */
    public function editPost() {
        // Sécurité : réservé au staff
        Auth::requireStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=livre&action=index');
            exit;
        }

        // Récupérer les données
        $id = (int)($_POST['id'] ?? 0);
        $errors = [];

        if ($id <= 0) {
            $_SESSION['error'] = 'ID invalide';
            header('Location: index.php?controller=livre&action=index');
            exit;
        }

        // Données ressource
        $titre = trim($_POST['titre'] ?? '');
        $auteur = trim($_POST['auteur_realisateur'] ?? '');
        $annee = trim($_POST['annee'] ?? '');
        $resume = trim($_POST['resume'] ?? '');
        $image_url = trim($_POST['image_url'] ?? '');

        // Données livre
        $isbn = trim($_POST['isbn'] ?? '');
        $editeur = trim($_POST['editeur'] ?? '');
        $pages = trim($_POST['nombre_pages'] ?? '');

        // Relations
        $genreIds = $_POST['genres'] ?? [];
        $themeIds = $_POST['themes'] ?? [];

        // Validation (même logique que create)
        if (empty($titre)) {
            $errors['titre'] = 'Le titre est requis';
        } elseif (strlen($titre) > 255) {
            $errors['titre'] = 'Maximum 255 caractères';
        }

        if (empty($auteur)) {
            $errors['auteur'] = 'L\'auteur est requis';
        } elseif (strlen($auteur) > 255) {
            $errors['auteur'] = 'Maximum 255 caractères';
        }

        if (empty($annee) || !is_numeric($annee)) {
            $errors['annee'] = 'Année invalide';
        } elseif ($annee < 1800 || $annee > 2100) {
            $errors['annee'] = 'L\'année doit être entre 1800 et 2100';
        }

        if (strlen($resume) > 5000) {
            $errors['resume'] = 'Maximum 5000 caractères';
        }

        if (!empty($image_url) && strlen($image_url) > 255) {
            $errors['image_url'] = 'Maximum 255 caractères';
        }

        if (empty($isbn)) {
            $errors['isbn'] = 'L\'ISBN est requis';
        } elseif (!preg_match('/^\d{13}$/', $isbn)) {
            $errors['isbn'] = 'L\'ISBN doit contenir exactement 13 chiffres';
        } elseif ($this->livreModel->isbnExists($isbn, $id)) {
            $errors['isbn'] = 'Cet ISBN existe déjà';
        }

        if (empty($editeur)) {
            $errors['editeur'] = 'L\'éditeur est requis';
        } elseif (strlen($editeur) > 255) {
            $errors['editeur'] = 'Maximum 255 caractères';
        }

        if (empty($pages) || !is_numeric($pages)) {
            $errors['nombre_pages'] = 'Nombre de pages invalide';
        } elseif ($pages <= 0 || $pages > 10000) {
            $errors['nombre_pages'] = 'Le nombre de pages doit être entre 1 et 10000';
        }

        if (!is_array($genreIds)) $genreIds = [];
        if (!is_array($themeIds)) $themeIds = [];

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: index.php?controller=livre&action=edit&id=' . $id);
            exit;
        }

        // Modifier le livre
        try {
            $dataRessource = [
                'titre' => $titre,
                'auteur_realisateur' => $auteur,
                'annee' => (int)$annee,
                'resume' => $resume,
                'image_url' => $image_url
            ];

            $dataLivre = [
                'isbn' => $isbn,
                'editeur' => $editeur,
                'nombre_pages' => (int)$pages
            ];

            $this->livreModel->update($id, [
                'ressource' => $dataRessource,
                'livre' => $dataLivre,
                'genres' => $genreIds,
                'themes' => $themeIds
            ]);
            $_SESSION['success'] = "Livre modifié avec succès";
        } catch (Exception $e) {
            error_log("Erreur modification livre: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la modification du livre";
        }

        header('Location: index.php?controller=livre&action=index');
        exit;
    }

    /**
     * Suppression
     */
    public function delete() {
        // Sécurité : réservé au staff
        Auth::requireStaff();

        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] <= 0) {
            $_SESSION['error'] = 'ID invalide';
            header('Location: index.php?controller=livre&action=index');
            exit;
        }

        $id = (int)$_GET['id'];
        $livre = $this->livreModel->findByIdWithDetails($id);

        if (!$livre) {
            $_SESSION['error'] = 'Livre non trouvé';
            header('Location: index.php?controller=livre&action=index');
            exit;
        }

        try {
            $this->livreModel->delete($id);
            $_SESSION['success'] = "Livre supprimé avec succès";
        } catch (Exception $e) {
            error_log("Erreur suppression livre: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la suppression";
        }

        header('Location: index.php?controller=livre&action=index');
        exit;
    }
}
