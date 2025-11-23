# E-LIBRARY - MÉDIATHÈQUE NUMÉRIQUE

## PRÉSENTATION

E-Library est une application web de gestion de médiathèque permettant la consultation, la recherche et l'évaluation de ressources numériques (livres et films). Développée dans le cadre du projet SAE R307, cette application offre une interface complète pour les visiteurs, utilisateurs et le personnel administratif.

---

## FONCTIONNALITÉS

### Front Office (Espace Public)

#### Consultation publique

| Fonctionnalité | Description |
|---------------|-------------|
| **Catalogue complet** | Affichage de toutes les ressources disponibles avec notes et évaluations |
| **Nouveautés** | Dernières ressources ajoutées triées par date |
| **Top** | Ressources les mieux notées par la communauté |
| **Sélections thématiques** | Filtrage des ressources par thème (Science-Fiction, Histoire, etc.) |
| **Recherche avancée** | Recherche multicritère (titre, auteur, genre, thème, plage d'années) |
| **Détails ressource** | Page complète avec résumé, évaluations, casting, informations techniques |

#### Espace utilisateur connecté

| Fonctionnalité | Description |
|---------------|-------------|
| **Inscription** | Création de compte avec validation |
| **Authentification** | Connexion sécurisée avec mots de passe hashés (bcrypt) |
| **Évaluation** | Notation de 1 à 5 étoiles des ressources consultées |
| **Critiques** | Rédaction de commentaires (max 1000 caractères) |
| **Profil** | Gestion du compte personnel |

### Back Office (Administration)

#### Bibliothécaire

| Permission | Description |
|-----------|-------------|
| **Gestion livres** | Création, modification, suppression de livres |
| **Gestion films** | Création, modification, suppression de films |
| **Association** | Liaison des ressources aux genres et thèmes existants |

#### Administrateur

| Permission | Description |
|-----------|-------------|
| **Toutes permissions bibliothécaire** | Gestion complète des ressources |
| **Gestion genres** | CRUD complet sur les genres |
| **Gestion thèmes** | CRUD complet sur les thèmes |
| **Gestion utilisateurs** | Administration des comptes et rôles |

---

## ARCHITECTURE TECHNIQUE

### Stack technologique

| Couche | Technologie | Version minimale |
|--------|-------------|------------------|
| **Backend** | PHP (Programmation Orientée Objet) | 7.4+ |
| **Base de données** | MySQL | 5.7+ |
| **Frontend** | HTML5, CSS3, JavaScript Vanilla | Standard |
| **Pattern architectural** | MVC (Model-View-Controller) | - |
| **Accès données** | PDO avec requêtes préparées | Natif PHP |
| **Serveur web** | Apache ou Nginx | Compatible |

### Structure du projet

```
mediatheque/
├── app/
│   ├── controllers/     # Contrôleurs MVC
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   ├── CatalogueController.php
│   │   ├── EvaluationController.php
│   │   ├── FilmController.php
│   │   ├── GenreController.php
│   │   ├── HomeController.php
│   │   ├── LivreController.php
│   │   ├── RessourceController.php
│   │   └── ThemeController.php
│   ├── models/          # Modèles métier
│   │   ├── Evaluation.php
│   │   ├── Film.php
│   │   ├── Genre.php
│   │   ├── Livre.php
│   │   ├── Ressource.php
│   │   ├── Theme.php
│   │   └── Utilisateur.php
│   └── views/           # Vues et templates
│       ├── layout.php
│       ├── partials/
│       ├── home/
│       ├── auth/
│       ├── catalogue/
│       ├── ressource/
│       └── admin/
├── config/              # Configuration
│   └── config.php
├── core/                # Framework MVC
│   ├── Auth.php
│   ├── Controller.php
│   ├── Database.php
│   ├── Model.php
│   └── Router.php
├── documentation/       # Documentation et diagrammes UML
│   ├── ARCHITECTURE.md
│   ├── Cahier_des_charges.md
│   ├── SECURITY.md
│   └── diagrammes/
├── public/              # Assets publics
│   ├── css/
│   │   └── style.css
│   ├── js/
│   └── img/
│       ├── films/
│       └── livres/
├── sql/                 # Scripts SQL
│   ├── schema.sql
│   └── data.sql
└── index.php            # Point d'entrée unique
```

---

## INSTALLATION

### Prérequis

| Logiciel | Version minimale | Notes |
|----------|-----------------|-------|
| **PHP** | 7.4+ | Extensions : PDO, PDO_MySQL |
| **MySQL** | 5.7+ | Ou MariaDB 10.5+ |
| **Serveur web** | Apache 2.4+ ou Nginx 1.18+ | Ou PHP built-in server pour dev |

### Procédure d'installation

#### Étape 1 : Cloner le dépôt

```bash
git clone https://github.com/MGio12/mediatheque.git
cd mediatheque
```

#### Étape 2 : Créer la base de données

```bash
mysql -u root -p
```

Dans l'invite MySQL :
```sql
CREATE DATABASE mediatheque CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

#### Étape 3 : Importer le schéma

```bash
mysql -u root -p mediatheque < sql/schema.sql
```

Cette commande crée toutes les tables nécessaires :
- utilisateur
- ressource (table parente)
- livre et film (tables enfants)
- genre et theme
- evaluation
- Tables associatives (ressource_genre, ressource_theme)

#### Étape 4 : Importer les données de test (optionnel mais recommandé)

```bash
mysql -u root -p mediatheque < sql/data.sql
```

Ce fichier contient :
- 3 utilisateurs de test (admin, bibliothécaire, utilisateur)
- 5 livres (Dune, 1984, Le Petit Prince, Les Misérables, Sapiens)
- 5 films (Inception, Le Parrain, Interstellar, Le Roi Lion, Matrix)
- Genres et thèmes associés

#### Étape 5 : Configurer la connexion à la base de données

Modifier le fichier `config/config.php` avec vos informations :

```php
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');          // 3306 (standard) ou 8889 (MAMP)
define('DB_NAME', 'mediatheque');   // Nom de votre base de données
define('DB_USER', 'root');          // Votre utilisateur MySQL
define('DB_PASSWORD', '');          // Votre mot de passe MySQL
```

**Configuration selon votre environnement :**

| Environnement | Host | Port | User | Password |
|--------------|------|------|------|----------|
| **XAMPP** | localhost | 3306 | root | (vide) |
| **MAMP** | localhost | 8889 | root | root |
| **Serveur IUT** | localhost | 3306 | votre_user | votre_password |
| **Production** | localhost | 3306 | votre_user_prod | votre_password_prod |

#### Étape 6 : Démarrer le serveur

**Option A : Serveur PHP intégré (développement)**
```bash
php -S localhost:8000
```

**Option B : Apache/Nginx**

Configurer le DocumentRoot vers le dossier du projet :
```apache
<VirtualHost *:80>
    ServerName mediatheque.local
    DocumentRoot "/path/to/mediatheque"
    <Directory "/path/to/mediatheque">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Option C : MAMP/XAMPP**

Placer le projet dans le dossier `htdocs` et accéder via `http://localhost/mediatheque`

#### Étape 7 : Accéder à l'application

Ouvrir dans le navigateur :
- Serveur PHP : `http://localhost:8000`
- Apache/Nginx : `http://mediatheque.local` ou `http://localhost/mediatheque`

---

## COMPTES DE TEST

Après importation du fichier `sql/data.sql`, les comptes suivants sont disponibles :

| Rôle | Email | Mot de passe | Permissions |
|------|-------|--------------|-------------|
| **Administrateur** | admin@mediatheque.com | password123 | Accès complet (ressources, genres, thèmes, utilisateurs) |
| **Bibliothécaire** | biblio@mediatheque.com | password123 | Gestion des ressources (livres, films) |
| **Utilisateur** | user@mediatheque.com | password123 | Consultation et évaluation |

**Note de sécurité :** Les mots de passe sont stockés hashés avec bcrypt dans la base de données. Le mot de passe en clair `password123` est uniquement utilisé pour la connexion.

---

## DOCUMENTATION COMPLÈTE

### Fichiers de documentation

La documentation technique complète se trouve dans le dossier `documentation/` :

| Document | Contenu |
|----------|---------|
| **ARCHITECTURE.md** | Architecture détaillée du système (MVC, flux de données, sécurité) |
| **Cahier_des_charges.md** | Spécifications fonctionnelles et techniques du projet |
| **SECURITY.md** | Mesures de sécurité implémentées et recommandations |

### Diagrammes UML

Tous les diagrammes sont au format PlantUML dans `documentation/diagrammes/` :

#### Diagrammes de cas d'utilisation

| Fichier | Description |
|---------|-------------|
| `01a-use-case-front.puml` | Cas d'utilisation Front Office (visiteur, utilisateur) |
| `01b-use-case-back.puml` | Cas d'utilisation Back Office (bibliothécaire, admin) |

#### Diagrammes de classes

| Fichier | Description |
|---------|-------------|
| `02a-class-core.puml` | Framework core (Controller, Model, Router, Auth, Database) |
| `02b-class-models.puml` | Modèles métier (Utilisateur, Ressource, Livre, Film, etc.) |
| `02c-class-controllers.puml` | Contrôleurs de l'application |

#### Diagrammes de séquence

| Fichier | Description |
|---------|-------------|
| `03-sequence-authentification.puml` | Processus complet d'authentification |
| `04-sequence-evaluation.puml` | Création d'une évaluation |
| `05-sequence-crud-livre.puml` | Création d'un livre (workflow complet) |

#### Diagrammes structurels

| Fichier | Description |
|---------|-------------|
| `06-component-diagram.puml` | Architecture en composants |
| `07-package-diagram.puml` | Organisation du code en packages |
| `08-mcd.puml` | Modèle Conceptuel de Données |
| `09-mld.puml` | Modèle Logique de Données |

### Visualisation des diagrammes

#### VS Code (recommandé)

1. Installer l'extension **PlantUML**
2. Ouvrir un fichier `.puml`
3. Utiliser `Alt+D` pour prévisualiser

#### En ligne

1. Accéder à https://www.plantuml.com/plantuml/uml/
2. Copier-coller le contenu du fichier `.puml`

#### Génération d'images PNG/SVG

```bash
cd documentation/diagrammes
plantuml *.puml
# Génère les fichiers PNG dans le même dossier
```

---

## SÉCURITÉ

### Mesures implémentées

| Protection | Implémentation | Fichier concerné |
|-----------|---------------|------------------|
| **SQL Injection** | 100% des requêtes utilisent PDO avec prepared statements | Tous les modèles (app/models/) |
| **XSS** | Échappement systématique avec `htmlspecialchars()` | Toutes les vues (app/views/) |
| **Mots de passe** | Hashage bcrypt via `password_hash()` | Utilisateur.php |
| **Sessions** | Gestion sécurisée de l'authentification | core/Auth.php |
| **Contrôle d'accès** | Vérification des rôles avant actions sensibles | Controllers avec Auth::require* |
| **Validation** | Validation des entrées côté serveur | Tous les modèles |

### Exemple de protection SQL Injection

**Code sécurisé (utilisé partout) :**
```php
$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
$stmt->execute(['email' => $email]);
```

**Code vulnérable (JAMAIS utilisé) :**
```php
$query = "SELECT * FROM utilisateur WHERE email = '$email'"; // DANGER
```

### Recommandations pour la production

| Recommandation | Priorité | Implémentation suggérée |
|---------------|----------|------------------------|
| Tokens CSRF | Haute | Ajouter tokens dans tous les formulaires POST |
| Rate limiting | Haute | Limiter tentatives de connexion (5/min) |
| HTTPS obligatoire | Critique | Forcer redirection HTTP → HTTPS |
| Variables d'environnement | Haute | Utiliser .env pour credentials |
| En-têtes de sécurité | Moyenne | X-Frame-Options, CSP, etc. |
| Logs de sécurité | Moyenne | Logger tentatives de connexion échouées |
| Backup automatique | Haute | Sauvegardes quotidiennes de la BDD |

---

## BASE DE DONNÉES

### Schéma relationnel

#### Tables principales

| Table | Clé primaire | Description |
|-------|-------------|-------------|
| **utilisateur** | id_utilisateur | Comptes utilisateurs (visiteur, bibliothécaire, admin) |
| **ressource** | id_ressource | Table parente pour toutes les ressources |
| **livre** | id_ressource (FK) | Informations spécifiques aux livres (ISBN, éditeur, pages, prix) |
| **film** | id_ressource (FK) | Informations spécifiques aux films (durée, support, langue, sous-titres) |
| **genre** | id_genre | Genres des ressources (Action, Roman, Comédie, etc.) |
| **theme** | id_theme | Thèmes des ressources (Science-Fiction, Histoire, etc.) |
| **evaluation** | id_evaluation | Notes (1-5) et critiques des utilisateurs |

#### Tables associatives (Many-to-Many)

| Table | Clés | Relation |
|-------|------|----------|
| **ressource_genre** | (id_ressource, id_genre) | Une ressource peut avoir plusieurs genres |
| **ressource_theme** | (id_ressource, id_theme) | Une ressource peut avoir plusieurs thèmes |

#### Pattern Table Inheritance

```
ressource (parente)
    ├── livre (enfant avec spécialisation)
    └── film (enfant avec spécialisation)
```

**Avantages :**
- Évite la duplication des champs communs (titre, auteur, année, résumé, etc.)
- Permet les requêtes unifiées sur toutes les ressources
- Facilite l'ajout de nouveaux types de ressources

### Contraintes d'intégrité

| Contrainte | Description |
|-----------|-------------|
| **Foreign Keys** | Toutes avec `ON DELETE CASCADE` pour cohérence référentielle |
| **UNIQUE** | email (utilisateur), isbn (livre), (utilisateur, ressource) pour évaluation |
| **NOT NULL** | Champs obligatoires validés en base |
| **ENUM** | Types contraints (type ressource, rôle utilisateur, support film) |

Voir `sql/schema.sql` pour la structure SQL complète.

---

## DÉVELOPPEMENT

### Conventions de code

| Aspect | Convention | Exemple |
|--------|-----------|---------|
| **Classes** | PascalCase | `RessourceController`, `Utilisateur` |
| **Méthodes** | camelCase | `getTopRated()`, `findById()` |
| **Variables** | camelCase | `$ressourceModel`, `$userId` |
| **Colonnes SQL** | snake_case | `id_utilisateur`, `date_ajout` |
| **Constantes** | SCREAMING_SNAKE_CASE | `DB_HOST`, `PASSWORD_DEFAULT` |
| **Fichiers** | PascalCase.php | `CatalogueController.php` |

### Architecture MVC

#### Controllers (app/controllers/)

**Responsabilités :**
- Recevoir les requêtes HTTP (GET, POST)
- Vérifier les autorisations (Auth)
- Appeler les modèles pour récupérer/modifier les données
- Passer les données aux vues
- Gérer les redirections

**Méthodes héritées de `core/Controller.php` :**
```php
$this->render($view, $data);           // Afficher une vue
$this->redirect($url);                 // Rediriger
$this->setFlash($type, $message);      // Message flash
```

#### Models (app/models/)

**Responsabilités :**
- Interagir avec la base de données via PDO
- Valider les données entrantes
- Appliquer la logique métier
- Construire les requêtes SQL préparées

**Propriétés héritées de `core/Model.php` :**
```php
$this->pdo;    // Instance PDO pour requêtes
$this->table;  // Nom de la table (défini dans enfant)
```

#### Views (app/views/)

**Responsabilités :**
- Générer le HTML à partir des données
- Échapper TOUTES les variables avec `htmlspecialchars()`
- Utiliser le layout principal (`layout.php`)
- Fournir une interface utilisateur claire

**Template standard :**
```php
<?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?>
```

### Ajouter une fonctionnalité

#### Exemple : Ajouter un système de favoris

**1. Base de données :**
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

**2. Modèle (app/models/Favori.php) :**
```php
class Favori extends Model {
    protected $table = 'favori';

    public function toggle($userId, $ressourceId) {
        // Logique pour ajouter/retirer
    }

    public function getByUser($userId) {
        // Récupérer les favoris d'un utilisateur
    }
}
```

**3. Contrôleur (app/controllers/FavoriController.php) :**
```php
class FavoriController extends Controller {
    public function toggle() {
        Auth::requireAuth();
        // Traitement AJAX
    }
}
```

**4. Vue :** Ajouter bouton dans `ressource/show.php`

**5. Route :** Accessible automatiquement via `index.php?controller=favori&action=toggle`

---

## RÉFÉRENCE DU PROJET

### Contexte académique

| Information | Valeur |
|------------|--------|
| **Cadre** | SAE R307 - Développement d'applications Web |
| **Année universitaire** | 2025/2026 |
| **Institution** | IUT Nice Côte d'Azur |
| **Département** | Informatique |

### Inspiration

Site de référence : https://vod.mediatheque-numerique.com

Le projet s'inspire de ce site pour :
- L'organisation du catalogue
- La présentation des ressources
- Le système de notation et critiques
- L'interface utilisateur moderne

### Technologies imposées

Dans le cadre pédagogique, les technologies suivantes étaient obligatoires :
- Backend : PHP (programmation orientée objet)
- Base de données : MySQL avec PDO
- Frontend : HTML5, CSS3, JavaScript (pas de framework)
- Architecture : Pattern MVC strict
- Sécurité : Protection SQL Injection et XSS obligatoire

---

## NOTES IMPORTANTES

### Améliorations futures possibles

- Système de réservation/emprunt de ressources physiques
- Notifications par email (nouveautés, rappels)
- Système de recommandations basé sur les évaluations
- API REST pour applications mobiles
- Import/export de données (CSV, JSON)
- Statistiques avancées pour administrateurs
- Gestion des images (upload, resize automatique)
- Système de favoris utilisateur
- Historique de consultation
- Mode hors ligne (PWA)

---

## LICENCE

Ce projet est développé dans un cadre pédagogique à l'IUT Nice Côte d'Azur.

**Année 2025/2026 - SAE R307**
