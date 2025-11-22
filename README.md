# E-Library - Médiathèque Numérique

## Présentation

E-Library est une application web de gestion de médiathèque permettant la gestion et la consultation de ressources numériques (livres, films). Développé dans le cadre du projet SAE R307, ce système offre une interface complète pour les visiteurs, utilisateurs et le personnel administratif.

## Fonctionnalités

### Front Office

**Consultation publique**
- Catalogue complet des ressources disponibles
- Recherche multicritère (titre, auteur, genre, thème, année)
- Affichage des nouveautés
- Classement des ressources les mieux notées
- Sélections thématiques
- Consultation détaillée des ressources

**Espace utilisateur**
- Inscription et authentification sécurisée
- Évaluation des ressources (notation 0-5 étoiles)
- Rédaction de critiques
- Gestion du profil personnel

### Back Office

**Administration (Bibliothécaires et Administrateurs)**
- Gestion complète des livres (création, modification, suppression)
- Gestion complète des films (création, modification, suppression)
- Gestion des genres et thèmes
- Consultation des statistiques

## Architecture technique

### Technologies

- **Backend** : PHP 8.0+ (Programmation Orientée Objet)
- **Base de données** : MySQL 8.0+
- **Frontend** : HTML5, CSS3, JavaScript
- **Pattern** : MVC (Model-View-Controller)
- **Accès données** : PDO avec requêtes préparées

### Structure du projet

```
mediatheque/
├── app/
│   ├── controllers/     Contrôleurs MVC
│   ├── models/          Modèles métier
│   └── views/           Vues et templates
├── config/              Configuration
├── core/                Framework MVC
├── documentation/       Documentation et diagrammes UML
├── public/              Assets (CSS, JS, images)
├── sql/                 Scripts SQL
└── index.php            Point d'entrée
```

## Installation

### Prérequis

- PHP >= 8.0
- MySQL >= 8.0 ou MariaDB >= 10.5
- Serveur web (Apache, Nginx) ou PHP built-in server

### Procédure d'installation

1. Cloner le dépôt
```bash
git clone https://github.com/votre-equipe/mediatheque.git
cd mediatheque
```

2. Créer la base de données
```bash
mysql -u root -p
```
```sql
CREATE DATABASE gm401942_elibrary2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

3. Importer le schéma
```bash
mysql -u root -p gm401942_elibrary2 < sql/schema.sql
```

4. Importer les données de test (optionnel)
```bash
mysql -u root -p gm401942_elibrary2 < sql/data.sql
```

Ou utiliser le script de seeding :
```bash
php seed.php
```

5. Configurer les paramètres de connexion

Le fichier `config/config.php` détecte automatiquement l'environnement :

**Développement local (MAMP)** :
- Host : `localhost`
- Port : `8889`
- Base : `gm401942_elibrary2`
- User : `gm401942`
- Password : `gm401942`

**Production (serveur IUT)** :
- Host : `localhost`
- Port : `3306`
- Base : `gm401942_elibrary2`
- User : `gm401942`
- Password : à configurer dans `config/config.php`

6. Démarrer le serveur

Pour le développement :
```bash
php -S localhost:8000
```

Pour Apache/Nginx, configurer le DocumentRoot vers le dossier du projet.

7. Accéder à l'application

Ouvrir : `http://localhost:8000`

## Comptes de test

Après importation du fichier `sql/data.sql` :

| Rôle            | Email                    | Mot de passe |
|-----------------|--------------------------|--------------|
| Administrateur  | admin@mediatheque.com    | password     |
| Bibliothécaire  | biblio@mediatheque.com   | password     |
| Utilisateur     | user@mediatheque.com     | password     |

Note : Les mots de passe sont hachés avec bcrypt dans la base de données.

## Documentation

La documentation complète se trouve dans le dossier `documentation/` :

- **ARCHITECTURE.md** : Architecture détaillée du système
- **INSTALLATION.md** : Guide d'installation complet
- **diagrammes/** : Diagrammes UML au format PlantUML

### Diagrammes UML

Les diagrammes suivants sont disponibles au format PlantUML :

**Cas d'utilisation**
- `01a-use-case-front.puml` : Front Office
- `01b-use-case-back.puml` : Back Office

**Classes**
- `02a-class-core.puml` : Framework (Controller, Model, Router, Auth, Database)
- `02b-class-models.puml` : Modèles métier
- `02c-class-controllers.puml` : Contrôleurs

**Séquence**
- `03-sequence-authentification.puml` : Processus d'authentification
- `04-sequence-evaluation.puml` : Évaluation d'une ressource
- `05-sequence-crud-livre.puml` : Création d'un livre

**Structure**
- `06-component-diagram.puml` : Architecture en composants
- `07-package-diagram.puml` : Organisation du code
- `08-mcd.puml` : Modèle Conceptuel de Données
- `09-mld.puml` : Modèle Logique de Données

### Visualisation des diagrammes

**VS Code**
- Installer l'extension "PlantUML"
- Ouvrir un fichier `.puml`
- Utiliser Alt+D pour prévisualiser

**En ligne**
- Accéder à https://www.plantuml.com/plantuml/uml/
- Copier-coller le contenu du fichier `.puml`

**Génération d'images**
```bash
cd documentation/diagrammes
plantuml *.puml
```

## Sécurité

### Mesures implémentées

- **Protection SQL Injection** : Utilisation systématique de PDO avec requêtes préparées
- **Protection XSS** : Échappement des données avec `htmlspecialchars()`
- **Mots de passe** : Hachage sécurisé avec `password_hash()` (bcrypt)
- **Sessions** : Gestion sécurisée de l'authentification

### Recommandations pour la production

- Implémenter des tokens CSRF pour les formulaires
- Mettre en place un rate limiting sur les tentatives de connexion
- Forcer l'utilisation de HTTPS
- Utiliser des variables d'environnement pour les credentials
- Configurer les en-têtes de sécurité HTTP

## Base de données

### Tables principales

- **utilisateur** : Comptes utilisateurs (visiteur, bibliothécaire, administrateur)
- **ressource** : Table parent pour livres et films
- **livre** : Informations spécifiques aux livres
- **film** : Informations spécifiques aux films
- **genre** : Genres des ressources
- **theme** : Thèmes des ressources
- **evaluation** : Notes et critiques des utilisateurs
- **ressource_genre** : Association ressources-genres (N:N)
- **ressource_theme** : Association ressources-thèmes (N:N)

Voir `sql/schema.sql` pour la structure complète.

## Développement

### Conventions de code

- Respect du standard PSR-12 pour PHP
- camelCase pour les variables et méthodes
- PascalCase pour les noms de classes
- snake_case pour les colonnes SQL

### Architecture MVC

**Controllers**
- Gèrent les requêtes HTTP
- Héritent de la classe `Controller`
- Appellent les modèles
- Rendent les vues

**Models**
- Gèrent l'accès aux données
- Héritent de la classe `Model`
- Utilisent PDO pour les requêtes
- Valident les données

**Views**
- Affichent les données
- Utilisent le layout principal
- Échappent les variables pour la sécurité

## Référence du projet

**Cadre** : SAE R307 - Année 2025/2026

**Inspiration** : https://vod.mediatheque-numerique.com

**Enseignant** : thanh-phuong.nguyen@univcotedazur.fr

**Institution** : IUT Nice Côte d'Azur

## Notes importantes

Ce projet a été développé dans un cadre pédagogique. Certaines fonctionnalités de sécurité doivent être renforcées avant un déploiement en production.
