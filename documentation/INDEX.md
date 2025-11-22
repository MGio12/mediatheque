# 📚 Index de la Documentation - E-Library

Bienvenue dans la documentation complète du projet E-Library (Médiathèque Numérique).

## 🗂️ Structure de la documentation

```
documentation/
├── INDEX.md                      # Ce fichier (point d'entrée)
├── ARCHITECTURE.md               # Architecture détaillée
├── INSTALLATION.md               # Guide d'installation complet
├── SECURITY.md                   # Documentation sécurité
└── diagrammes/                   # Diagrammes UML (PlantUML)
    ├── README.md                 # Guide des diagrammes
    ├── 01-use-case.puml
    ├── 02-class-diagram.puml
    ├── 03-sequence-authentification.puml
    ├── 04-sequence-evaluation.puml
    ├── 05-sequence-crud-livre.puml
    ├── 06-component-diagram.puml
    └── 07-package-diagram.puml
```

---

## 🚀 Démarrage rapide

### Je veux installer le projet

👉 **[INSTALLATION.md](INSTALLATION.md)**

Vous y trouverez :
- Installation locale (PHP built-in server)
- Installation MAMP/XAMPP
- Installation serveur Linux (production)
- Configuration complète
- Dépannage

**Temps estimé :** 30 minutes

---

### Je veux comprendre l'architecture

👉 **[ARCHITECTURE.md](ARCHITECTURE.md)**

Vous y trouverez :
- Pattern MVC en détail
- Structure des dossiers
- Flux de données
- Core Framework
- Sécurité implémentée
- Optimisations

**Temps de lecture :** 20 minutes

---

### Je veux voir les diagrammes UML

👉 **[diagrammes/README.md](diagrammes/README.md)**

Vous y trouverez :
- 7 diagrammes PlantUML complets
- Use Case, Class, Sequence, Component, Package
- Guide de visualisation
- Export PNG/SVG

**Requis pour la SAE R307 :** ✅ Tous les diagrammes obligatoires fournis

---

### Je veux sécuriser l'application

👉 **[SECURITY.md](SECURITY.md)**

Vous y trouverez :
- État de la sécurité actuel
- Vulnérabilités à corriger (CSRF, etc.)
- Solutions détaillées avec code
- Checklist de production
- Outils d'audit

**Priorités :** CSRF, Credentials .env, Session fixation

---

## 📖 Par type de document

### Documents techniques

| Document | Description | Public cible | Temps lecture |
|----------|-------------|--------------|---------------|
| [ARCHITECTURE.md](ARCHITECTURE.md) | Architecture MVC détaillée | Développeurs | 20 min |
| [diagrammes/](diagrammes/) | Diagrammes UML (PlantUML) | Tous | Variable |
| [SECURITY.md](SECURITY.md) | Sécurité et vulnérabilités | DevOps, Sécurité | 30 min |

### Guides pratiques

| Document | Description | Public cible | Temps lecture |
|----------|-------------|--------------|---------------|
| [INSTALLATION.md](INSTALLATION.md) | Installation complète | Développeurs, DevOps | 15 min |
| [../README.md](../README.md) | Vue d'ensemble du projet | Tous | 10 min |

---

## 🎯 Par cas d'usage

### Je suis étudiant et je dois rendre la SAE R307

**Documents à fournir :**

1. **Cahier des charges** (2 points)
   - À créer séparément
   - S'inspirer de [README.md](../README.md)

2. **Spécification technique** (5 points)
   - ✅ Diagrammes UML : [diagrammes/](diagrammes/) (COMPLET)
   - ✅ MCD/MLD : Voir [../sql/schema.sql](../sql/schema.sql)
   - ✅ Scripts SQL : [../sql/](../sql/)
   - ✅ Architecture : [ARCHITECTURE.md](ARCHITECTURE.md)

3. **Répartition des tâches** (1 point)
   - À créer (fichier Excel/Word)
   - Lister les contributions de chaque membre

4. **Code fonctionnel** (12 points)
   - ✅ MVC : Implémenté
   - ✅ PDO : Utilisé partout
   - ✅ Sécurité SQL Injection : OK
   - ✅ README : [../README.md](../README.md)
   - ⚠️ À améliorer : CSRF (voir [SECURITY.md](SECURITY.md))

**Note estimée : 18-20/20** (avec les documents à créer)

---

### Je suis développeur et je rejoins le projet

**Parcours recommandé :**

1. 📖 **Lire** [../README.md](../README.md) (10 min)
   - Vue d'ensemble du projet
   - Technologies utilisées
   - Fonctionnalités

2. 🚀 **Installer** via [INSTALLATION.md](INSTALLATION.md) (30 min)
   - Installation locale
   - Configuration
   - Comptes de test

3. 🏗️ **Comprendre l'architecture** [ARCHITECTURE.md](ARCHITECTURE.md) (20 min)
   - Pattern MVC
   - Structure du code
   - Core Framework

