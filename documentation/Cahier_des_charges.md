# CAHIER DES CHARGES
## Médiathèque Numérique (E-Library)

**SAE R307 - Année 2025/2026**

---

## INFORMATIONS GÉNÉRALES

**Projet** : E-Library - Médiathèque Numérique
**Date de rédaction** : Janvier 2025
**Version** : 1.0
**Responsable projet** : NGUYEN Thanh Phuong

---

## 1. CONTEXTE ET ENJEUX

### 1.1 Présentation du projet

E-Library est une application web de gestion de médiathèque permettant aux utilisateurs de consulter, rechercher et évaluer des ressources numériques (livres, films, DVD, bandes dessinées, etc.).

Le projet vise à moderniser l'accès aux ressources culturelles en proposant une interface conviviale inspirée du site https://vod.mediatheque-numerique.com.

### 1.2 Objectifs principaux

- **Catalogage intelligent** : Organisation claire des ressources par catégories, thèmes et genres
- **Recherche avancée** : Outil de recherche multicritère performant
- **Interaction utilisateur** : Système d'évaluation et de notation des ressources
- **Gestion multi-profils** : Différents niveaux d'accès selon le type d'utilisateur
- **Découvrabilité** : Mise en avant des nouveautés et des contenus populaires

### 1.3 Périmètre du projet

**Inclus dans le projet** :
- Application web responsive (desktop et mobile)
- Gestion complète des ressources (livres et films)
- Système d'authentification et d'autorisation
- Interface d'administration
- Système d'évaluation et de notation
- Recherche multicritère avancée

**Hors périmètre** :
- Application mobile native
- Système de réservation/emprunt physique
- Paiement en ligne
- Chat en direct avec bibliothécaires

---

## 2. EXPRESSION DES BESOINS

### 2.1 Besoins fonctionnels

#### 2.1.1 Gestion des utilisateurs

**Inscription et authentification**
- Création de compte avec validation email
- Connexion sécurisée (email + mot de passe)
- Déconnexion
- Profil utilisateur avec historique d'évaluations

**Types d'utilisateurs** :
1. **Utilisateur normal** : Consultation et évaluation des ressources
2. **Bibliothécaire** : Gestion des ressources (ajout, modification, suppression)
3. **Administrateur** : Gestion complète (utilisateurs, ressources, thèmes, genres)

#### 2.1.2 Gestion du catalogue

**Ressources - Livres** :
- Titre
- Auteur
- Éditeur
- Année de publication
- ISBN
- Nombre de pages
- Prix
- Thème(s)
- Genre(s)
- Pays
- Image de couverture
- Résumé

**Ressources - Films** :
- Titre
- Réalisateur
- Année de production
- Durée
- Synopsis
- Thème(s)
- Genre(s)
- Pays de l'intrigue
- Langue(s)
- Sous-titres disponibles
- Support (DVD, Blu-ray, Streaming)
- Image/affiche

#### 2.1.3 Fonctionnalités de découverte

**i) Nouveautés**
- Affichage des ressources récemment ajoutées
- Tri par date d'ajout décroissante
- Limite configurable (par défaut : 20 ressources)

**ii) Top**
- Ressources les mieux notées
- Calcul de la note moyenne
- Nombre d'évaluations minimum pour apparaître
- Ressources non notées affichées avec 0/5

**iii) Sélection**
- Filtrage par thème spécifique
- Présentation thématique des ressources

**iv) Catalogue complet**
- Liste exhaustive de toutes les ressources
- Enrichie avec notes et évaluations
- Affichage par type (livre/film)

**v) Recherche avancée**
- Recherche par titre ou auteur/réalisateur
- Filtres multiples :
  - Type de ressource (livre/film)
  - Genre
  - Thème
  - Plage d'années (année min/max)
- Résultats avec notes et évaluations

#### 2.1.4 Système d'évaluation

**Pour les utilisateurs connectés** :
- Attribution d'une note de 1 à 5 étoiles
- Rédaction d'une critique textuelle (max 1000 caractères)
- Une seule évaluation par utilisateur par ressource
- Modification impossible après soumission

**Affichage des évaluations** :
- Note moyenne calculée automatiquement
- Nombre total d'évaluations
- Liste des critiques avec nom de l'utilisateur et date
- Affichage chronologique (plus récentes en premier)

#### 2.1.5 Administration

