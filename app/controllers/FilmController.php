<?php
/**
 * Contrôleur Film (Admin)
 * SAE R307 - Médiathèque
 */

require_once __DIR__ . '/../models/Film.php';
require_once __DIR__ . '/../models/Genre.php';
require_once __DIR__ . '/../models/Theme.php';

class FilmController extends Controller {

    private $filmModel;
    private $genreModel;
    private $themeModel;

    public function __construct() {
        $this->filmModel = new Film();
        $this->genreModel = new Genre();
        $this->themeModel = new Theme();
    }

    /**
     * Liste des films (admin)
     */
    public function index() {
        // Sécurité : réservé au staff
        Auth::requireStaff();

        $films = $this->filmModel->getAllWithDetails();
        $this->render('admin/film/index', [
            'films' => $films
        ], 'Gestion des films');
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

        $this->render('admin/film/create', [
            'genres' => $genres,
            'themes' => $themes
        ], 'Créer un film');
    }

    /**
     * Traitement création
     */
    public function createPost() {
        // Sécurité : réservé au staff
        Auth::requireStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=film&action=index');
            exit;
        }

        // Récupérer les données
        $errors = [];

        // Données ressource
        $titre = trim($_POST['titre'] ?? '');
        $realisateur = trim($_POST['auteur_realisateur'] ?? '');
        $annee = trim($_POST['annee'] ?? '');
        $resume = trim($_POST['resume'] ?? '');
        $image_url = trim($_POST['image_url'] ?? '');

        // Données film
        $duree = trim($_POST['duree'] ?? '');
        $support = trim($_POST['support'] ?? '');
        $langue = trim($_POST['langue'] ?? '');

        // Relations
        $genreIds = $_POST['genres'] ?? [];
        $themeIds = $_POST['themes'] ?? [];

        // Validation ressource
        if (empty($titre)) {
            $errors['titre'] = 'Le titre est requis';
        } elseif (strlen($titre) > 255) {
            $errors['titre'] = 'Maximum 255 caractères';
        }

        if (empty($realisateur)) {
            $errors['realisateur'] = 'Le réalisateur est requis';
        } elseif (strlen($realisateur) > 255) {
            $errors['realisateur'] = 'Maximum 255 caractères';
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

        // Validation film
        if (empty($duree) || !is_numeric($duree)) {
            $errors['duree'] = 'Durée invalide';
        } elseif ($duree <= 0 || $duree > 1000) {
            $errors['duree'] = 'La durée doit être entre 1 et 1000 minutes';
        }

        $supportsValides = ['DVD', 'Blu-ray', 'Streaming'];
        if (empty($support)) {
            $errors['support'] = 'Le support est requis';
        } elseif (!in_array($support, $supportsValides, true)) {
            $errors['support'] = 'Le support doit être DVD, Blu-ray ou Streaming';
        }

        if (empty($langue)) {
            $errors['langue'] = 'La langue est requise';
        } elseif (strlen($langue) > 50) {
            $errors['langue'] = 'Maximum 50 caractères';
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
            header('Location: index.php?controller=film&action=create');
            exit;
        }

        // Créer le film
        try {
            $dataRessource = [
                'titre' => $titre,
                'auteur_realisateur' => $realisateur,
                'annee' => (int)$annee,
                'resume' => $resume,
                'image_url' => $image_url
            ];

            $dataFilm = [
                'duree' => (int)$duree,
                'support' => $support,
                'langue' => $langue
            ];

            $this->filmModel->create([
                'ressource' => $dataRessource,
                'film' => $dataFilm,
                'genres' => $genreIds,
                'themes' => $themeIds
            ]);
            $_SESSION['success'] = "Film créé avec succès";
        } catch (Exception $e) {
            error_log("Erreur création film: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la création du film";
        }

        header('Location: index.php?controller=film&action=index');
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
            header('Location: index.php?controller=film&action=index');
            exit;
        }

        $id = (int)$_GET['id'];
        $film = $this->filmModel->findByIdWithDetails($id);

        if (!$film) {
            $_SESSION['error'] = 'Film non trouvé';
            header('Location: index.php?controller=film&action=index');
            exit;
        }

        // Charger les données pour les formulaires
        $genres = $this->genreModel->getAll();
        $themes = $this->themeModel->getAll();
        $selectedGenres = $this->filmModel->getGenreIds($id);
        $selectedThemes = $this->filmModel->getThemeIds($id);

        $this->render('admin/film/edit', [
            'film' => $film,
            'genres' => $genres,
            'themes' => $themes,
            'selectedGenres' => $selectedGenres,
            'selectedThemes' => $selectedThemes
        ], 'Modifier un film');
    }

