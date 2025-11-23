# ARCHITECTURE E-LIBRARY

## VUE D'ENSEMBLE

E-Library est une application web PHP suivant le pattern **MVC (Model-View-Controller)** avec une architecture en couches modulaire et sécurisée.

### Diagramme architectural global

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

---

## PATTERN MVC - ARCHITECTURE EN COUCHES

### Controllers (app/controllers/)

Les contrôleurs orchestrent la logique applicative et gèrent les interactions entre les modèles et les vues.

#### Responsabilités des contrôleurs

| Responsabilité | Description |
|---------------|-------------|
| **Gestion des requêtes** | Recevoir et analyser les requêtes HTTP (GET, POST) |
| **Orchestration** | Appeler les modèles pour récupérer/modifier les données |
| **Transmission** | Passer les données formatées aux vues |
| **Navigation** | Gérer les redirections entre les pages |
| **Sécurité** | Vérifier les autorisations d'accès via Auth |
| **Validation** | Contrôler les données entrantes avant traitement |

#### Liste des contrôleurs

| Contrôleur | Rôle | Accès |
|-----------|------|-------|
| **HomeController** | Page d'accueil avec mise en avant | Public |
| **AuthController** | Authentification (login, register, logout) | Public |
| **CatalogueController** | Catalogue, recherche, nouveautés, top | Public |
| **RessourceController** | Détails d'une ressource spécifique | Public |
| **EvaluationController** | Gestion des notes et critiques | Utilisateur connecté |
| **LivreController** | CRUD livres (création, modification, suppression) | Staff (bibliothécaire/admin) |
| **FilmController** | CRUD films (création, modification, suppression) | Staff (bibliothécaire/admin) |
| **GenreController** | CRUD genres | Administrateur |
| **ThemeController** | CRUD thèmes | Administrateur |
| **AdminController** | Dashboard administrateur | Administrateur |

**Héritage :** Tous les contrôleurs héritent de `core/Controller.php` qui fournit les méthodes communes (render, redirect, setFlash).

---

### Models (app/models/)

Les modèles gèrent l'accès aux données et implémentent la logique métier.

#### Responsabilités des modèles

| Responsabilité | Description |
|---------------|-------------|
| **Accès données** | Interagir avec la base de données via PDO |
| **Validation** | Valider les données entrantes selon les règles métier |
| **Logique métier** | Appliquer les règles et contraintes métier |
| **Formatage** | Retourner des données structurées et formatées |
| **Requêtes SQL** | Construire et exécuter les requêtes préparées |

#### Liste des modèles

| Modèle | Rôle | Table(s) associée(s) |
|--------|------|---------------------|
| **Utilisateur** | Gestion des utilisateurs, authentification | utilisateur |
| **Ressource** | Ressources génériques (classe parente) | ressource |
| **Livre** | Spécialisation pour les livres | ressource + livre |
| **Film** | Spécialisation pour les films | ressource + film |
| **Genre** | Gestion des genres | genre + ressource_genre |
| **Theme** | Gestion des thèmes | theme + ressource_theme |
| **Evaluation** | Gestion des notes et critiques | evaluation |

**Héritage :** Tous les modèles héritent de `core/Model.php` qui fournit l'accès à la connexion PDO.

**Pattern utilisé :** Active Record (chaque modèle représente une table et encapsule les opérations CRUD).

---

### Views (app/views/)

Les vues sont responsables de la présentation des données à l'utilisateur.

#### Responsabilités des vues

| Responsabilité | Description |
|---------------|-------------|
| **Génération HTML** | Créer le markup HTML à partir des données |
| **Affichage données** | Présenter les données passées par le contrôleur |
| **Protection XSS** | Échapper systématiquement les variables avec htmlspecialchars() |
| **Templates** | Utiliser le layout principal et les partials |
| **UX** | Fournir une interface utilisateur intuitive et responsive |

#### Structure du dossier views

