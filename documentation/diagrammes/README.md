# 📐 Diagrammes UML - E-Library

Ce dossier contient tous les diagrammes UML du projet au format PlantUML (.puml).

## 📋 Liste des diagrammes

### 1. Use Case Diagram (Cas d'utilisation)
**Fichier :** [`01-use-case.puml`](01-use-case.puml)

**Contenu :**
- Acteurs : Visiteur, Utilisateur, Bibliothécaire, Administrateur
- Front Office : Catalogue, Recherche, Nouveautés, Top, Sélection
- Back Office : Gestion livres/films/genres/thèmes
- Relations d'héritage entre acteurs
- Relations include/extend

**Vue d'ensemble :** Présente toutes les fonctionnalités accessibles selon le rôle.

---

### 2. Class Diagram (Diagramme de classes)
**Fichier :** [`02-class-diagram.puml`](02-class-diagram.puml)

**Contenu :**
- Classes métier : Utilisateur, Ressource (abstraite), Livre, Film, Genre, Theme, Evaluation
- Classes techniques : Auth, Database, Controller, Model
- Attributs et méthodes principales
- Relations : héritage, association, agrégation
- Contraintes et notes

**Pattern :** Active Record + MVC

---

### 3. Sequence Diagram - Authentification
**Fichier :** [`03-sequence-authentification.puml`](03-sequence-authentification.puml)

**Contenu :**
- Flux d'inscription utilisateur
- Flux de connexion (login)
- Flux de déconnexion (logout)
- Interactions : Router → Controller → Model → Database
- Validation et gestion d'erreurs
- Note sur la vulnérabilité session fixation

**Cas couverts :** Register, Login, Logout

---

### 4. Sequence Diagram - Évaluation
**Fichier :** [`04-sequence-evaluation.puml`](04-sequence-evaluation.puml)

**Contenu :**
- Affichage d'une page ressource avec évaluations
- Soumission d'une nouvelle évaluation
- Vérification : utilisateur déjà évalué ?
- Transaction database
- Note sur la vulnérabilité CSRF

**Cas couverts :** Affichage ressource, Créer évaluation

---

### 5. Sequence Diagram - CRUD Livre
**Fichier :** [`05-sequence-crud-livre.puml`](05-sequence-crud-livre.puml)

**Contenu :**
- Affichage du formulaire de création
- Soumission et validation
- Création en transaction :
  - INSERT ressource
  - INSERT livre
  - INSERT ressource_genre (multiples)
  - INSERT ressource_theme (multiples)
- Contrôle d'accès (requireStaff)
- Rollback si erreur

**Cas couverts :** Create (le CRUD complet est similaire)

---

### 6. Component Diagram (Diagramme de composants)
**Fichier :** [`06-component-diagram.puml`](06-component-diagram.puml)

**Contenu :**
- Frontend : Navigateur, HTML/CSS/JS
- Backend : Entry Point, Core Framework, Controllers, Models, Views
- Database : MySQL avec tables
- Flux de données entre composants
- Notes sur les patterns (Singleton, Front Controller)

**Architecture :** MVC en couches

---

### 7. Package Diagram (Diagramme de packages)
**Fichier :** [`07-package-diagram.puml`](07-package-diagram.puml)

**Contenu :**
- Organisation complète du code source
- Dossiers : config, core, app, public, sql, documentation
- Sous-packages : controllers, models, views (avec structure détaillée)
- Dépendances entre packages
- Fichiers clés dans chaque package

**Vue d'ensemble :** Structure physique du projet

---

## 🖼️ Comment visualiser les diagrammes

### Option 1 : VS Code (recommandé)

1. Installer l'extension **PlantUML**
2. Ouvrir un fichier `.puml`
3. Appuyer sur **Alt+D** pour prévisualiser

### Option 2 : PlantUML en ligne

1. Aller sur https://www.plantuml.com/plantuml/uml/
2. Copier-coller le contenu d'un fichier `.puml`
3. Le diagramme s'affiche automatiquement

### Option 3 : Générer des images PNG/SVG

