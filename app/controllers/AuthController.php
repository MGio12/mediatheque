<?php
/**
 * Contrôleur Authentification
 * SAE R307 - Médiathèque
 */

// Charger le modèle Utilisateur
require_once __DIR__ . '/../models/Utilisateur.php';

class AuthController extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = new Utilisateur();
    }

    /**
     * Page de connexion (affichage formulaire)
     */
    public function login() {
        // Si déjà connecté, rediriger vers l'accueil
        if (isset($_SESSION['user'])) {
            header("Location: index.php?controller=home&action=index");
            exit;
        }

        // Afficher le formulaire de connexion
        $error = null;
        $this->render('auth/login', [
            'error' => $error
        ], 'Connexion');
    }

    /**
     * Traitement de la connexion (POST)
     */
    public function loginPost() {
        // PROTECTION : Bloquer les requêtes GET
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $error = null;

        try {
            // Vérifier que les données POST existent
            if (!isset($_POST['email']) || !isset($_POST['password'])) {
                $error = "Données de formulaire manquantes.";
            } else {
                $email = trim($_POST['email']);
                $password = $_POST['password'];

                // Validation basique
                if (empty($email) || empty($password)) {
                    $error = "Veuillez remplir tous les champs.";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = "Email invalide.";
                } else {
                    // Vérifier les identifiants (peut lever une exception PDO)
                    $user = $this->userModel->verifyCredentials($email, $password);

                    if ($user) {
                        // Connexion réussie : créer la session
                        $_SESSION['user'] = [
                            'id_utilisateur' => $user['id_utilisateur'],
                            'nom' => $user['nom'],
                            'prenom' => $user['prenom'],
                            'email' => $user['email'],
                            'role' => $user['role']
                        ];

                        // Rediriger vers l'accueil
                        header("Location: index.php?controller=home&action=index");
                        exit;
                    } else {
                        $error = "Email ou mot de passe incorrect.";
                    }
                }
            }
        } catch (Exception $e) {
            // Capturer toute exception (notamment PDO)
            error_log("Erreur loginPost: " . $e->getMessage());
            $error = "Une erreur est survenue lors de la connexion. Veuillez réessayer.";
        }

        // Si erreur, réafficher le formulaire avec le message
        $this->render('auth/login', [
            'error' => $error
        ], 'Connexion');
    }

    /**
     * Page d'inscription (affichage formulaire)
     */
    public function register() {
        // Si déjà connecté, rediriger vers l'accueil
        if (isset($_SESSION['user'])) {
            header("Location: index.php?controller=home&action=index");
            exit;
        }

        // Afficher le formulaire d'inscription
        $error = null;
        $success = null;
        $this->render('auth/register', [
            'error' => $error,
            'success' => $success
        ], 'Inscription');
    }

    /**
     * Traitement de l'inscription (POST)
     */
    public function registerPost() {
        // PROTECTION : Bloquer les requêtes GET
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?controller=auth&action=register");
            exit;
        }

        $error = null;
        $success = null;

        try {
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validations
            if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
                $error = "Tous les champs sont obligatoires.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email invalide.";
            } elseif (strlen($password) < 8) {
                $error = "Le mot de passe doit contenir au moins 8 caractères.";
            } elseif ($password !== $confirmPassword) {
                $error = "Les mots de passe ne correspondent pas.";
            } else {
                // Vérifier si l'email existe déjà
                $existingUser = $this->userModel->findByEmail($email);

                if ($existingUser) {
                    $error = "Cet email est déjà utilisé.";
                } else {
                    // Créer l'utilisateur
                    $newUser = $this->userModel->createUser([
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'email' => $email,
                        'mot_de_passe' => $password,
                        'role' => 'utilisateur' // Par défaut
                    ]);

                    if ($newUser) {
                        $success = "Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.";
                    } else {
                        $error = "Une erreur est survenue lors de la création du compte.";
                    }
                }
            }
        } catch (Exception $e) {
            // Capturer toute exception
            error_log("Erreur registerPost: " . $e->getMessage());
            $error = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
        }

        // Réafficher le formulaire avec le message
        $this->render('auth/register', [
            'error' => $error,
            'success' => $success
        ], 'Inscription');
    }

    /**
     * Déconnexion
     */
    public function logout() {
        // Détruire la session (ordre correct)
        unset($_SESSION['user']);
        session_destroy();

        // Rediriger vers la page de connexion
        header("Location: index.php?controller=auth&action=login");
        exit;
    }

    /**
     * Alias pour la route par défaut
     */
    public function index() {
        $this->login();
    }
}