**Gestion des ressources** (Bibliothécaire + Administrateur)
- Ajout de nouvelles ressources (livres et films)
- Modification des informations
- Suppression de ressources
- Association aux thèmes et genres

**Gestion des référentiels** (Administrateur uniquement)
- CRUD complet sur les thèmes
- CRUD complet sur les genres
- Gestion des utilisateurs

### 2.2 Besoins non-fonctionnels

#### 2.2.1 Performance
- Temps de chargement des pages < 2 secondes
- Pagination pour les listes de plus de 20 éléments
- Optimisation des requêtes SQL (index sur colonnes fréquentes)

#### 2.2.2 Sécurité
- **Authentification** : Mots de passe hashés avec bcrypt (PASSWORD_DEFAULT)
- **Autorisation** : Contrôle d'accès basé sur les rôles
- **Protection SQL Injection** : Utilisation exclusive de PDO avec requêtes préparées
- **Protection XSS** : Échappement de toutes les sorties HTML (htmlspecialchars)
- **Protection CSRF** : Validation des tokens pour les formulaires critiques
- **Sessions sécurisées** : Configuration PHP appropriée

#### 2.2.3 Ergonomie et accessibilité
- Interface responsive (mobile, tablette, desktop)
- Navigation intuitive avec breadcrumb
- Messages de feedback clairs (succès, erreur)
- Design moderne inspiré de sites de streaming culturel
- Mode sombre/clair pour le confort visuel

#### 2.2.4 Maintenabilité
- Code organisé selon le patron MVC
- Commentaires et documentation du code
- Nommage cohérent des variables et fonctions
- Séparation claire des responsabilités

#### 2.2.5 Compatibilité
- Navigateurs modernes (Chrome, Firefox, Safari, Edge)
- PHP >= 7.4
- MySQL >= 5.7

---

## 3. ACTEURS DU SYSTÈME

### 3.1 Matrice des droits et permissions

| Fonctionnalité | Utilisateur normal | Bibliothécaire | Administrateur |
|----------------|-------------------|----------------|----------------|
| **Consultation** |
| Consulter le catalogue | Oui | Oui | Oui |
| Rechercher des ressources | Oui | Oui | Oui |
| Voir les détails d'une ressource | Oui | Oui | Oui |
| Voir les évaluations | Oui | Oui | Oui |
| **Évaluation** |
| Évaluer une ressource (note + critique) | Oui | Oui | Oui |
| Voir ses propres évaluations | Oui | Oui | Oui |
| **Gestion des ressources** |
| Ajouter une ressource (livre/film) | Non | Oui | Oui |
| Modifier une ressource | Non | Oui | Oui |
| Supprimer une ressource | Non | Oui | Oui |
| Associer ressources aux thèmes/genres | Non | Oui | Oui |
| **Gestion des référentiels** |
| Créer un thème | Non | Non | Oui |
| Modifier un thème | Non | Non | Oui |
| Supprimer un thème | Non | Non | Oui |
| Créer un genre | Non | Non | Oui |
| Modifier un genre | Non | Non | Oui |
| Supprimer un genre | Non | Non | Oui |
| **Administration** |
| Gérer les utilisateurs | Non | Non | Oui |
| Modifier les rôles utilisateurs | Non | Non | Oui |
| Supprimer des utilisateurs | Non | Non | Oui |

### 3.2 Cas d'usage par profil

**Utilisateur normal** :
1. S'inscrire et se connecter
2. Parcourir le catalogue (nouveautés, top, sélections)
3. Rechercher une ressource spécifique
4. Consulter les détails d'une ressource
5. Évaluer une ressource consultée
6. Consulter les avis de la communauté

**Bibliothécaire** :
1. Tous les cas d'usage de l'utilisateur normal
2. Enrichir le catalogue avec de nouvelles ressources
3. Mettre à jour les informations des ressources
4. Retirer des ressources obsolètes
5. Organiser les ressources par thèmes et genres

**Administrateur** :
1. Tous les cas d'usage du bibliothécaire
2. Administrer les référentiels (thèmes, genres)
3. Gérer les droits utilisateurs
4. Maintenir la cohérence du système
5. Superviser l'activité globale

---

## 4. CONTRAINTES TECHNIQUES

### 4.1 Technologies imposées

**Back-end** :
- Langage : PHP (>= 7.4)
- Base de données : MySQL (>= 5.7)
- Accès données : PDO (PHP Data Objects)
- Architecture : MVC (Model-View-Controller)
- Programmation orientée objet