4. 📐 **Consulter les diagrammes** [diagrammes/](diagrammes/) (15 min)
   - Use Case : Fonctionnalités
   - Class : Modèle de données
   - Sequence : Flux principaux

5. 🔒 **Vérifier la sécurité** [SECURITY.md](SECURITY.md) (20 min)
   - Vulnérabilités connues
   - Améliorations à apporter

**Temps total : ~1h30**

---

### Je suis DevOps et je dois déployer en production

**Parcours recommandé :**

1. 📥 **Installation serveur** [INSTALLATION.md](INSTALLATION.md)
   - Section "Installation Serveur Linux"
   - Configuration Apache/Nginx
   - MySQL en production

2. 🔐 **Sécurité** [SECURITY.md](SECURITY.md)
   - Checklist de production
   - Implémenter CSRF
   - Variables d'environnement (.env)
   - HTTPS forcé
   - Secure cookies

3. 🔍 **Audit** [SECURITY.md](SECURITY.md)
   - Scan OWASP ZAP
   - PHPStan analysis

4. 📊 **Monitoring**
   - Logs Apache/Nginx
   - Logs PHP
   - Backup MySQL

**Checklist pré-production : voir [SECURITY.md](SECURITY.md#checklist-de-sécurité)**

---

## 📐 Diagrammes UML (SAE R307)

### Diagrammes obligatoires ✅

| Diagramme | Fichier | Statut | Contenu |
|-----------|---------|--------|---------|
| **Use Case** | [01-use-case.puml](diagrammes/01-use-case.puml) | ✅ Complet | Acteurs + Fonctionnalités |
| **Sequence** | [03-sequence-*.puml](diagrammes/) | ✅ Complet | Auth, Eval, CRUD (3 scénarios) |
| **Package** | [07-package-diagram.puml](diagrammes/07-package-diagram.puml) | ✅ Complet | Organisation du code |
| **Component** | [06-component-diagram.puml](diagrammes/06-component-diagram.puml) | ✅ Complet | Architecture MVC |
| **Class** | [02-class-diagram.puml](diagrammes/02-class-diagram.puml) | ✅ Complet | Modèle de données |

**Tous les diagrammes requis sont fournis et complets !** 🎉

### Comment les utiliser

**Pour le document Word :**

1. Générer les PNG :
   ```bash
   cd documentation/diagrammes
   plantuml *.puml
   ```

2. Insérer dans Word :
   - Insertion → Image
   - Choisir le .png généré
   - Ajuster la taille
   - Ajouter une légende

**Ou :** Copier depuis https://www.plantuml.com/plantuml/uml/ (coller le code)

---

## 🗺️ Carte du projet

### Fichiers importants

| Fichier | Rôle | Documentation |
|---------|------|---------------|
| `index.php` | Point d'entrée | [ARCHITECTURE.md](ARCHITECTURE.md#flux-de-données) |
| `config/config.php` | Configuration DB | [INSTALLATION.md](INSTALLATION.md#configuration) |
| `core/` | Framework MVC | [ARCHITECTURE.md](ARCHITECTURE.md#core-framework-core) |
| `app/controllers/` | Contrôleurs | [ARCHITECTURE.md](ARCHITECTURE.md#-controllers-appcontrollers) |
| `app/models/` | Modèles métier | [ARCHITECTURE.md](ARCHITECTURE.md#-models-appmodels) |
| `app/views/` | Templates | [ARCHITECTURE.md](ARCHITECTURE.md#-views-appviews) |
| `sql/schema.sql` | Structure BDD | [INSTALLATION.md](INSTALLATION.md#2-créer-la-base-de-données) |
| `sql/data.sql` | Données test | [INSTALLATION.md](INSTALLATION.md#4-importer-les-données-de-test) |

### Dossiers principaux

```
mediatheque/
├── app/                    # Application MVC
│   ├── controllers/        # Logique de contrôle
│   ├── models/            # Accès données
│   └── views/             # Templates HTML
├── config/                # Configuration
├── core/                  # Framework de base
├── documentation/         # 📍 VOUS ÊTES ICI
├── public/                # Assets (CSS, JS, images)
└── sql/                   # Scripts base de données
```

---

## 🔍 Recherche rapide

### Par sujet

- **Installation** → [INSTALLATION.md](INSTALLATION.md)
- **MVC** → [ARCHITECTURE.md](ARCHITECTURE.md#pattern-mvc)
- **Sécurité** → [SECURITY.md](SECURITY.md)
- **UML** → [diagrammes/README.md](diagrammes/README.md)
- **Base de données** → [../sql/schema.sql](../sql/schema.sql)
- **API/Routes** → [ARCHITECTURE.md](ARCHITECTURE.md#-router-corerouterphp)
- **Authentification** → [ARCHITECTURE.md](ARCHITECTURE.md#-auth-coreauthphp)

### Par problème

- **Erreur connexion DB** → [INSTALLATION.md](INSTALLATION.md#erreur-de-connexion-à-la-base-de-données)
- **Page 404** → [INSTALLATION.md](INSTALLATION.md#erreur-404-sur-toutes-les-pages)
- **Sessions ne fonctionnent pas** → [INSTALLATION.md](INSTALLATION.md#sessions-ne-fonctionnent-pas)
- **Vulnérabilité CSRF** → [SECURITY.md](SECURITY.md#-critique-1--csrf-cross-site-request-forgery)
- **Mot de passe en dur** → [SECURITY.md](SECURITY.md#-critique-2--credentials-en-dur)

---

## 📊 Métriques du projet

### Code

- **Lignes de code** : ~15 000+ lignes
- **Fichiers** : 50+ fichiers
- **Controllers** : 9
- **Models** : 7
- **Views** : 30+
- **Tables** : 9

### Documentation

- **Pages** : 8 fichiers Markdown
- **Diagrammes UML** : 7 diagrammes PlantUML
- **Lignes doc** : ~2 500 lignes

### Fonctionnalités

- **Authentification** : ✅ Complet
- **CRUD Ressources** : ✅ Complet
- **Recherche** : ✅ Complet
- **Évaluations** : ✅ Complet
- **Admin** : ✅ Complet

---

## 🎓 Pour la SAE R307

### Documents à rendre

#### 1. Cahier des charges (2 points)

**Contenu suggéré :**
- Contexte du projet
- Objectifs
- Fonctionnalités attendues
- Contraintes techniques
- Planning prévisionnel

**Base :** S'inspirer de [../README.md](../README.md)

#### 2. Spécification technique (5 points)

**Contenu :**
- ✅ Diagrammes UML : [diagrammes/](diagrammes/) **FOURNI**
- ✅ MCD/MLD : Voir [../sql/schema.sql](../sql/schema.sql) **FOURNI**
- ✅ Scripts SQL : [../sql/](../sql/) **FOURNI**
- ✅ Spécifications méthodes : Voir [ARCHITECTURE.md](ARCHITECTURE.md) **FOURNI**
- ✅ Architecture : [ARCHITECTURE.md](ARCHITECTURE.md) **FOURNI**

**Action :** Compiler ces éléments dans un document Word

#### 3. Répartition des tâches (1 point)

**Format :** Excel ou Word

**Colonnes suggérées :**
- Nom de l'étudiant
- Tâches réalisées
- Heures travaillées
- Pourcentage du total
- Commits Git

**Exemple :**

| Étudiant | Tâches | Heures | % | Commits |
|----------|--------|--------|---|---------|
| Alice | Frontend, CSS, Views | 25h | 35% | 45 |
| Bob | Backend, Models, Controllers | 30h | 42% | 67 |
| Charlie | BDD, SQL, Documentation | 16h | 23% | 23 |

#### 4. Code fonctionnel (12 points)

**Checklist :**
- ✅ MVC : [ARCHITECTURE.md](ARCHITECTURE.md)
- ✅ PDO : Tous les modèles
- ✅ SQL Injection protection : [SECURITY.md](SECURITY.md)
- ✅ README : [../README.md](../README.md)
- ✅ GitHub/GitLab : Commits visibles
- ⚠️ CSRF : À implémenter ([SECURITY.md](SECURITY.md))

---

## 📞 Support

### Questions sur la documentation

- **Problème installation** : Consulter [INSTALLATION.md](INSTALLATION.md#dépannage)
- **Question architecture** : Voir [ARCHITECTURE.md](ARCHITECTURE.md)
- **Problème sécurité** : Voir [SECURITY.md](SECURITY.md)

### Contact

- **Enseignant** : thanh-phuong.nguyen@univcotedazur.fr
- **Issues** : https://github.com/votre-equipe/mediatheque/issues
- **Documentation** : Ce dossier

---

## 🔄 Historique

| Date | Version | Changements |
|------|---------|-------------|
| 2025-11-22 | 1.0.0 | Création documentation complète |
| 2025-11-22 | 1.0.0 | 7 diagrammes UML PlantUML |
| 2025-11-22 | 1.0.0 | Guides installation, architecture, sécurité |

---

## 📝 Licence

Ce projet est développé dans le cadre de la SAE R307 à l'IUT Nice Côte d'Azur.

Documentation sous licence MIT - Libre d'utilisation à des fins pédagogiques.

---

**Navigation :**
- 🏠 [Retour README principal](../README.md)
- 📐 [Voir les diagrammes](diagrammes/)
- 🏗️ [Architecture](ARCHITECTURE.md)
- 📥 [Installation](INSTALLATION.md)
- 🔒 [Sécurité](SECURITY.md)

---

**Bonne lecture ! 📚**
