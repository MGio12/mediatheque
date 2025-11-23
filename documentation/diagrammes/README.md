# Diagrammes UML - Médiathèque

Ce dossier contient tous les diagrammes UML du projet au format PlantUML (.puml).

## Liste des diagrammes

### 1. Use Case Diagram (Cas d'utilisation)

**Fichier :** [01-use-case.puml](01-use-case.puml)

| Élément | Description |
|---------|-------------|
| **Acteurs** | Visiteur, Utilisateur, Utilisateur connecté, Bibliothécaire, Administrateur |
| **Front Office** | Catalogue, Recherche, Nouveautés, Top, Sélection par thème, Détail ressource, Évaluation |
| **Back Office** | Gestion livres, Gestion films, Gestion genres, Gestion thèmes |
| **Relations** | Héritage entre acteurs, include/extend entre cas d'utilisation |

**Vue d'ensemble :** Présente toutes les fonctionnalités accessibles selon le rôle utilisateur.

---

### 2. Class Diagram (Diagramme de classes)

**Fichier :** [02-class-diagram.puml](02-class-diagram.puml)

| Catégorie | Classes |
|-----------|---------|
| **Métier** | Utilisateur, Ressource (abstraite), Livre, Film, Genre, Theme, Evaluation |
| **Technique** | Auth, Database, Controller, Model, Router |
| **Patterns** | Active Record, MVC, Singleton (Database) |

**Contenu :**
- Attributs et méthodes principales
- Relations : héritage (Ressource → Livre/Film), association, agrégation
- Contraintes et notes sur la sécurité

---

### 3. Sequence Diagram - Authentification

**Fichier :** [03-sequence-authentification.puml](03-sequence-authentification.puml)

| Scénario | Description |
|----------|-------------|
| **Register** | Inscription nouvel utilisateur avec validation email unique |
| **Login** | Connexion avec vérification password_verify() et session |
| **Logout** | Déconnexion avec session_destroy() |

**Interactions :** Router → Controller → Model → Database

**Notes de sécurité :** Session fixation, validation côté serveur, hachage bcrypt

---

### 4. Sequence Diagram - Évaluation

**Fichier :** [04-sequence-evaluation.puml](04-sequence-evaluation.puml)

| Scénario | Description |
|----------|-------------|
| **Affichage ressource** | Chargement détails + évaluations existantes |
| **Créer évaluation** | Vérification unicité (un user = une évaluation/ressource) |
| **Transaction** | INSERT evaluation avec gestion erreur et rollback |

**Notes de sécurité :** Protection CSRF, contrôle d'accès (utilisateur connecté uniquement)

---

### 5. Sequence Diagram - CRUD Livre

**Fichier :** [05-sequence-crud-livre.puml](05-sequence-crud-livre.puml)

| Étape | Description |
|-------|-------------|
| **Affichage formulaire** | Chargement genres et thèmes disponibles |
| **Validation** | Vérification ISBN unique, données obligatoires |
| **Transaction** | INSERT ressource → INSERT livre → INSERT ressource_genre → INSERT ressource_theme |
| **Rollback** | Annulation complète si une étape échoue |

**Contrôle d'accès :** Bibliothécaire ou Administrateur uniquement (requireStaff)

---

### 6. Component Diagram (Diagramme de composants)

**Fichier :** [06-component-diagram.puml](06-component-diagram.puml)

| Couche | Composants |
|--------|------------|
| **Frontend** | Navigateur, HTML/CSS/JS |
| **Backend** | index.php (Entry Point), Core (Router, Auth, Database), Controllers, Models, Views |
| **Database** | MySQL - Tables ressource, livre, film, utilisateur, evaluation, genre, theme |

**Flux de données :** HTTP Request → Router → Controller → Model → Database → View → HTTP Response

**Patterns :** Singleton (Database), Front Controller (index.php)

---

### 7. Package Diagram (Diagramme de packages)

**Fichier :** [07-package-diagram.puml](07-package-diagram.puml)