```
app/views/
├── layout.php                  # Template principal (header + content + footer)
├── partials/
│   ├── header.php             # En-tête avec navigation
│   └── footer.php             # Pied de page
├── home/
│   └── index.php              # Page d'accueil
├── auth/
│   ├── login.php              # Formulaire de connexion
│   └── register.php           # Formulaire d'inscription
├── catalogue/
│   ├── index.php              # Catalogue complet
│   ├── nouveautes.php         # Dernières ressources ajoutées
│   ├── top.php                # Ressources les mieux notées
│   ├── selection.php          # Sélection par thème
│   └── search.php             # Recherche avancée
├── ressource/
│   └── show.php               # Détails d'une ressource
└── admin/
    ├── index.php              # Dashboard admin
    ├── livre/
    │   ├── index.php          # Liste des livres
    │   ├── create.php         # Formulaire ajout livre
    │   └── edit.php           # Formulaire modification livre
    ├── film/
    │   ├── index.php          # Liste des films
    │   ├── create.php         # Formulaire ajout film
    │   └── edit.php           # Formulaire modification film
    ├── genre/
    │   ├── index.php          # Liste des genres
    │   ├── create.php         # Formulaire ajout genre
    │   └── edit.php           # Formulaire modification genre
    └── theme/
        ├── index.php          # Liste des thèmes
        ├── create.php         # Formulaire ajout thème
        └── edit.php           # Formulaire modification thème
```

---

## CORE FRAMEWORK (core/)

### Router (core/Router.php)

Le routeur analyse l'URL et dirige la requête vers le contrôleur et l'action appropriés.

#### Fonctionnement

**Format URL :** `index.php?controller=nom&action=methode&param=valeur`

**Exemples de routage :**

| URL | Résolution |
|-----|-----------|
| `index.php` | HomeController::index() |
| `index.php?controller=auth&action=login` | AuthController::login() |
| `index.php?controller=ressource&action=show&id=5` | RessourceController::show() |
| `index.php?controller=admin&action=index` | AdminController::index() |

#### Sécurité du routeur

| Mécanisme | Implementation |
|-----------|---------------|
| **Validation des noms** | Regex `[a-zA-Z]+` pour controller et action |
| **Vérification existence** | Contrôle de l'existence du fichier contrôleur |
| **Vérification classe** | Contrôle de l'existence de la classe |
| **Vérification méthode** | Contrôle de l'existence de la méthode |
| **Gestion erreurs** | Page 404 personnalisée si route invalide |

---

### Auth (core/Auth.php)

La classe Auth gère l'authentification et les autorisations de manière centralisée.

#### Méthodes statiques disponibles

| Méthode | Paramètres | Retour | Description |
|---------|-----------|--------|-------------|
| `Auth::check()` | - | boolean | Vérifie si l'utilisateur est connecté |
| `Auth::user()` | - | array/null | Retourne les données de l'utilisateur connecté |
| `Auth::hasRole($role)` | string | boolean | Vérifie si l'utilisateur a un rôle spécifique |
| `Auth::requireAuth()` | - | void | Force l'authentification (redirige sinon) |
| `Auth::requireRole($role)` | string | void | Force un rôle spécifique (redirige sinon) |
| `Auth::requireStaff()` | - | void | Force admin ou bibliothécaire |
| `Auth::isStaff()` | - | boolean | Vérifie si admin ou bibliothécaire |

#### Rôles disponibles

| Rôle | Valeur | Permissions |
|------|--------|-------------|
| **Utilisateur** | `utilisateur` | Consultation, recherche, évaluation |
| **Bibliothécaire** | `bibliothecaire` | + Gestion des ressources (CRUD livres/films) |
| **Administrateur** | `administrateur` | + Gestion des référentiels (genres/thèmes) + Gestion utilisateurs |

**Stockage :** Les données de session sont stockées dans `$_SESSION['user']` après authentification réussie.

---

### Database (core/Database.php)

Gère la connexion à la base de données de manière centralisée.

#### Caractéristiques

| Aspect | Détails |
|--------|---------|
| **Pattern** | Singleton (une seule instance PDO partagée) |
| **Driver** | PDO MySQL |
| **Configuration** | Via `config/config.php` |
| **Mode erreur** | Exceptions (PDO::ERRMODE_EXCEPTION) |
| **Charset** | UTF-8 (utf8mb4) |
| **Connexion** | Persistante pour optimisation |
| **Auto-détection port** | 3306 (standard) ou 8889 (MAMP) |

#### Avantages du Singleton

- Une seule connexion partagée entre tous les modèles
- Économie de ressources
- Gestion centralisée de la configuration
- Facilite les transactions

