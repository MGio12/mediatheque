# Spécifications Techniques E-Library

## Médiathèque Numérique - SAE R307

**Version :** 1.0
**Date :** Janvier 2025
**Établissement :** IUT Nice Côte d'Azur
**Enseignant :** M. NGUYEN Thanh Phuong

---

## Table des matières

1. [Introduction](#1-introduction)
2. [Présentation globale du système](#2-présentation-globale-du-système)
3. [Spécification fonctionnelle](#3-spécification-fonctionnelle)
4. [Spécification technique](#4-spécification-technique)
5. [Conception de la base de données](#5-conception-de-la-base-de-données)
6. [Sécurité](#6-sécurité)
7. [Conclusion](#7-conclusion)

---

## 1. Introduction

### 1.1 Présentation générale

E-Library est une application web de gestion de médiathèque numérique permettant aux utilisateurs de consulter, rechercher et évaluer des ressources culturelles (livres et films). Ce projet s'inscrit dans le cadre de la SAE R307.

Le système offre :
- La consultation d'un catalogue enrichi de livres et films
- La recherche multicritère de ressources
- L'évaluation et la notation des ressources par les utilisateurs
- La gestion administrative du catalogue par le personnel

L'application est développée en PHP selon le patron d'architecture MVC avec une base de données MySQL.

### 1.2 Objectifs du système

| Objectif | Description |
|----------|-------------|
| **Catalogage intelligent** | Organisation des ressources par catégories, thèmes et genres |
| **Recherche avancée** | Outil multicritère avec filtres (type, genre, thème, années) |
| **Interaction utilisateur** | Système d'évaluation (0-5 étoiles) et critiques textuelles |
| **Gestion multi-profils** | Rôles hiérarchisés : Utilisateur, Bibliothécaire, Administrateur |
| **Découvrabilité** | Mise en avant des nouveautés et contenus populaires |

### 1.3 Public visé

- **Utilisateurs finaux** : Personnes souhaitant découvrir et évaluer des livres et films
- **Bibliothécaires** : Personnel chargé d'enrichir et gérer le catalogue
- **Administrateurs** : Responsables des référentiels et de la modération

### 1.4 Contexte pédagogique

**Compétences évaluées :**
- Architecture MVC en PHP
- Base de données relationnelle MySQL
- Sécurité web (PDO, XSS, hachage)
- Documentation technique avec diagrammes UML

---

## 2. Présentation globale du système

### 2.1 Description fonctionnelle

Le système se décompose en deux parties :

**Front-Office (Partie publique)**
- Consultation et recherche du catalogue
- Visualisation des détails des ressources
- Évaluation des ressources (utilisateurs connectés)

**Back-Office (Administration)**
- Gestion du catalogue (CRUD livres et films)
- Administration des référentiels (genres et thèmes)
- Modération des évaluations

### 2.2 Architecture MVC

```
┌─────────────────────────────────────────────────────┐
│                NAVIGATEUR (Client)                   │
│                 HTML + CSS + JS                      │
└───────────────────────┬─────────────────────────────┘
                        │ HTTP
                        ▼
┌─────────────────────────────────────────────────────┐
│              index.php (Front Controller)            │
│                      Router                          │
└───────────────────────┬─────────────────────────────┘
                        │
        ┌───────────────┼───────────────┐
        ▼               ▼               ▼
┌─────────────┐ ┌─────────────┐ ┌─────────────┐
│ Controllers │ │   Models    │ │    Views    │
└──────┬──────┘ └──────┬──────┘ └─────────────┘
       │               │
       ▼               ▼
┌─────────────┐ ┌─────────────┐
│    Auth     │ │  Database   │
└─────────────┘ └──────┬──────┘
                       ▼
               ┌─────────────┐
               │    MySQL    │
               └─────────────┘
```

**Responsabilités :**
- **Modèle** : Accès aux données via PDO, logique métier, validation
- **Vue** : Génération HTML, affichage des données, protection XSS
- **Contrôleur** : Réception des requêtes, orchestration, gestion des redirections

### 2.3 Rôles utilisateurs

| Fonctionnalité | Utilisateur | Bibliothécaire | Administrateur |
|----------------|:-----------:|:--------------:|:--------------:|
| Consulter catalogue | ✓ | ✓ | ✓ |
| Rechercher ressources | ✓ | ✓ | ✓ |
| Évaluer ressource | ✓ | ✓ | ✓ |
| Ajouter/Modifier ressource | ✗ | ✓ | ✓ |
| Supprimer ressource | ✗ | ✓ | ✓ |
| Gérer genres/thèmes | ✗ | ✗ | ✓ |
| Supprimer évaluations | ✗ | ✗ | ✓ |

### 2.4 Front-Office et Back-Office

**Front-Office :**
- Page d'accueil avec nouveautés, top notes et derniers avis
- Catalogue complet avec badges de type
- Recherche multicritère
- Détail des ressources avec évaluations

**Back-Office :**
- Dashboard avec statistiques
- Gestion CRUD des livres et films
- Gestion des genres et thèmes (admin)
- Modération des évaluations (admin)

---

## 3. Spécification fonctionnelle

### 3.1 Fonctionnalités publiques

| Code | Fonctionnalité | Description |
|------|----------------|-------------|
| F01 | Page d'accueil | Nouveautés (8), Top notes (8), Derniers avis (5) |
| F02 | Catalogue | Liste complète avec notes moyennes et badges |
| F03 | Nouveautés | 20 dernières ressources ajoutées |
| F04 | Top Notes | Ressources triées par note moyenne |
| F05 | Sélection par thème | Filtrage par thème |
| F06 | Recherche avancée | Multicritère : mot-clé, type, genre, thème, années |
| F07 | Détail ressource | Informations complètes + métadonnées + évaluations |

### 3.2 Fonctionnalités authentifiées

| Code | Fonctionnalité | Description |
|------|----------------|-------------|
| F08 | Inscription | Création de compte avec validation |
| F09 | Connexion | Authentification sécurisée |
| F10 | Déconnexion | Fermeture de session |
| F11 | Évaluation | Note (0-5) + critique optionnelle (max 1000 car.) |

### 3.3 Fonctionnalités d'administration

| Code | Fonctionnalité | Accès |
|------|----------------|-------|
| F12 | Dashboard | Bibliothécaire, Admin |
| F13 | Gestion livres (CRUD) | Bibliothécaire, Admin |
| F14 | Gestion films (CRUD) | Bibliothécaire, Admin |
| F15 | Gestion genres | Admin |
| F16 | Gestion thèmes | Admin |
| F17 | Suppression évaluations | Admin |

### 3.4 Règles de gestion

**Utilisateurs :**
- Email unique par compte
- Mot de passe minimum 8 caractères
- Un seul rôle par utilisateur

**Ressources :**
- Une ressource est soit un livre soit un film
- Titre et auteur/réalisateur obligatoires
- Année entre 1800 et 2100
- ISBN unique (13 chiffres) pour les livres

**Évaluations :**
- Une seule évaluation par utilisateur par ressource
- Note entre 0.0 et 5.0
- Critique optionnelle (max 1000 caractères)

---

## 4. Spécification technique

### 4.1 Framework PHP

Le projet utilise un framework MVC maison composé de 5 classes de base :

| Classe | Rôle |
|--------|------|
| `Router` | Analyse l'URL et dispatche vers le contrôleur approprié |
| `Controller` | Classe de base avec méthodes de rendu des vues |
| `Model` | Classe abstraite pour l'accès aux données |
| `Database` | Singleton gérant la connexion PDO |
| `Auth` | Gestion de l'authentification et des autorisations |

**Système de routage :**

| URL | Méthode appelée |
|-----|-----------------|
| `index.php` | `HomeController::index()` |
| `?controller=auth&action=login` | `AuthController::login()` |
| `?controller=ressource&action=show&id=5` | `RessourceController::show()` |
| `?controller=livre&action=create` | `LivreController::create()` |

### 4.2 Diagrammes UML

Les diagrammes sont disponibles dans `documentation/diagrammes/` au format PlantUML.

#### 4.2.1 Diagramme de composants

**Fichier :** `06-component-diagram.puml`

Présente l'architecture technique globale selon le pattern MVC :
- **Frontend** : Navigateur web (HTML/CSS/JS)
- **Backend** : Router, Controllers, Models, Views, Auth, Database
- **Base de données** : MySQL

Les flux de données suivent le chemin : Browser → Router → Controllers → Models → Database

#### 4.2.2 Diagrammes de cas d'utilisation

**Fichiers :** `01a-use-case-front.puml`, `01b-use-case-back.puml`

**Front Office - Acteurs :**
- Visiteur : Consulte, recherche, s'inscrit
- Utilisateur (hérite de Visiteur) : Évalue les ressources

**Back Office - Acteurs :**
- Bibliothécaire : Gère les livres et films
- Administrateur (hérite de Bibliothécaire) : Gère les référentiels et modère

#### 4.2.3 Diagrammes de séquence

**Authentification** (`03-sequence-authentification.puml`)
- Inscription : Validation → Vérification email unique → Création compte avec hachage
- Connexion : Recherche utilisateur → Vérification mot de passe → Création session
- Déconnexion : Destruction de session → Redirection

**Évaluation** (`04-sequence-evaluation.puml`)
- Vérification authentification
- Contrôle d'unicité (une évaluation par utilisateur par ressource)
- Enregistrement avec gestion de la contrainte UNIQUE

**Création livre** (`05-sequence-crud-livre.puml`)
- Vérification autorisation staff
- Validation des données
- Opération atomique garantissant l'intégrité des données

#### 4.2.4 Diagramme de packages

**Fichier :** `07-package-diagram.puml`

```
mediatheque/
├── config/          # Configuration BDD
├── core/            # Framework (5 classes)
├── app/
│   ├── controllers/ # 10 contrôleurs
│   ├── models/      # 7 modèles
│   └── views/       # Layout + 30+ templates
├── public/          # CSS, JS, images
├── sql/             # Scripts SQL
└── documentation/   # Diagrammes UML
```

#### 4.2.5 Diagrammes de classes

**Fichiers :** `02a-class-core.puml`, `02b-class-models.puml`, `02c-class-controllers.puml`

**Classes du Core :**

| Classe | Type | Responsabilité |
|--------|------|----------------|
| `Controller` | Abstract | Base des contrôleurs, rendu des vues |
| `Model` | Abstract | Base des modèles, accès PDO |
| `Router` | Concrete | Dispatch des requêtes |
| `Auth` | Static | Authentification et autorisations |
| `Database` | Singleton | Connexion PDO unique |

**Classes Modèles :**

| Classe | Table | Responsabilité |
|--------|-------|----------------|
| `Utilisateur` | utilisateur | Gestion des comptes |
| `Ressource` | ressource | Gestion des ressources avec recherche |
| `Livre` | livre | CRUD livres avec transactions |
| `Film` | film | CRUD films avec transactions |
| `Genre` | genre | Gestion des genres |
| `Theme` | theme | Gestion des thèmes |
| `Evaluation` | evaluation | Notes et critiques |

**Classes Contrôleurs :**

| Classe | Responsabilité |
|--------|----------------|
| `HomeController` | Page d'accueil |
| `AuthController` | Inscription, connexion, déconnexion |
| `CatalogueController` | Catalogue et recherche |
| `RessourceController` | Détail des ressources |
| `EvaluationController` | Création des évaluations |
| `LivreController` | CRUD livres (staff) |
| `FilmController` | CRUD films (staff) |
| `GenreController` | CRUD genres (admin) |
| `ThemeController` | CRUD thèmes (admin) |
| `AdminController` | Dashboard et modération |

### 4.3 Composants principaux

#### Contrôleurs

| Contrôleur | Rôle | Dépendances modèles |
|------------|------|---------------------|
| `HomeController` | Page d'accueil | Ressource, Theme, Evaluation |
| `AuthController` | Authentification | Utilisateur |
| `CatalogueController` | Catalogue et recherche | Ressource, Genre, Theme |
| `RessourceController` | Détail ressource | Ressource, Evaluation |
| `EvaluationController` | Gestion évaluations | Evaluation |
| `LivreController` | CRUD livres | Livre, Genre, Theme |
| `FilmController` | CRUD films | Film, Genre, Theme |

#### Modèles

| Modèle | Méthodes clés |
|--------|---------------|
| `Utilisateur` | `findByEmail()`, `createUser()`, `verifyCredentials()` |
| `Ressource` | `getAll()`, `findById()`, `getNewest()`, `getTopRated()`, `search()` |
| `Livre` | `create()`, `update()`, `delete()`, `isbnExists()` |
| `Evaluation` | `hasUserEvaluated()`, `createEvaluation()`, `getAverage()`, `getLatest()` |

### 4.4 Méthodes principales

#### Méthodes des contrôleurs

| Méthode | Objectif | Accès |
|---------|----------|-------|
| `HomeController::index()` | Afficher l'accueil avec nouveautés et tops | Public |
| `AuthController::loginPost()` | Traiter la connexion | Public |
| `LivreController::createPost()` | Créer un nouveau livre | Staff |
| `EvaluationController::createPost()` | Enregistrer une évaluation | Connecté |

#### Méthodes des modèles

| Méthode | Objectif |
|---------|----------|
| `Ressource::search($criteria)` | Recherche multicritère dynamique |
| `Livre::create($data)` | Création atomique avec gestion des associations |
| `Evaluation::createEvaluation()` | Création avec gestion de l'unicité |

#### Interactions entre composants

**Affichage page d'accueil :**
1. Router dispatche vers `HomeController::index()`
2. Le contrôleur interroge les modèles (Ressource, Theme, Evaluation)
3. Les modèles exécutent les requêtes via Database
4. Le contrôleur rend la vue avec les données

**Création d'un livre :**
1. `Auth::requireStaff()` vérifie l'autorisation
2. Le contrôleur valide les données du formulaire
3. `Livre::create()` effectue l'opération de manière atomique
4. Redirection avec message de succès

---

## 5. Conception de la base de données

### 5.1 Modèle Conceptuel de Données (MCD)

**Fichier :** `documentation/diagrammes/08-mcd.puml`

#### Entités

| Entité | Description | Attributs clés |
|--------|-------------|----------------|
| UTILISATEUR | Comptes utilisateurs | id, nom, prénom, email, mot_de_passe, rôle |
| RESSOURCE | Ressource culturelle (parent) | id, type, titre, auteur_réalisateur, année |
| LIVRE | Spécialisation livre | isbn, éditeur, nombre_pages, prix, langue |
| FILM | Spécialisation film | durée, support, langue, sous_titres, casting |
| GENRE | Catégorie stylistique | id, nom |
| THEME | Thème abordé | id, nom |
| EVALUATION | Note et critique | id, note, critique, date |

#### Associations

| Association | Cardinalités | Description |
|-------------|--------------|-------------|
| UTILISATEUR — EVALUATION | 1,n | Un utilisateur peut créer plusieurs évaluations |
| RESSOURCE — EVALUATION | 1,n | Une ressource peut recevoir plusieurs évaluations |
| RESSOURCE — LIVRE | 1,0..1 | Héritage exclusif |
| RESSOURCE — FILM | 1,0..1 | Héritage exclusif |
| RESSOURCE — GENRE | n,m | Association multiple |
| RESSOURCE — THEME | n,m | Association multiple |

### 5.2 Modèle Logique de Données (MLD)

**Fichier :** `documentation/diagrammes/09-mld.puml`

#### Tables

**utilisateur**
| Colonne | Type | Contraintes |
|---------|------|-------------|
| id_utilisateur | INT | PK, AUTO_INCREMENT |
| nom | VARCHAR(100) | NOT NULL |
| prenom | VARCHAR(100) | NOT NULL |
| email | VARCHAR(255) | NOT NULL, UNIQUE |
| mot_de_passe | VARCHAR(255) | NOT NULL |
| role | ENUM | NOT NULL, DEFAULT 'utilisateur' |
| date_inscription | DATETIME | DEFAULT CURRENT_TIMESTAMP |

**ressource**
| Colonne | Type | Contraintes |
|---------|------|-------------|
| id_ressource | INT | PK, AUTO_INCREMENT |
| type | ENUM('livre','film') | NOT NULL |
| titre | VARCHAR(255) | NOT NULL |
| auteur_realisateur | VARCHAR(255) | NOT NULL |
| annee | SMALLINT | NOT NULL |
| resume | TEXT | |
| image_url | VARCHAR(255) | |
| pays | VARCHAR(100) | |
| date_ajout | DATETIME | DEFAULT CURRENT_TIMESTAMP |

**livre**
| Colonne | Type | Contraintes |
|---------|------|-------------|
| id_ressource | INT | PK, FK → ressource ON DELETE CASCADE |
| isbn | VARCHAR(13) | NOT NULL, UNIQUE |
| editeur | VARCHAR(255) | NOT NULL |
| nombre_pages | INT | NOT NULL |
| prix | DECIMAL(10,2) | |
| langue | VARCHAR(50) | DEFAULT 'Français' |

**film**
| Colonne | Type | Contraintes |
|---------|------|-------------|
| id_ressource | INT | PK, FK → ressource ON DELETE CASCADE |
| duree | INT | NOT NULL |
| support | ENUM | NOT NULL |
| langue | VARCHAR(50) | NOT NULL |
| sous_titres | VARCHAR(255) | |
| propose_par | ENUM | |
| casting | TEXT | |

**genre** / **theme**
| Colonne | Type | Contraintes |
|---------|------|-------------|
| id_genre / id_theme | INT | PK, AUTO_INCREMENT |
| nom | VARCHAR(100) | NOT NULL, UNIQUE |

**ressource_genre** / **ressource_theme** (Tables de liaison)
| Colonne | Type | Contraintes |
|---------|------|-------------|
| id_ressource | INT | PK, FK → ressource ON DELETE CASCADE |
| id_genre / id_theme | INT | PK, FK → genre/theme ON DELETE CASCADE |

**evaluation**
| Colonne | Type | Contraintes |
|---------|------|-------------|
| id_evaluation | INT | PK, AUTO_INCREMENT |
| id_utilisateur | INT | NOT NULL, FK → utilisateur ON DELETE CASCADE |
| id_ressource | INT | NOT NULL, FK → ressource ON DELETE CASCADE |
| note | DECIMAL(2,1) | NOT NULL |
| critique | TEXT | |
| date_evaluation | DATETIME | DEFAULT CURRENT_TIMESTAMP |

Contrainte : UNIQUE (id_utilisateur, id_ressource)

### 5.3 Script SQL

**Fichier :** `sql/schema.sql`

**Choix techniques :**

| Choix | Justification |
|-------|---------------|
| Pattern Table Inheritance | Partage des attributs communs Ressource/Livre/Film |
| ENUM pour valeurs prédéfinies | Validation au niveau BDD, économie de stockage |
| CASCADE sur toutes les FK | Suppression automatique des données orphelines |
| INDEX sur colonnes requêtées | Optimisation des recherches et authentification |
| Contrainte UNIQUE sur évaluation | Garantit une évaluation par utilisateur par ressource |

**Configuration :**
- ENGINE : InnoDB (transactions, clés étrangères)
- CHARSET : utf8mb4 (support caractères spéciaux)

---

## 6. Sécurité

### 6.1 Contrôle d'accès (RBAC)

Le système implémente un contrôle d'accès basé sur les rôles via la classe `Auth` :

```php
// Accès utilisateurs connectés
Auth::requireAuth();

// Accès staff (bibliothécaire ou admin)
Auth::requireStaff();

// Accès admin uniquement
Auth::requireRole('administrateur');
```

### 6.2 Protection SQL Injection

**Méthode :** 100% des requêtes utilisent des requêtes préparées PDO.

```php
// Requête sécurisée avec paramètres liés
$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
$stmt->execute(['email' => $email]);
```

Configuration PDO : `PDO::ATTR_EMULATE_PREPARES => false`

### 6.3 Protection XSS

**Méthode :** Échappement systématique des sorties avec `htmlspecialchars()`.

```php
<?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?>
```

### 6.4 Gestion des mots de passe

- Hachage avec `password_hash()` (bcrypt)
- Vérification avec `password_verify()`
- Messages d'erreur génériques (pas de fuite d'information)

### 6.5 Résumé des protections

| Menace | Protection | Implémentation |
|--------|------------|----------------|
| SQL Injection | Requêtes préparées PDO | 100% des requêtes |
| XSS | `htmlspecialchars()` | Toutes les vues |
| Mots de passe | bcrypt | Inscription |
| Accès non autorisé | Contrôle de rôle | `Auth::require*()` |

---

## 7. Conclusion

### 7.1 Bilan

Le projet E-Library constitue une application web complète respectant les standards de la SAE R307 :

**Architecture :**
- Pattern MVC strictement respecté
- Framework PHP modulaire
- Code organisé et documenté

**Base de données :**
- 9 tables relationnelles normalisées
- Contraintes d'intégrité (FK, CASCADE)
- Pattern Table Inheritance

**Sécurité :**
- Requêtes préparées (SQL Injection)
- Échappement XSS
- Hachage bcrypt
- Contrôle d'accès RBAC

### 7.2 Conformité SAE R307

| Critère | Statut |
|---------|--------|
| Architecture MVC | ✓ |
| PHP orienté objet | ✓ |
| MySQL avec PDO | ✓ |
| Requêtes préparées | ✓ |
| Mots de passe hachés | ✓ |
| Protection XSS | ✓ |
| Diagramme de composants | ✓ |
| Diagrammes de cas d'utilisation | ✓ |
| Diagrammes de séquence | ✓ |
| Diagramme de packages | ✓ |
| Diagramme de classes | ✓ |
| MCD | ✓ |
| MLD | ✓ |
| Script SQL | ✓ |

### 7.3 Évolutions possibles

**Fonctionnelles :**
- Système de favoris
- Recommandations basées sur les évaluations
- Gestion des emprunts
- Nouveaux types de ressources

**Techniques :**
- Mise en cache
- API REST
- Tests automatisés

---

*Document de Spécifications Techniques E-Library*
*SAE R307 - Médiathèque Numérique*
*IUT Nice Côte d'Azur*