| Package | Contenu |
|---------|---------|
| **config/** | config.php, Database.php |
| **core/** | Router.php, Controller.php, Model.php, Auth.php |
| **app/controllers/** | AuthController, CatalogueController, RessourceController, EvaluationController, LivreController, FilmController, GenreController, ThemeController |
| **app/models/** | Utilisateur, Ressource, Livre, Film, Genre, Theme, Evaluation |
| **app/views/** | auth/, catalogue/, ressource/, livre/, film/, genre/, theme/, layouts/header.php, footer.php |
| **public/** | index.php, css/, js/, images/ |
| **sql/** | schema.sql, data.sql |
| **documentation/** | ARCHITECTURE.md, Cahier_des_charges.md, diagrammes/ |

**Dépendances :** Controllers → Models → Database, Controllers → Views, Router → Controllers

---

## Visualisation des diagrammes

### Option 1 : VS Code (recommandé)

| Étape | Action |
|-------|--------|
| 1 | Installer l'extension **PlantUML** |
| 2 | Ouvrir un fichier `.puml` |
| 3 | Appuyer sur **Alt+D** pour prévisualiser |

### Option 2 : PlantUML en ligne

| Étape | Action |
|-------|--------|
| 1 | Aller sur https://www.plantuml.com/plantuml/uml/ |
| 2 | Copier-coller le contenu d'un fichier `.puml` |
| 3 | Le diagramme s'affiche automatiquement |

### Option 3 : Générer des images PNG/SVG

**Installation PlantUML :**

```bash
# macOS
brew install plantuml

# Ubuntu/Debian
sudo apt install plantuml

# Arch Linux
sudo pacman -S plantuml

# Windows
# Télécharger depuis https://plantuml.com/download
```

**Génération des images :**

```bash
cd documentation/diagrammes

# Générer tous les PNG
plantuml *.puml

# Générer des SVG (vectoriel, meilleure qualité)
plantuml -tsvg *.puml

# Fichiers générés :
# 01-use-case.png
# 02-class-diagram.png
# 03-sequence-authentification.png
# 04-sequence-evaluation.png
# 05-sequence-crud-livre.png
# 06-component-diagram.png
# 07-package-diagram.png
```

### Option 4 : Intégration IDE

| IDE | Plugin |
|-----|--------|
| **IntelliJ IDEA / PhpStorm** | Plugin PlantUML intégré, vue en temps réel |
| **Eclipse** | PlantUML Plugin, aperçu dans l'éditeur |
| **NetBeans** | PlantUML NB Plugin |

---

## Convention PlantUML

### Structure standard des fichiers

```plantuml
@startuml Titre du Diagramme

' Configuration visuelle
skinparam ...

title Titre complet du diagramme

' Éléments du diagramme
actor "Acteur" as acteur
usecase "UC1" as uc1
class Classe {}

' Relations
acteur --> uc1

' Notes et commentaires
note right of uc1
  Explication détaillée...
end note

@enduml
```

### Styles utilisés dans le projet

| Élément | Configuration |
|---------|---------------|
| **Acteurs** | `skinparam actorStyle awesome` |
| **Classes** | Attributs privés (-), publics (+), protégés (#) |
| **Séquence** | Numérotation automatique (`autonumber`) |
| **Composants** | `skinparam componentStyle rectangle` |
| **Couleurs** | Palette cohérente pour tous les diagrammes |

---

## Personnalisation

### Thèmes disponibles

Modifier le thème en ajoutant au début du fichier :

```plantuml
!theme bluegray
!theme materia
!theme sketchy-outline
!theme plain
```

Liste complète : https://plantuml.com/theme

### Couleurs personnalisées

```plantuml
skinparam class {
    BackgroundColor LightBlue
    BorderColor Navy
    ArrowColor DarkGray
}

skinparam note {
    BackgroundColor LightYellow
    BorderColor Orange
}
```

---

## Utilisation dans les documents

### Pour Word/PowerPoint

| Étape | Action |
|-------|--------|
| 1 | Générer les PNG : `plantuml *.puml` |
| 2 | Insérer les images dans le document |
| 3 | Utiliser format PNG pour meilleure compatibilité |

### Pour LaTeX

```latex
\documentclass{article}
\usepackage{graphicx}

\begin{document}

\section{Diagramme de cas d'utilisation}
\includegraphics[width=\textwidth]{01-use-case.png}

\section{Diagramme de classes}
\includegraphics[width=\textwidth]{02-class-diagram.png}

\end{document}
```

### Pour Markdown (GitHub, GitLab)

```markdown
## Diagramme de cas d'utilisation

![Use Case Diagram](documentation/diagrammes/01-use-case.png)

## Diagramme de classes

![Class Diagram](documentation/diagrammes/02-class-diagram.png)
```

---

## Mise à jour des diagrammes

### Modifier un diagramme existant

| Étape | Action |
|-------|--------|
| 1 | Éditer le fichier `.puml` |
| 2 | Visualiser les changements (Alt+D dans VS Code) |
| 3 | Régénérer les images si nécessaire |
| 4 | Commiter les changements (.puml ET .png) |

### Ajouter un nouveau diagramme

| Étape | Action |
|-------|--------|
| 1 | Créer `XX-nom-diagramme.puml` (respecter numérotation) |
| 2 | Suivre la convention de nommage |
| 3 | Ajouter à cette liste (README.md) |
| 4 | Générer les images |
| 5 | Commiter tous les fichiers |

---

## Ressources PlantUML

| Type | Lien |
|------|------|
| **Documentation officielle** | https://plantuml.com/ |
| **Use Case Diagram** | https://plantuml.com/use-case-diagram |
| **Class Diagram** | https://plantuml.com/class-diagram |
| **Sequence Diagram** | https://plantuml.com/sequence-diagram |
| **Component Diagram** | https://plantuml.com/component-diagram |
| **Package Diagram** | https://plantuml.com/package-diagram |
| **Deployment Diagram** | https://plantuml.com/deployment-diagram |
| **Exemples réels** | https://real-world-plantuml.com/ |
| **Galerie** | https://plantuml.com/gallery |

---

## Checklist pour la SAE

Diagrammes requis pour le document de spécification :

| Diagramme | Fichier | Statut |
|-----------|---------|--------|
| **Use Case Diagram** | 01-use-case.puml | Fourni |
| **Sequence Diagram (3 scénarios)** | 03, 04, 05 | Fourni |
| **Package Diagram** | 07-package-diagram.puml | Fourni |
| **Component Diagram** | 06-component-diagram.puml | Fourni |
| **Class Diagram** | 02-class-diagram.puml | Fourni |

**Tous les diagrammes requis sont fournis.**

---

## Export pour le rendu

### Générer tous les diagrammes en haute qualité

```bash
cd documentation/diagrammes

# PNG haute résolution (pour Word/PowerPoint)
plantuml -tpng *.puml

# SVG vectoriel (pour documents PDF/Web)
plantuml -tsvg *.puml

# PDF (nécessite Graphviz)
plantuml -tpdf *.puml
```

### Vérifier que tous les diagrammes se génèrent sans erreur

```bash
# Test de génération
plantuml -testdot

# Génération avec verbose pour débogage
plantuml -v *.puml
```

---

## Notes techniques

| Aspect | Détail |
|--------|--------|
| **Format source** | PlantUML (.puml) - texte brut versionnable |
| **Encodage** | UTF-8 pour compatibilité caractères spéciaux |
| **Graphviz** | Requis pour génération PNG/SVG |
| **Java** | PlantUML nécessite Java 8+ |
| **Versioning** | Commiter .puml ET .png pour traçabilité |

---

## Support

| Question | Ressource |
|----------|-----------|
| **Syntaxe PlantUML** | https://plantuml.com/ |
| **Architecture projet** | [ARCHITECTURE.md](../ARCHITECTURE.md) |
| **Spécifications** | [Cahier_des_charges.md](../Cahier_des_charges.md) |
| **Contact équipe** | Voir README principal |

---

**Dernière mise à jour :** 2025-11-23