---

### Controller (core/Controller.php)

Classe de base abstraite dont héritent tous les contrôleurs.

#### Méthodes fournies

| Méthode | Paramètres | Description |
|---------|-----------|-------------|
| `render($view, $data)` | view: string, data: array | Affiche une vue avec des données |
| `redirect($url)` | url: string | Redirige vers une URL |
| `setFlash($type, $message)` | type: string, message: string | Définit un message flash (success/error/info) |

---

### Model (core/Model.php)

Classe de base abstraite dont héritent tous les modèles.

#### Propriétés fournies

| Propriété | Type | Description |
|-----------|------|-------------|
| `$this->pdo` | PDO | Instance de connexion à la base de données |
| `$this->table` | string | Nom de la table (défini dans classe enfant) |

---

## FLUX DE DONNÉES

### Exemple 1 : Affichage d'une ressource

```
ÉTAPE 1 - Requête utilisateur
User → GET index.php?controller=ressource&action=show&id=5

ÉTAPE 2 - Routage
index.php → Router::dispatch('ressource', 'show')
Router → RessourceController::show()

ÉTAPE 3 - Vérification authentification
Controller → Auth::check()
(Optionnel selon la page)

ÉTAPE 4 - Récupération ressource
Controller → Ressource::findById(5)
Model → Database::getPDO()
Database → MySQL: SELECT r.*, l.*, f.* FROM ressource r
                  LEFT JOIN livre l ON r.id = l.id_ressource
                  LEFT JOIN film f ON r.id = f.id_ressource
                  WHERE r.id = 5
MySQL → Model → Controller: $ressource (array)

ÉTAPE 5 - Récupération évaluations
Controller → Ressource::getEvaluations(5)
Model → Database → MySQL: SELECT e.*, u.nom, u.prenom
                          FROM evaluation e
                          JOIN utilisateur u ON e.id_utilisateur = u.id
                          WHERE e.id_ressource = 5
MySQL → Model → Controller: $evaluations (array)

ÉTAPE 6 - Calcul note moyenne
Controller → Ressource::getAverageRating(5)
Model → Database → MySQL: SELECT AVG(note) FROM evaluation WHERE id_ressource = 5
MySQL → Model → Controller: $noteM moyenne (float)

ÉTAPE 7 - Rendu de la vue
Controller → render('ressource/show', [
    'ressource' => $ressource,
    'evaluations' => $evaluations,
    'noteMoyenne' => $noteMoyenne
])
View → layout.php (inclut show.php avec données)
layout.php → HTML complet généré

ÉTAPE 8 - Réponse
HTML → User (navigateur affiche la page)
```

---

### Exemple 2 : Création d'un livre (Administrateur)

```
ÉTAPE 1 - Requête utilisateur
User → POST index.php?controller=livre&action=store
POST data: {titre, auteur, annee, isbn, editeur, pages, prix, genres[], themes[]}

ÉTAPE 2 - Routage et sécurité
Router → LivreController::store()
Controller → Auth::requireStaff()
Auth → Vérifie $_SESSION['user']['role']
Si non autorisé → redirect('index.php?controller=auth&action=login')

ÉTAPE 3 - Validation des données
Controller → Livre::validate($_POST)
Model → Vérification des champs requis
Model → Validation des types (annee: int, prix: float)
Model → Vérification unicité ISBN
Model → Controller: ['errors' => [...]] OU ['success' => true]

ÉTAPE 4a - Si erreurs de validation
Controller → render('livre/create', ['errors' => $errors, 'old' => $_POST])
User reçoit le formulaire avec messages d'erreur

ÉTAPE 4b - Si validation OK - Transaction
Controller → Database::beginTransaction()

ÉTAPE 5 - Création de la ressource parente
Controller → Livre::createRessource($_POST)
Model → INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url, pays)
         VALUES ('livre', :titre, :auteur, :annee, :resume, :image, :pays)
MySQL → Model: lastInsertId = 15
Model → Controller: $ressourceId = 15

ÉTAPE 6 - Création du livre spécifique
Controller → Livre::createLivre($ressourceId, $_POST)
Model → INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages, prix)
         VALUES (:id, :isbn, :editeur, :pages, :prix)

ÉTAPE 7 - Association aux genres
Controller → Livre::associateGenres($ressourceId, $_POST['genres'])
Model → Pour chaque genre:
         INSERT INTO ressource_genre (id_ressource, id_genre)
         VALUES (:ressource, :genre)

ÉTAPE 8 - Association aux thèmes
Controller → Livre::associateThemes($ressourceId, $_POST['themes'])
Model → Pour chaque thème:
         INSERT INTO ressource_theme (id_ressource, id_theme)
         VALUES (:ressource, :theme)

ÉTAPE 9 - Validation transaction
Controller → Database::commit()
Controller → setFlash('success', 'Livre ajouté avec succès')
Controller → redirect('index.php?controller=livre&action=index')

ÉTAPE 10 - Affichage résultat
User → Page liste livres avec message de succès
```