**Front-end** :
- HTML5 sémantique
- CSS3 (responsive design)
- JavaScript vanilla (pas de framework obligatoire)

### 4.2 Architecture applicative

**Patron MVC** :
```
/app
  /controllers    -> Logique de contrôle
  /models         -> Accès aux données
  /views          -> Templates d'affichage
/core             -> Classes core (Router, Database, Controller, Model)
/config           -> Configuration
/public
  /css            -> Feuilles de style
  /js             -> Scripts JavaScript
  /images         -> Images ressources
```

### 4.3 Base de données

**Modèle relationnel normalisé** :
- Tables principales : `utilisateur`, `ressource`, `livre`, `film`, `evaluation`
- Tables de liaison : `ressource_theme`, `ressource_genre`
- Tables référentiels : `theme`, `genre`

**Contraintes d'intégrité** :
- Clés primaires auto-incrémentées
- Clés étrangères avec CASCADE
- Contraintes UNIQUE (email, ISBN)
- Indexes sur colonnes fréquemment requêtées

### 4.4 Exigences de sécurité

| Menace | Protection requise | Implémentation |
|--------|-------------------|----------------|
| SQL Injection | Requêtes préparées | PDO avec bindValue/bindParam |
| XSS (Cross-Site Scripting) | Échappement HTML | htmlspecialchars() sur toutes les sorties |
| Mots de passe en clair | Hashage sécurisé | password_hash() avec PASSWORD_DEFAULT |
| CSRF | Tokens de validation | Tokens dans formulaires critiques |
| Session hijacking | Sessions sécurisées | Configuration PHP appropriée |

---

## 5. LIVRABLES ATTENDUS

### 5.1 Documents (format Word)

| Document | Points | Contenu principal |
|----------|--------|-------------------|
| **1. Cahier des charges** | 2 | Contexte, objectifs, besoins fonctionnels et non-fonctionnels, acteurs, contraintes, planning |
| **2. Spécification technique** | 5 | Diagrammes UML (Component, Use case, Sequence, Package, Class), conception BDD (MCD, MLD, SQL), spécification composants |
| **3. Répartition des tâches** | 1 | Tableau détaillé des tâches par étudiant, pourcentage de contribution |

