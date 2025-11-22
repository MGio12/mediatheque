# 🏗️ Architecture E-Library

## Vue d'ensemble

E-Library est une application web PHP suivant le pattern **MVC (Model-View-Controller)** avec une architecture en couches.

## Diagramme architectural

```
┌─────────────────────────────────────────────────────────────┐
│                      NAVIGATEUR (Client)                     │
│                    HTML + CSS + JavaScript                   │
└────────────────────────────┬────────────────────────────────┘
                             │ HTTP Request/Response
                             ▼
┌─────────────────────────────────────────────────────────────┐
│                    SERVEUR WEB (Apache/Nginx)                │
└────────────────────────────┬────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────┐
│                         index.php                            │
│                    (Front Controller)                        │
└────────────────────────────┬────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────┐
│                          Router                              │
│              Parse URL → Controller/Action                   │
└────────────────────────────┬────────────────────────────────┘
                             │
         ┌───────────────────┼───────────────────┐
         ▼                   ▼                   ▼
┌────────────────┐  ┌────────────────┐  ┌────────────────┐
│  Controllers   │  │  Controllers   │  │  Controllers   │
│   (Front)      │  │   (Admin)      │  │   (Auth)       │
└───────┬────────┘  └───────┬────────┘  └───────┬────────┘
        │                   │                   │
        └───────────────────┼───────────────────┘
                            ▼
                   ┌─────────────────┐
                   │   Auth Helper   │
                   │  (Middleware)   │
                   └────────┬────────┘
                            │
                   ┌────────┴────────┐
                   ▼                 ▼
          ┌────────────────┐  ┌──────────────┐
          │     Models     │  │    Views     │
          │  (Business)    │  │ (Templates)  │
          └───────┬────────┘  └──────────────┘
                  │
                  ▼
          ┌────────────────┐
          │   Database     │
          │  (Singleton)   │
          └───────┬────────┘
                  │
                  ▼
          ┌────────────────┐
          │  MySQL (PDO)   │
          └────────────────┘
```

## Pattern MVC

### 🎮 Controllers (app/controllers/)

Gèrent la logique de contrôle et orchestrent les interactions.

**Responsabilités :**
- Recevoir et analyser les requêtes HTTP
- Appeler les modèles pour récupérer/modifier les données
- Passer les données aux vues
- Gérer les redirections
- Vérifier les autorisations

**Liste des contrôleurs :**
- `HomeController` : Page d'accueil
- `AuthController` : Authentification (login, register, logout)
- `CatalogueController` : Catalogue, recherche, nouveautés, top
- `RessourceController` : Détails d'une ressource
- `LivreController` : CRUD livres (admin)
- `FilmController` : CRUD films (admin)
- `GenreController` : CRUD genres (admin)
- `ThemeController` : CRUD thèmes (admin)
- `EvaluationController` : Gestion des évaluations
- `AdminController` : Dashboard administrateur

**Base :** Tous héritent de `core/Controller.php`

### 💾 Models (app/models/)

Gèrent l'accès aux données et la logique métier.

**Responsabilités :**
- Interagir avec la base de données via PDO
- Valider les données entrantes
- Appliquer les règles métier
- Retourner des données structurées

**Liste des modèles :**
- `Utilisateur` : Gestion des utilisateurs
- `Ressource` : Ressources génériques (parent)
- `Livre` : Spécialisation pour les livres
- `Film` : Spécialisation pour les films
- `Genre` : Gestion des genres
- `Theme` : Gestion des thèmes
- `Evaluation` : Gestion des notes et critiques

**Base :** Tous héritent de `core/Model.php`

**Pattern utilisé :** Active Record (chaque modèle représente une table)

### 🖼️ Views (app/views/)

Affichent les données à l'utilisateur.

**Responsabilités :**
- Générer le HTML
- Afficher les données passées par le contrôleur
- Échapper les variables (XSS protection)
- Utiliser le layout et les partials

**Structure :**
```
views/
├── layout.php           # Template principal
├── partials/
│   ├── header.php       # En-tête
│   └── footer.php       # Pied de page
├── home/
│   └── index.php        # Page d'accueil
├── auth/
│   ├── login.php
│   └── register.php
├── catalogue/
│   ├── index.php
│   ├── nouveautes.php
│   ├── top.php
│   ├── selection.php
│   └── search.php
├── ressource/
│   └── show.php
└── admin/
    ├── dashboard.php
    └── [livre|film|genre|theme]/
        ├── index.php
        ├── create.php
        └── edit.php
```