---

## SÉCURITÉ

### Protection SQL Injection

#### Méthode : PDO avec Prepared Statements

Toutes les requêtes SQL utilisent des requêtes préparées avec paramètres liés.

**Exemple CORRECT (sécurisé) :**
```php
// Utilisation de paramètres nommés
$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch();

// Utilisation de paramètres positionnels
$stmt = $pdo->prepare("SELECT * FROM ressource WHERE id = ?");
$stmt->execute([$id]);
$ressource = $stmt->fetch();

// Avec bindValue pour typage strict
$stmt = $pdo->prepare("SELECT * FROM livre WHERE prix < :maxPrix");
$stmt->bindValue(':maxPrix', $maxPrix, PDO::PARAM_STR);
$stmt->execute();
```

**Exemple INCORRECT (vulnérable) :**
```php
// NE JAMAIS FAIRE : Concaténation directe (SQL Injection possible)
$result = $pdo->query("SELECT * FROM utilisateur WHERE email = '$email'");

// NE JAMAIS FAIRE : Interpolation de variables
$result = $pdo->query("SELECT * FROM ressource WHERE id = $id");
```

**Implémentation :** 100% des requêtes SQL du projet utilisent des prepared statements.

---

### Protection XSS (Cross-Site Scripting)

#### Méthode : Échappement avec htmlspecialchars()

Toutes les données affichées provenant de la base de données ou des utilisateurs sont échappées.

**Template standard :**
```php
<!-- Échappement de base -->
<?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?>

<!-- Avec valeur par défaut -->
<?= htmlspecialchars($user['nom'] ?? 'Anonyme', ENT_QUOTES, 'UTF-8') ?>

<!-- Pour attributs HTML -->
<input type="text" value="<?= htmlspecialchars($oldValue, ENT_QUOTES, 'UTF-8') ?>">

<!-- Pour URL -->
<a href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>">Lien</a>
```

**Exceptions :** Les données déjà validées et sûres (comme les constantes ou IDs numériques) peuvent être affichées directement.

**Implémentation :** Tous les affichages de données dynamiques sont systématiquement échappés dans les vues.

---

### Hachage des mots de passe

#### Méthode : Bcrypt via password_hash() et password_verify()

Les mots de passe ne sont jamais stockés en clair dans la base de données.

**Lors de l'inscription (Utilisateur::createUser()) :**
```php
// Génération du hash avec sel automatique
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

// Stockage dans la base
$stmt = $pdo->prepare("INSERT INTO utilisateur (email, mot_de_passe) VALUES (:email, :password)");
$stmt->execute([
    'email' => $email,
    'password' => $hashedPassword  // Hash stocké, jamais le mot de passe clair
]);
```

**Lors de la connexion (Utilisateur::verifyCredentials()) :**
```php
// Récupération du hash depuis la base
$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch();

// Vérification avec password_verify
if ($user && password_verify($plainPassword, $user['mot_de_passe'])) {
    // Authentification réussie
    return $user;
}

return false; // Échec authentification
```

**Avantages de bcrypt :**
- Résistant aux attaques par force brute (lent par conception)
- Sel automatique et unique pour chaque mot de passe
- Compatible avec les évolutions futures (PASSWORD_DEFAULT)
- Standard de l'industrie

---

### Contrôle d'accès basé sur les rôles

#### Méthode : Middleware Auth

Les contrôleurs protégés vérifient les permissions dans leur constructeur ou au début des méthodes.