    /**
     * Traitement édition
     */
    public function editPost() {
        // Sécurité : réservé au staff
        Auth::requireStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=film&action=index');
            exit;
        }

        // Récupérer les données
        $id = (int)($_POST['id'] ?? 0);
        $errors = [];

        if ($id <= 0) {
            $_SESSION['error'] = 'ID invalide';
            header('Location: index.php?controller=film&action=index');
            exit;
        }

        // Données ressource
        $titre = trim($_POST['titre'] ?? '');
        $realisateur = trim($_POST['auteur_realisateur'] ?? '');
        $annee = trim($_POST['annee'] ?? '');
        $resume = trim($_POST['resume'] ?? '');
        $image_url = trim($_POST['image_url'] ?? '');

        // Données film
        $duree = trim($_POST['duree'] ?? '');
        $support = trim($_POST['support'] ?? '');
        $langue = trim($_POST['langue'] ?? '');

        // Relations
        $genreIds = $_POST['genres'] ?? [];
        $themeIds = $_POST['themes'] ?? [];

        // Validation (même logique que create)
        if (empty($titre)) {
            $errors['titre'] = 'Le titre est requis';
        } elseif (strlen($titre) > 255) {
            $errors['titre'] = 'Maximum 255 caractères';
        }

        if (empty($realisateur)) {
            $errors['realisateur'] = 'Le réalisateur est requis';
        } elseif (strlen($realisateur) > 255) {
            $errors['realisateur'] = 'Maximum 255 caractères';
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

        if (empty($duree) || !is_numeric($duree)) {
            $errors['duree'] = 'Durée invalide';
        } elseif ($duree <= 0 || $duree > 1000) {
            $errors['duree'] = 'La durée doit être entre 1 et 1000 minutes';
        }

        $supportsValides = ['DVD', 'Blu-ray', 'Streaming'];
        if (empty($support)) {
            $errors['support'] = 'Le support est requis';
        } elseif (!in_array($support, $supportsValides, true)) {
            $errors['support'] = 'Le support doit être DVD, Blu-ray ou Streaming';
        }

        if (empty($langue)) {
            $errors['langue'] = 'La langue est requise';
        } elseif (strlen($langue) > 50) {
            $errors['langue'] = 'Maximum 50 caractères';
        }

        if (!is_array($genreIds)) $genreIds = [];
        if (!is_array($themeIds)) $themeIds = [];

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: index.php?controller=film&action=edit&id=' . $id);
            exit;
        }

        // Modifier le film
        try {
            $dataRessource = [
                'titre' => $titre,
                'auteur_realisateur' => $realisateur,
                'annee' => (int)$annee,
                'resume' => $resume,
                'image_url' => $image_url
            ];

            $dataFilm = [
                'duree' => (int)$duree,
                'support' => $support,
                'langue' => $langue
            ];

            $this->filmModel->update($id, [
                'ressource' => $dataRessource,
                'film' => $dataFilm,
                'genres' => $genreIds,
                'themes' => $themeIds
            ]);
            $_SESSION['success'] = "Film modifié avec succès";
        } catch (Exception $e) {
            error_log("Erreur modification film: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la modification du film";
        }

        header('Location: index.php?controller=film&action=index');
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
            header('Location: index.php?controller=film&action=index');
            exit;
        }

        $id = (int)$_GET['id'];
        $film = $this->filmModel->findByIdWithDetails($id);

        if (!$film) {
            $_SESSION['error'] = 'Film non trouvé';
            header('Location: index.php?controller=film&action=index');
            exit;
        }

        try {
            $this->filmModel->delete($id);
            $_SESSION['success'] = "Film supprimé avec succès";
        } catch (Exception $e) {
            error_log("Erreur suppression film: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la suppression";
        }

        header('Location: index.php?controller=film&action=index');
        exit;
    }
}