## Core Framework (core/)

### 🔌 Router (core/Router.php)

**Rôle :** Analyser l'URL et router vers le bon contrôleur/action.

**Format URL :** `/controller/action/params`

**Exemples :**
- `/` → `HomeController::index()`
- `/auth/login` → `AuthController::login()`
- `/ressource/show/5` → `RessourceController::show(5)`
- `/admin/livres` → `LivreController::index()`

**Sécurité :**
- Validation des noms de contrôleurs (regex `[a-zA-Z]+`)
- Vérification de l'existence des classes/méthodes
- Page 404 si route invalide

### 🔒 Auth (core/Auth.php)

**Rôle :** Gérer l'authentification et les autorisations.

**Méthodes statiques :**
- `Auth::check()` : Vérifie si l'utilisateur est connecté
- `Auth::user()` : Retourne l'utilisateur connecté
- `Auth::hasRole($role)` : Vérifie si l'utilisateur a un rôle
- `Auth::requireAuth()` : Force l'authentification
- `Auth::requireRole($role)` : Force un rôle spécifique
- `Auth::requireStaff()` : Force admin ou bibliothécaire
- `Auth::isStaff()` : Vérifie si admin ou bibliothécaire

**Stockage :** Session PHP (`$_SESSION['user']`)

**Rôles disponibles :**
- `utilisateur` : Utilisateur standard
- `bibliothecaire` : Bibliothécaire (peut gérer les ressources)
- `administrateur` : Administrateur (tous les droits)

### 💿 Database (core/Database.php)

**Rôle :** Gérer la connexion à la base de données.

**Pattern :** Singleton (une seule instance PDO partagée)

**Configuration :** Via `config/config.php`

**Caractéristiques :**
- Connexion PDO persistante
- Mode d'erreur : Exceptions
- Charset : UTF-8
- Détection automatique du port (3306 ou 8889 pour MAMP)

### 🎛️ Controller (core/Controller.php)

**Rôle :** Classe de base pour tous les contrôleurs.

**Méthodes fournies :**
- `renderView($view, $data)` : Affiche une vue
- `redirect($url)` : Redirige vers une URL
- `setFlash($type, $message)` : Définit un message flash

### 📦 Model (core/Model.php)

**Rôle :** Classe de base pour tous les modèles.

**Fournit :** Accès à l'instance PDO via `$this->pdo`

## Flux de données

### Exemple : Affichage d'une ressource

```
1. User → GET /ressource/show/5
2. index.php → Router
3. Router → RessourceController::show(5)
4. Controller → Auth::check() ✓
5. Controller → Ressource::findById(5)
6. Model → Database (PDO)
7. Database → MySQL: SELECT * FROM ressource WHERE id=5
8. MySQL → Database: [données]
9. Database → Model: [données]
10. Model → Controller: $ressource
11. Controller → Ressource::getEvaluations(5)
12. Model → Database → MySQL
13. MySQL → Model → Controller: $evaluations
14. Controller → renderView('ressource/show', [
      'ressource' => $ressource,
      'evaluations' => $evaluations
    ])
15. View → layout.php (inclut show.php)
16. layout.php → HTML généré
17. HTML → User (navigateur)
```

### Exemple : Création d'un livre (Admin)

```
1. User → POST /livre/store
2. Router → LivreController::store()
3. Controller → Auth::requireStaff() ✓
4. Controller → Livre::validate($_POST)
5. Model → Validation des données
6. Model → Controller: errors[] ou true
7. IF errors:
     Controller → renderView('livre/create') avec erreurs
   ELSE:
     Controller → Database: BEGIN TRANSACTION
     Controller → Livre::createRessource()
     Model → INSERT INTO ressource
     Model → Controller: ressourceId
     Controller → Livre::createLivre()
     Model → INSERT INTO livre
     Controller → Livre::associateGenres()
     Model → INSERT INTO ressource_genre (multiple)
     Controller → Livre::associateThemes()
     Model → INSERT INTO ressource_theme (multiple)
     Controller → Database: COMMIT
     Controller → redirect('/admin/livres')
8. User → Page liste livres avec message succès
```

## Sécurité