**Exemple 1 : Protection niveau contrôleur (Admin) :**
```php
class AdminController extends Controller {

    public function __construct() {
        // Toutes les méthodes nécessitent le rôle administrateur
        Auth::requireRole('administrateur');
    }

    public function index() {
        // Code accessible uniquement aux administrateurs
    }
}
```

**Exemple 2 : Protection niveau méthode (Staff) :**
```php
class LivreController extends Controller {

    public function index() {
        // Liste publique, pas de protection nécessaire
    }

    public function create() {
        // Nécessite bibliothécaire ou administrateur
        Auth::requireStaff();

        // Code accessible uniquement au staff
    }

    public function store() {
        // Nécessite bibliothécaire ou administrateur
        Auth::requireStaff();

        // Traitement du formulaire
    }
}
```

**Exemple 3 : Protection conditionnelle :**
```php
class EvaluationController extends Controller {

    public function create() {
        // Nécessite utilisateur connecté (n'importe quel rôle)
        Auth::requireAuth();

        $userId = Auth::user()['id_utilisateur'];
        $ressourceId = $_POST['id_ressource'];

        // Vérifier qu'il n'a pas déjà évalué
        if ($this->hasAlreadyEvaluated($userId, $ressourceId)) {
            $this->setFlash('error', 'Vous avez déjà évalué cette ressource');
            $this->redirect("index.php?controller=ressource&action=show&id=$ressourceId");
            return;
        }

        // Traitement de l'évaluation
    }
}
```

---

## BASE DE DONNÉES

### Schéma relationnel

#### Tables principales

| Table | Clé primaire | Description | Champs principaux |
|-------|-------------|-------------|-------------------|
| **utilisateur** | id_utilisateur | Comptes utilisateurs | nom, prenom, email, mot_de_passe, role, date_inscription |
| **ressource** | id_ressource | Ressources génériques (parente) | type, titre, auteur_realisateur, annee, resume, image_url, pays, date_ajout |
| **livre** | id_ressource (FK) | Livres (enfant de ressource) | isbn, editeur, nombre_pages, prix |
| **film** | id_ressource (FK) | Films (enfant de ressource) | duree, support, langue, sous_titres |
| **genre** | id_genre | Genres des ressources | nom |
| **theme** | id_theme | Thèmes des ressources | nom |
| **evaluation** | id_evaluation | Notes et critiques | id_utilisateur (FK), id_ressource (FK), note, critique, date_evaluation |

#### Tables associatives (Many-to-Many)

| Table | Clés | Description |
|-------|------|-------------|
| **ressource_genre** | (id_ressource, id_genre) | Association ressources ↔ genres |
| **ressource_theme** | (id_ressource, id_theme) | Association ressources ↔ thèmes |

#### Pattern d'héritage : Table Inheritance

```
ressource (table parente)
    ├── livre (table enfant, spécialisation)
    └── film (table enfant, spécialisation)
```

**Avantages :**
- Partage des attributs communs (titre, auteur, annee)
- Spécialisation des attributs spécifiques (isbn pour livre, duree pour film)
- Requêtes simplifiées avec LEFT JOIN

---

### Contraintes d'intégrité

#### Foreign Keys (Clés étrangères)

| Table | Colonne | Référence | On Delete |
|-------|---------|-----------|-----------|
| livre | id_ressource | ressource(id_ressource) | CASCADE |
| film | id_ressource | ressource(id_ressource) | CASCADE |
| evaluation | id_utilisateur | utilisateur(id_utilisateur) | CASCADE |
| evaluation | id_ressource | ressource(id_ressource) | CASCADE |
| ressource_genre | id_ressource | ressource(id_ressource) | CASCADE |
| ressource_genre | id_genre | genre(id_genre) | CASCADE |
| ressource_theme | id_ressource | ressource(id_ressource) | CASCADE |
| ressource_theme | id_theme | theme(id_theme) | CASCADE |

**Comportement CASCADE :**
- Suppression d'une ressource → suppression automatique des évaluations, associations genres/thèmes, et données livre/film
- Suppression d'un utilisateur → suppression automatique de ses évaluations
- Suppression d'un genre/thème → suppression automatique des associations

#### Contraintes UNIQUE