**Diagrammes UML obligatoires** (document 2) :
- Component diagram (architecture globale)
- Use case diagram (cas d'usage par acteur)
- Sequence diagram (scénarios principaux)
- Package diagram (organisation du code)
- Class diagram (modèle objet)

**Conception base de données** (document 2) :
- MCD (Modèle Conceptuel de Données)
- MLD (Modèle Logique de Données)
- Script SQL complet de création

### 5.2 Code source (12 points)

**Dépôt GitHub/GitLab** contenant :
- Code source complet et fonctionnel
- Architecture MVC respectée
- Base de données en PDO
- Protection contre SQL Injection (100% des requêtes)
- Script SQL de création de base de données
- Fichier README.md avec instructions d'installation complètes
- Les 3 documents Word mentionnés ci-dessus
- Historique Git montrant les contributions de chaque étudiant

**Critères d'évaluation du code** :

| Critère | Description | Poids |
|---------|-------------|-------|
| Fonctionnalités | Toutes les fonctionnalités opérationnelles | 30% |
| Architecture MVC | Respect strict du patron | 20% |
| Sécurité | PDO, validation, hashage, échappement | 20% |
| Qualité du code | Lisibilité, commentaires, nommage | 15% |
| Documentation | README, commentaires, guide install | 10% |
| Contributions Git | Équilibre et traçabilité | 5% |

---

## 6. PLANNING ET ORGANISATION

### 6.1 Charge de travail estimée

| Phase | Heures | Détail |
|-------|--------|--------|
| **Intégration front-end** | 15h | Maquettage HTML/CSS, responsive design, intégration JavaScript |
| **Développement back-end** | 25h | Architecture MVC, modèles et contrôleurs, base de données, sécurité |
| **TOTAL par étudiant** | **40h** | |

### 6.2 Organisation des équipes

**Règle de composition** :
- Nombre d'étudiants n = 3k + r (0 <= r <= 2)
- Si r = 0 : k équipes de 3 étudiants
- Si r > 0 : (k-r) équipes de 3 étudiants + r équipes de 4 étudiants

**Validation** :
- Email de confirmation à : thanh-phuong.nguyen@univcotedazur.fr
- Sujet : SAE R307
- Contenu : Composition de l'équipe avec noms et prénoms

### 6.3 Phases du projet

| Phase | Durée | Livrables |
|-------|-------|-----------|
| 1. Analyse et conception | Semaines 1-2 | Cahier des charges, MCD, diagrammes UML |
| 2. Développement front-end | Semaines 2-4 | Templates HTML/CSS, maquettes |
| 3. Développement back-end | Semaines 3-6 | Modèles, contrôleurs, BDD |
| 4. Tests et intégration | Semaine 7 | Application fonctionnelle complète |
| 5. Documentation finale | Semaine 8 | Documents finaux, README |

### 6.4 WBS - Work Breakdown Structure

```
E-Library
|
+-- 1. Gestion de projet
|   +-- 1.1 Cahier des charges
|   +-- 1.2 Spécifications techniques
|   +-- 1.3 Répartition des tâches
|   +-- 1.4 Planning (Gantt)
|
+-- 2. Conception
|   +-- 2.1 Diagrammes UML
|   |   +-- 2.1.1 Component diagram
|   |   +-- 2.1.2 Use case diagram
|   |   +-- 2.1.3 Sequence diagram
|   |   +-- 2.1.4 Package diagram
|   |   +-- 2.1.5 Class diagram
|   +-- 2.2 Modélisation BDD
|   |   +-- 2.2.1 MCD
|   |   +-- 2.2.2 MLD
|   |   +-- 2.2.3 Script SQL
|   +-- 2.3 Architecture MVC
|
+-- 3. Développement Front-end
|   +-- 3.1 Templates HTML
|   |   +-- 3.1.1 Layout principal
|   |   +-- 3.1.2 Pages catalogue
|   |   +-- 3.1.3 Pages administration
|   |   +-- 3.1.4 Pages authentification
|   +-- 3.2 Styles CSS
|   |   +-- 3.2.1 Design système
|   |   +-- 3.2.2 Responsive design
|   |   +-- 3.2.3 Mode sombre/clair
|   +-- 3.3 Scripts JavaScript
|       +-- 3.3.1 Validation formulaires
|       +-- 3.3.2 Interactions UI
|
+-- 4. Développement Back-end
|   +-- 4.1 Core
|   |   +-- 4.1.1 Router
|   |   +-- 4.1.2 Database (PDO)
|   |   +-- 4.1.3 Controller de base
|   |   +-- 4.1.4 Model de base
|   |   +-- 4.1.5 Auth
|   +-- 4.2 Modèles
|   |   +-- 4.2.1 Utilisateur
|   |   +-- 4.2.2 Ressource
|   |   +-- 4.2.3 Livre
|   |   +-- 4.2.4 Film
|   |   +-- 4.2.5 Evaluation
|   |   +-- 4.2.6 Theme
|   |   +-- 4.2.7 Genre
|   +-- 4.3 Contrôleurs
|   |   +-- 4.3.1 AuthController
|   |   +-- 4.3.2 CatalogueController
|   |   +-- 4.3.3 RessourceController
|   |   +-- 4.3.4 EvaluationController
|   |   +-- 4.3.5 AdminController
|   +-- 4.4 Base de données
|       +-- 4.4.1 Création des tables
|       +-- 4.4.2 Données de test
|       +-- 4.4.3 Indexes et contraintes
|
+-- 5. Tests et validation
|   +-- 5.1 Tests fonctionnels
|   +-- 5.2 Tests de sécurité
|   +-- 5.3 Tests d'intégration
|   +-- 5.4 Tests multi-navigateurs
|
+-- 6. Documentation
    +-- 6.1 README
    +-- 6.2 Commentaires code
    +-- 6.3 Guide d'installation
    +-- 6.4 Documentation API
```

---

## 7. CRITÈRES D'ACCEPTATION

### 7.1 Critères fonctionnels

| Module | Critères | Validation |
|--------|----------|------------|
| **Authentification** | Inscription fonctionnelle avec validation | Test création compte |
| | Connexion sécurisée | Test login/logout |
| | Gestion des sessions | Test persistance session |
| | Contrôle d'accès par rôle | Test autorisations |
| **Catalogue** | Affichage de toutes les ressources | Vérification liste complète |
| | Nouveautés triées par date | Test tri décroissant |
| | Top triés par note moyenne | Test calcul notes |
| | Sélection par thème fonctionnelle | Test filtrage |
| **Recherche** | Recherche par titre/auteur | Test recherche textuelle |
| | Filtres multiples opérationnels | Test combinaison filtres |
| | Résultats pertinents | Vérification pertinence |
| **Évaluation** | Notation de 1 à 5 étoiles | Test soumission note |
| | Critique textuelle | Test soumission commentaire |
| | Limitation 1 éval/user/ressource | Test contrainte unique |
| | Affichage des évaluations | Vérification affichage |
| **Administration** | CRUD ressources (bibliothécaire) | Test création/modification/suppression |
| | CRUD thèmes/genres (admin) | Test gestion référentiels |
| | Gestion utilisateurs (admin) | Test administration users |

### 7.2 Critères techniques

| Domaine | Exigence | Validation |
|---------|----------|------------|
| **Architecture** | Patron MVC respecté | Code review structure |
| | Code organisé et commenté | Audit qualité code |
| | Séparation des responsabilités | Vérification architecture |
| **Base de données** | Modèle relationnel normalisé | Analyse schéma |
| | Contraintes d'intégrité | Test contraintes |
| | Script SQL fonctionnel | Test installation BDD |
| **Sécurité** | PDO avec requêtes préparées | Audit 100% requêtes |
| | Mots de passe hashés bcrypt | Vérification hashage |
| | Échappement HTML systématique | Test XSS |
| | Validation des entrées | Test injections |
| **Performance** | Temps de chargement < 2s | Tests de charge |
| | Requêtes SQL optimisées | Analyse EXPLAIN |

### 7.3 Critères de qualité

| Aspect | Critère | Méthode de validation |
|--------|---------|----------------------|
| **Code** | Nommage cohérent et explicite | Revue de code |
| | Indentation et formatage uniforme | Vérification PSR |
| | Commentaires pertinents | Audit documentation |
| | Pas de code dupliqué excessif | Analyse similarité |
| **Git** | Commits réguliers et descriptifs | Historique Git |
| | Contributions visibles par membre | Statistiques Git |
| | Branches utilisées si nécessaire | Graphe des branches |
| **Documentation** | README complet et clair | Test installation |
| | Instructions fonctionnelles | Suivre le guide |
| | Diagrammes UML conformes | Vérification notation |
| | Documents Word professionnels | Relecture formelle |

---

## 8. RISQUES ET CONTRAINTES

### 8.1 Analyse des risques

| Risque | Probabilité | Impact | Mitigation | Responsable |
|--------|-------------|--------|------------|-------------|
| Répartition déséquilibrée du travail | Moyenne | Fort | Suivi Git régulier, réunions hebdomadaires, validation équipe | Chef de projet |
| Problèmes de sécurité (SQL Injection) | Faible | Critique | Code review systématique, tests de sécurité | Tous |
| Retard dans le planning | Moyenne | Moyen | Marges de sécurité, priorisation des features | Chef de projet |
| Incompatibilité navigateurs | Faible | Faible | Tests multi-navigateurs réguliers | Développeur front |
| Perte de données | Très faible | Fort | Sauvegardes Git régulières, commits fréquents | Tous |
| Mésentente dans l'équipe | Faible | Moyen | Communication régulière, répartition claire | Chef de projet |
| Bugs en production | Moyenne | Moyen | Tests unitaires, tests d'intégration | Développeurs back |

### 8.2 Contraintes opérationnelles

| Contrainte | Description | Impact |
|-----------|-------------|--------|
| Délai fixe | Fin de semestre non négociable | Fort - Planning serré |
| Technologies imposées | PHP, MySQL, PDO obligatoires | Moyen - Pas de choix techno |
| Évaluation par jury | Démonstration en direct | Fort - Nécessite version stable |
| Contribution traçable | Historique Git vérifié | Moyen - Discipline Git requise |
| Équipes imposées | Composition selon règle 3k+r | Faible - Adaptable |

---

## 9. GLOSSARY

| Terme | Définition |
|-------|------------|
| **MVC** | Model-View-Controller - Patron de conception séparant données, logique et présentation |
| **PDO** | PHP Data Objects - Extension PHP pour l'accès aux bases de données de manière abstraite |
| **CRUD** | Create, Read, Update, Delete - Opérations de base sur les données |
| **SQL Injection** | Technique d'attaque exploitant des failles dans les requêtes SQL |
| **XSS** | Cross-Site Scripting - Injection de code malveillant côté client |
| **CSRF** | Cross-Site Request Forgery - Attaque forçant un utilisateur authentifié à exécuter des actions non désirées |
| **bcrypt** | Algorithme de hashage sécurisé spécifiquement conçu pour les mots de passe |
| **Responsive** | Design adaptatif s'ajustant automatiquement à la taille de l'écran |
| **UML** | Unified Modeling Language - Langage de modélisation graphique standardisé |
| **MCD** | Modèle Conceptuel de Données - Représentation abstraite des données |
| **MLD** | Modèle Logique de Données - Représentation technique des données |
| **WBS** | Work Breakdown Structure - Décomposition hiérarchique du travail |
| **Gantt** | Diagramme de planification temporelle des tâches |

---

## 10. RÉFÉRENCES

- **Site de référence** : https://vod.mediatheque-numerique.com
- **Cours** : SAE R307 - NGUYEN Thanh Phuong
- **Documentation PHP** : https://www.php.net
- **Documentation MySQL** : https://dev.mysql.com/doc/
- **Guide UML** : https://www.uml.org
- **PSR (PHP Standards)** : https://www.php-fig.org/psr/
- **OWASP (Sécurité)** : https://owasp.org/www-project-top-ten/

---

## 11. ANNEXES

### Annexe A : Structure minimale de la base de données

```sql
-- Tables principales
CREATE TABLE utilisateur (
    id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('utilisateur', 'bibliothecaire', 'administrateur')
);

CREATE TABLE ressource (
    id_ressource INT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('livre', 'film') NOT NULL,
    titre VARCHAR(255) NOT NULL,
    auteur_realisateur VARCHAR(255) NOT NULL,
    annee SMALLINT NOT NULL
);

CREATE TABLE evaluation (
    id_evaluation INT PRIMARY KEY AUTO_INCREMENT,
    id_utilisateur INT NOT NULL,
    id_ressource INT NOT NULL,
    note DECIMAL(2,1) NOT NULL,
    critique TEXT,
    UNIQUE(id_utilisateur, id_ressource),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
    FOREIGN KEY (id_ressource) REFERENCES ressource(id_ressource)
);
```

### Annexe B : Exemple de requête préparée PDO

```php
// INCORRECT - Vulnérable SQL Injection
$sql = "SELECT * FROM utilisateur WHERE email = '$email'";
$result = $pdo->query($sql);

// CORRECT - Requête préparée sécurisée
$sql = "SELECT * FROM utilisateur WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch();
```

### Annexe C : Checklist de livraison

| Élément | Vérifié | Date | Responsable |
|---------|---------|------|-------------|
| **Documents** |
| Cahier des charges Word | [ ] | | |
| Spécification technique Word | [ ] | | |
| Répartition des tâches Word/Excel | [ ] | | |
| Diagrammes UML (5 types minimum) | [ ] | | |
| MCD/MLD | [ ] | | |
| **Code** |
| Dépôt Git accessible | [ ] | | |
| README.md complet | [ ] | | |
| Architecture MVC respectée | [ ] | | |
| 100% requêtes en PDO | [ ] | | |
| Mots de passe hashés bcrypt | [ ] | | |
| Échappement HTML systématique | [ ] | | |
| Script SQL fonctionnel | [ ] | | |
| Contributions Git visibles | [ ] | | |
| **Tests** |
| Toutes fonctionnalités testées | [ ] | | |
| Tests sécurité SQL Injection | [ ] | | |
| Tests multi-navigateurs | [ ] | | |
| Installation testée from scratch | [ ] | | |

---

## VALIDATION ET SIGNATURES

**Date de validation** : _____________________

**Membres de l'équipe** :

| Rôle | Nom et Prénom | Signature | Date |
|------|---------------|-----------|------|
| Chef de projet | | | |
| Développeur Back-end | | | |
| Développeur Front-end | | | |
| Développeur Full-stack | | | |

**Engagement de l'équipe** :
Nous, soussignés, nous engageons à respecter les spécifications décrites dans ce cahier des charges et à livrer une application conforme aux exigences énoncées dans les délais impartis.

---

**Fin du document - Cahier des charges E-Library v1.0**

**Total pages** : [À compléter]
**Dernière mise à jour** : Janvier 2025