**Installer PlantUML :**

```bash
# macOS
brew install plantuml

# Ubuntu/Debian
sudo apt install plantuml

# Windows
# Télécharger depuis https://plantuml.com/download
```

**Générer les images :**

```bash
cd documentation/diagrammes

# Générer tous les PNG
plantuml *.puml

# Générer des SVG (vectoriel)
plantuml -tsvg *.puml

# Fichiers générés :
# 01-use-case.png
# 02-class-diagram.png
# etc.
```

### Option 4 : Intégration IDE

**IntelliJ IDEA / PhpStorm :**
- Plugin PlantUML intégré
- Vue en temps réel

**Eclipse :**
- Installer PlantUML Plugin
- Aperçu dans l'éditeur

---

## 📝 Convention PlantUML

### Structure des fichiers

```plantuml
@startuml Titre du Diagramme

' Configuration
skinparam ...

title Titre complet

' Éléments du diagramme
actor "Acteur" as acteur
usecase "UC1" as uc1
class Classe {}

' Relations
acteur --> uc1

' Notes
note right of uc1
  Explication...
end note

@enduml
```

### Styles utilisés

- **Acteurs** : `skinparam actorStyle awesome`
- **Classes** : Attributs privés (-), publics (+), protégés (#)
- **Séquence** : Numérotation automatique (`autonumber`)
- **Composants** : `skinparam componentStyle rectangle`

---

## 🎨 Personnalisation

### Thèmes disponibles

Vous pouvez changer le thème en ajoutant au début :

```plantuml
!theme bluegray
!theme materia
!theme sketchy-outline
```

Voir tous les thèmes : https://plantuml.com/theme

### Couleurs personnalisées

```plantuml
skinparam class {
    BackgroundColor LightBlue
    BorderColor Navy
}
```

---

## 📊 Utilisation dans les documents

### Pour Word/PowerPoint

1. Générer les PNG : `plantuml *.puml`
2. Insérer les images dans le document

### Pour LaTeX

```latex
\documentclass{article}
\usepackage{graphicx}

\begin{document}
\includegraphics[width=\textwidth]{01-use-case.png}
\end{document}
```

### Pour Markdown (GitHub, GitLab)

```markdown
![Use Case Diagram](diagrammes/01-use-case.png)
```

---

## 🔄 Mise à jour

### Modifier un diagramme

1. Éditer le fichier `.puml`
2. Visualiser les changements (Alt+D dans VS Code)
3. Régénérer les images si nécessaire
4. Commiter les changements

### Ajouter un nouveau diagramme

1. Créer `XX-nom-diagramme.puml`
2. Suivre la convention de nommage
3. Ajouter à cette liste (README.md)
4. Générer les images

---

## 📚 Ressources PlantUML

- **Documentation officielle** : https://plantuml.com/
- **Use Case** : https://plantuml.com/use-case-diagram
- **Class** : https://plantuml.com/class-diagram
- **Sequence** : https://plantuml.com/sequence-diagram
- **Component** : https://plantuml.com/component-diagram
- **Deployment** : https://plantuml.com/deployment-diagram
- **Exemples** : https://real-world-plantuml.com/

---

## ✅ Checklist pour la SAE

Pour le document de spécification, vous devez fournir **AU MINIMUM** :

- [x] **Use Case Diagram** → `01-use-case.puml` ✅
- [x] **Sequence Diagram** → `03, 04, 05` ✅ (3 scénarios)
- [x] **Package Diagram** → `07-package-diagram.puml` ✅
- [x] **Component Diagram** → `06-component-diagram.puml` ✅
- [x] **Class Diagram** → `02-class-diagram.puml` ✅

**Tous les diagrammes requis sont fournis !** 🎉

---

## 📞 Support

Si vous avez des questions sur les diagrammes :
- Consulter la [documentation PlantUML](https://plantuml.com/)
- Voir [ARCHITECTURE.md](../ARCHITECTURE.md) pour plus de contexte
- Contacter l'équipe de développement

---

**Dernière mise à jour :** 2025-11-22