| Table | Colonnes | Raison |
|-------|----------|--------|
| utilisateur | email | Un email par compte |
| livre | isbn | Un ISBN unique par livre |
| evaluation | (id_utilisateur, id_ressource) | Un seul avis par utilisateur par ressource |
| genre | nom | Pas de doublons de genres |
| theme | nom | Pas de doublons de thèmes |

#### Indexes pour performance

| Table | Colonnes indexées | Raison |
|-------|------------------|--------|
| ressource | type | Filtrage fréquent livre/film |
| ressource | titre | Recherche par titre |
| ressource | auteur_realisateur | Recherche par auteur |
| ressource | date_ajout | Tri pour nouveautés |
| utilisateur | email | Recherche lors de l'authentification |
| utilisateur | role | Filtrage par rôle |
| evaluation | note | Calcul moyennes et tri |
| evaluation | id_ressource | Récupération évaluations par ressource |
| livre | isbn | Recherche par ISBN |

---

## FRONTEND

### Architecture CSS

Le projet utilise du CSS personnalisé avec variables CSS pour un theming cohérent.

#### Organisation du style

| Fichier | Contenu |
|---------|---------|
| **public/css/style.css** | CSS principal complet |

#### Caractéristiques principales

- **Variables CSS** : Couleurs, espacements, breakpoints centralisés
- **Dark mode** : Support du mode sombre avec switch utilisateur
- **Design responsive** : Mobile first avec breakpoints adaptés
- **Grid layout** : Mise en page moderne avec CSS Grid et Flexbox
- **Animations fluides** : Transitions et transformations CSS
- **Thème saisonnier** : Flocons de neige animés (Noël)

#### Variables CSS (extrait)

```css
:root {
    /* Couleurs principales */
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
    --accent-color: #e74c3c;

    /* Espacements */
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 2rem;

    /* Breakpoints */
    --mobile: 768px;
    --tablet: 1024px;
}
```

---

### JavaScript

#### Fonctionnalités actuelles

| Fonctionnalité | Emplacement | Description |
|---------------|-------------|-------------|
| **Dark mode toggle** | Inline dans header | Bascule entre mode clair/sombre |
| **Character counter** | Inline dans formulaires | Compteur de caractères pour critiques (limite 1000) |
| **LocalStorage** | Navigation | Sauvegarde des préférences utilisateur |

#### Fonctionnalités à développer (extensibilité)

- Validation formulaires côté client (avant soumission)
- Recherche dynamique avec AJAX (suggestions en temps réel)
- Upload d'images avec prévisualisation
- Système de filtres interactifs
- Infinite scroll pour pagination

---

### Images et médias

#### Structure du dossier public/img/

```
public/img/
├── livres/              # Couvertures de livres
│   ├── Dune.jpg
│   ├── 1984.jpg
│   └── ...
├── films/               # Affiches de films
│   ├── Inception.jpg
│   ├── Matrix.png
│   └── ...
└── placeholders/        # Images par défaut
    ├── livre-default.png
    └── film-default.png
```

#### Gestion des images

- **Naming convention** : Nom du titre (sans espaces spéciaux)
- **Formats supportés** : JPG, PNG, WebP
- **Fallback** : Image placeholder si image manquante
- **Optimisation** : À implémenter (compression, lazy loading)

---

## PERFORMANCE

### Optimisations actuelles

| Optimisation | Implémentation | Impact |
|--------------|---------------|--------|
| **Singleton DB** | Une seule instance PDO | Réduit overhead connexion |
| **Prepared statements** | Cache MySQL côté serveur | Accélère requêtes répétées |
| **Indexes SQL** | Sur colonnes fréquentes | Accélère recherches et tri |
| **CSS inline critique** | À implémenter | Améliorerait First Paint |

### Optimisations futures recommandées

| Optimisation | Priorité | Bénéfice estimé |
|--------------|----------|-----------------|
| **Cache Redis** | Haute | Sessions distribuées, cache requêtes |
| **CDN pour assets** | Moyenne | Réduction latence ressources statiques |
| **Lazy loading images** | Haute | Réduction temps chargement initial |
| **Pagination** | Haute | Performance listes longues |
| **Minification CSS/JS** | Moyenne | Réduction taille fichiers |
| **Compression Gzip** | Haute | Réduction bande passante |
| **Cache de vues** | Moyenne | Réduction génération HTML |

---

## EXTENSIBILITÉ