### Protection SQL Injection

**Méthode :** PDO avec prepared statements

```php
// ✅ BON
$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
$stmt->execute(['email' => $email]);

// ❌ MAUVAIS (vulnérable)
$result = $pdo->query("SELECT * FROM utilisateur WHERE email = '$email'");
```

**Implémentation :** 100% des requêtes utilisent des prepared statements.

### Protection XSS

**Méthode :** Échappement avec `htmlspecialchars()`

```php
// Dans toutes les vues
<?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?>
```

**Implémentation :** Tous les affichages de données utilisateur sont échappés.

### Hachage des mots de passe

**Méthode :** Bcrypt via `password_hash()` et `password_verify()`

```php
// Lors de l'inscription
$hash = password_hash($password, PASSWORD_DEFAULT);

// Lors de la connexion
if (password_verify($password, $hash)) {
    // OK
}
```

### Contrôle d'accès

**Middleware :** Classe `Auth`

```php
// Dans un contrôleur admin
public function __construct() {
    Auth::requireStaff(); // Redirige si non autorisé
}
```

## Base de données

### Schéma relationnel

**Tables principales :**
- `utilisateur` (id, nom, prenom, email, mot_de_passe, role, date_inscription)
- `ressource` (id, type, titre, auteur_realisateur, annee, resume, image_url, pays, date_ajout)
- `livre` (id_ressource FK, isbn, editeur, nombre_pages, prix)
- `film` (id_ressource FK, duree, support, langue, sous_titres)
- `genre` (id, nom)
- `theme` (id, nom)
- `evaluation` (id, id_utilisateur FK, id_ressource FK, note, critique, date)

**Tables associatives :**
- `ressource_genre` (id_ressource FK, id_genre FK)
- `ressource_theme` (id_ressource FK, id_theme FK)

**Pattern :** Table Inheritance (ressource → livre/film)

### Contraintes

- **Foreign Keys** : Toutes avec `ON DELETE CASCADE`
- **Unique** : email (utilisateur), isbn (livre), (utilisateur, ressource) pour évaluation
- **Indexes** : Sur type, titre, auteur, email, role, note

## Frontend

### CSS (public/css/style.css)

**Caractéristiques :**
- 1309 lignes de CSS personnalisé
- Variables CSS pour theming
- Dark mode support
- Design responsive
- Grid layout
- Animations fluides
- Design de Noël avec flocons animés

### JavaScript (public/js/)

**Actuellement :**
- Dark mode toggle (inline)
- Character counter pour critiques (inline)
- localStorage pour préférences

**À développer :**
- Validation formulaires côté client
- AJAX pour recherche dynamique
- Upload d'images

### Images (public/img/)

**Structure :**
- `livres/` : Couvertures de livres
- `films/` : Affiches de films
- `placeholders/` : Images par défaut

## Performance

### Optimisations actuelles
- Une seule connexion DB (Singleton)
- Prepared statements (cache côté MySQL)
- Indexes sur colonnes fréquemment requêtées
- CSS minifié en production

### Optimisations futures
- Cache Redis pour sessions
- Cache de requêtes (Memcached)
- CDN pour assets statiques
- Lazy loading des images
- Pagination des résultats

## Extensibilité

### Ajouter un nouveau type de ressource

1. Créer la table SQL (héritant de `ressource`)
2. Créer le modèle (`app/models/NouveauType.php`)
3. Créer le contrôleur (`app/controllers/NouveauTypeController.php`)
4. Créer les vues (`app/views/nouveau-type/`)
5. Ajouter les routes dans le Router

### Ajouter une fonctionnalité

1. Déterminer le contrôleur concerné
2. Ajouter la méthode au contrôleur
3. Ajouter les méthodes nécessaires au(x) modèle(s)
4. Créer la vue correspondante
5. Ajouter le lien dans la navigation

## Conclusion

L'architecture E-Library est :
- ✅ **Modulaire** : Séparation claire des responsabilités
- ✅ **Sécurisée** : Protection contre les attaques courantes
- ✅ **Maintenable** : Code organisé et documenté
- ✅ **Extensible** : Facile d'ajouter de nouvelles fonctionnalités
- ✅ **Standard** : Suit les conventions PHP et MVC

Pour plus de détails, consulter les diagrammes UML dans [`documentation/diagrammes/`](diagrammes/).
