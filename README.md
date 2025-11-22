# 📚 E-Library - Médiathèque Numérique

> Projet SAE R307 - Année 2025/2026

E-Library est une application web de gestion de médiathèque permettant la gestion et la consultation de ressources numériques (livres, films, DVD, etc.).

[![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 🎯 Fonctionnalités

### Front Office (Public)
- ✅ **Catalogue** : Consultation de toutes les ressources
- ✅ **Recherche avancée** : Multi-critères (titre, auteur, genre, thème, année)
- ✅ **Nouveautés** : Affichage des dernières acquisitions
- ✅ **Top** : Ressources les mieux notées
- ✅ **Sélection** : Ressources organisées par thème
- ✅ **Détails ressource** : Informations complètes, évaluations, critiques

### Espace Utilisateur
- ✅ **Inscription/Connexion** : Authentification sécurisée
- ✅ **Évaluation** : Notation (0-5 étoiles) et rédaction de critiques
- ✅ **Gestion de profil** : Visualisation des informations personnelles

### Back Office (Administration)
- ✅ **Gestion des livres** : CRUD complet
- ✅ **Gestion des films** : CRUD complet
- ✅ **Gestion des genres** : CRUD complet
- ✅ **Gestion des thèmes** : CRUD complet
- ✅ **Statistiques** : Dashboard avec métriques

## 🏗️ Architecture

### Technologies utilisées
- **Backend** : PHP 8.0+ (POO, PDO)
- **Base de données** : MySQL 8.0+
- **Frontend** : HTML5, CSS3, JavaScript (Vanilla)
- **Architecture** : MVC (Model-View-Controller)
- **Sécurité** : Protection XSS, SQL Injection, Bcrypt

### Structure du projet
```
mediatheque/
├── app/
│   ├── controllers/     # Contrôleurs MVC
│   ├── models/          # Modèles métier
│   └── views/           # Vues (templates)
├── config/              # Configuration (DB, etc.)
├── core/                # Framework MVC de base
├── documentation/       # Documentation complète
│   └── diagrammes/      # Diagrammes UML (PlantUML)
├── public/              # Assets publics (CSS, JS, images)
├── sql/                 # Scripts SQL (schéma, données)
├── index.php            # Point d'entrée
└── README.md            # Ce fichier
```

## 🚀 Installation

### Prérequis
- PHP >= 8.0
- MySQL >= 8.0 ou MariaDB >= 10.5
- Serveur web (Apache, Nginx) ou PHP built-in server
- Composer (optionnel)

### Étapes d'installation

1. **Cloner le repository**
   ```bash
   git clone https://github.com/votre-equipe/mediatheque.git
   cd mediatheque
   ```

2. **Configurer la base de données**

   Créer une base de données MySQL :
   ```bash
   mysql -u root -p
   ```
   ```sql
   CREATE DATABASE gm401942_elibrary2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   EXIT;
   ```

3. **Importer le schéma**
   ```bash
   mysql -u root -p gm401942_elibrary2 < sql/schema.sql
   ```

4. **Importer les données de test** (optionnel)
   ```bash
   mysql -u root -p gm401942_elibrary2 < sql/data.sql
   ```

   **OU** utiliser le script de seeding PHP :
   ```bash
   php seed.php
   ```

5. **Configurer les credentials**

   Modifier le fichier `config/config.php` :
   ```php
   define('DB_HOST', '127.0.0.1');
   define('DB_PORT', '3306');
   define('DB_NAME', 'gm401942_elibrary2');
   define('DB_USER', 'votre_utilisateur');
   define('DB_PASS', 'votre_mot_de_passe');
   ```

6. **Démarrer le serveur**

   **Option 1 : PHP Built-in Server** (développement)
   ```bash
   php -S localhost:8000
   ```

   **Option 2 : Apache/Nginx**

   Configurer le DocumentRoot vers le dossier du projet.

   **Exemple Apache (vhost) :**
   ```apache
   <VirtualHost *:80>
       ServerName mediatheque.local
       DocumentRoot /path/to/mediatheque
       <Directory /path/to/mediatheque>
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

7. **Accéder à l'application**

   Ouvrir le navigateur : `http://localhost:8000`

## 👥 Comptes de test

Après l'import des données (`data.sql` ou `seed.php`), vous pouvez utiliser :

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | admin@mediatheque.com | password |
| Bibliothécaire | biblio@mediatheque.com | password |
| Utilisateur | user@mediatheque.com | password |

## 📖 Documentation

La documentation complète se trouve dans le dossier [`documentation/`](documentation/) :

- **[ARCHITECTURE.md](documentation/ARCHITECTURE.md)** : Architecture détaillée du projet
- **[INSTALLATION.md](documentation/INSTALLATION.md)** : Guide d'installation complet
- **[SECURITY.md](documentation/SECURITY.md)** : Recommandations de sécurité
- **[Diagrammes UML](documentation/diagrammes/)** : Tous les diagrammes PlantUML

### Diagrammes UML disponibles
1. **Use Case Diagram** : Cas d'utilisation
2. **Class Diagram** : Structure des classes
3. **Sequence Diagrams** : Flux d'authentification, évaluation, CRUD
4. **Component Diagram** : Architecture en composants
5. **Package Diagram** : Organisation du code

### Visualiser les diagrammes PlantUML

**Option 1 : VS Code**
- Installer l'extension "PlantUML"
- Ouvrir un fichier `.puml`
- Alt+D pour prévisualiser

**Option 2 : En ligne**
- Aller sur https://www.plantuml.com/plantuml/uml/
- Copier-coller le contenu du fichier `.puml`

**Option 3 : Générer des images**
```bash
# Installer PlantUML
brew install plantuml  # macOS
sudo apt install plantuml  # Linux

# Générer les PNG
cd documentation/diagrammes
plantuml *.puml
```

## 🔒 Sécurité

### Mesures implémentées
- ✅ **SQL Injection** : PDO avec prepared statements
- ✅ **XSS** : Échappement avec `htmlspecialchars()`
- ✅ **Mots de passe** : Hachage bcrypt via `password_hash()`
- ✅ **Sessions** : Authentification basée sur les sessions PHP

### Améliorations recommandées
- ⚠️ **CSRF Protection** : Implémenter des tokens CSRF
- ⚠️ **Rate Limiting** : Limiter les tentatives de connexion
- ⚠️ **HTTPS** : Forcer HTTPS en production
- ⚠️ **Variables d'environnement** : Utiliser `.env` pour les credentials

Voir [SECURITY.md](documentation/SECURITY.md) pour plus de détails.

## 🧪 Tests

### Tests manuels
1. **Inscription** : Créer un nouveau compte
2. **Connexion** : Se connecter avec les identifiants
3. **Navigation** : Explorer le catalogue
4. **Recherche** : Tester les filtres
5. **Évaluation** : Noter une ressource
6. **Admin** : Créer/modifier/supprimer une ressource

### Tests automatisés
Les tests PHPUnit sont en cours de développement.

## 📊 Base de données

### Schéma
- **utilisateur** : Utilisateurs du système
- **ressource** : Table parent (livres + films)
- **livre** : Spécialisation de ressource
- **film** : Spécialisation de ressource
- **genre** : Genres des ressources
- **theme** : Thèmes des ressources
- **evaluation** : Notes et critiques
- **ressource_genre** : Association N:N
- **ressource_theme** : Association N:N

Voir [sql/schema.sql](sql/schema.sql) pour la structure complète.

## 🛠️ Développement

### Convention de code
- **PSR-12** : Standard de codage PHP
- **camelCase** : Noms de variables et méthodes
- **PascalCase** : Noms de classes
- **snake_case** : Noms de colonnes SQL

### Structure MVC

**Controllers** → Gèrent les requêtes HTTP
- Héritent de `Controller`
- Appellent les modèles
- Rendent les vues

**Models** → Accèdent aux données
- Héritent de `Model`
- Utilisent PDO
- Valident les données

**Views** → Affichent les données
- Utilisent le layout principal
- Échappent les variables
- Incluent les partials

## 🤝 Contribution

Ce projet est un projet académique (SAE R307).

**Équipe :**
- [Membre 1] - Rôle
- [Membre 2] - Rôle
- [Membre 3] - Rôle

## 📝 Licence

Ce projet est sous licence MIT. Voir [LICENSE](LICENSE) pour plus d'informations.

## 📞 Contact

Pour toute question concernant le projet :
- **Enseignant** : thanh-phuong.nguyen@univcotedazur.fr
- **Repository** : https://github.com/votre-equipe/mediatheque

## 🙏 Remerciements

- Inspiration : https://vod.mediatheque-numerique.com
- IUT Nice Côte d'Azur
- SAE R307 - 2025/2026

---

**Note** : Ce projet a été développé dans un cadre pédagogique. Certaines fonctionnalités de sécurité doivent être renforcées avant un déploiement en production.