### Ajouter un nouveau type de ressource

Exemple : Ajouter un type "Bande dessinée"

**Étape 1 - Base de données :**
```sql
CREATE TABLE bande_dessinee (
    id_ressource INT PRIMARY KEY,
    illustrateur VARCHAR(255),
    serie VARCHAR(255),
    tome INT,
    FOREIGN KEY (id_ressource) REFERENCES ressource(id_ressource) ON DELETE CASCADE
);
```

**Étape 2 - Modèle :**
```php
// app/models/BandeDessinee.php
class BandeDessinee extends Model {
    protected $table = 'bande_dessinee';

    public function create($data) {
        // Logique création BD
    }

    // Autres méthodes CRUD
}
```

**Étape 3 - Contrôleur :**
```php
// app/controllers/BandeDessineeController.php
class BandeDessineeController extends Controller {
    public function index() {
        // Liste des BDs
    }

    public function create() {
        Auth::requireStaff();
        // Formulaire création
    }

    // Autres actions CRUD
}
```

**Étape 4 - Vues :**
```
app/views/bande-dessinee/
├── index.php
├── create.php
└── edit.php
```

**Étape 5 - Navigation :**
Ajouter les liens dans le menu d'administration (partials/header.php)

---

### Ajouter une fonctionnalité

Exemple : Ajouter un système de favoris

**Étape 1 - Analyse :**
- Quel contrôleur ? `FavoriController` (nouveau) ou `RessourceController` (existant)
- Quels modèles ? `Utilisateur` (ajout méthode), nouveau `Favori`
- Quelle table ? `favori` (id_utilisateur, id_ressource, date_ajout)

**Étape 2 - Base de données :**
```sql
CREATE TABLE favori (
    id_utilisateur INT NOT NULL,
    id_ressource INT NOT NULL,
    date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_utilisateur, id_ressource),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (id_ressource) REFERENCES ressource(id_ressource) ON DELETE CASCADE
);
```

**Étape 3 - Modèle :**
```php
// app/models/Favori.php
class Favori extends Model {
    public function toggle($userId, $ressourceId) {
        // Ajouter ou retirer des favoris
    }

    public function getByUser($userId) {
        // Récupérer les favoris d'un utilisateur
    }
}
```

**Étape 4 - Contrôleur :**
```php
// app/controllers/FavoriController.php
class FavoriController extends Controller {
    public function toggle() {
        Auth::requireAuth();
        // Logique toggle favori (AJAX)
    }

    public function index() {
        Auth::requireAuth();
        // Afficher mes favoris
    }
}
```

**Étape 5 - Vue :**
Ajouter bouton favori dans `ressource/show.php`

**Étape 6 - Navigation :**
Ajouter lien "Mes favoris" dans le menu utilisateur

---

## CONCLUSION

### Forces de l'architecture E-Library

| Aspect | Description |
|--------|-------------|
| **Modulaire** | Séparation claire des responsabilités (MVC) |
| **Sécurisée** | Protection contre SQL Injection, XSS, mots de passe hashés |
| **Maintenable** | Code organisé, commenté, conventions respectées |
| **Extensible** | Facile d'ajouter de nouvelles fonctionnalités |
| **Standard** | Suit les conventions PHP et les bonnes pratiques MVC |
| **Scalable** | Architecture permettant la montée en charge (avec optimisations) |

### Technologies utilisées

| Couche | Technologie | Version |
|--------|------------|---------|
| **Backend** | PHP | >= 7.4 |
| **Base de données** | MySQL | >= 5.7 |
| **Driver DB** | PDO | Natif PHP |
| **Frontend** | HTML5 + CSS3 + JS Vanilla | Standard |
| **Architecture** | MVC | Pattern |
| **Serveur** | Apache / Nginx | Compatible |

---

## DOCUMENTATION COMPLÉMENTAIRE

Pour plus de détails techniques, consulter :

- **Diagrammes UML** : `documentation/diagrammes/`
- **Schéma base de données** : `sql/schema.sql`
- **Données de test** : `sql/data.sql`
- **Guide sécurité** : `documentation/SECURITY.md`
- **README installation** : `README.md`

---

**Version** : 1.0
**Dernière mise à jour** : Janvier 2025
**Projet** : SAE R307 - Médiathèque Numérique
