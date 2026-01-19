# CAHIER DES CHARGES
## Médiathèque Numérique (E-Library)

**SAE R307 - Année 2025/2026**

---

## INFORMATIONS GÉNÉRALES

**Projet** : E-Library - Médiathèque Numérique
**Date de rédaction** : Janvier 2025
**Version** : 2.0
**Équipe** : Giovanelli Maxime
**Encadrant** : M. NGUYEN Thanh Phuong
**Institution** : IUT Nice Côte d'Azur

---

## 1. CONTEXTE ET ENJEUX

### 1.1 Présentation du projet

Dans un contexte de transformation numérique des services culturels, les médiathèques doivent moderniser leur offre pour répondre aux attentes des usagers. E-Library est une plateforme web de médiathèque numérique qui permet aux utilisateurs de **découvrir**, **consulter** et **évaluer** des ressources culturelles (livres et films).

Ce projet s'inscrit dans le cadre de la SAE R307 et s'inspire de plateformes existantes telles que https://vod.mediatheque-numerique.com, avec l'ambition d'offrir une expérience utilisateur moderne et intuitive.

### 1.2 Problématique métier

**Constat** : Les usagers des médiathèques souhaitent :
- Accéder facilement à un catalogue de ressources culturelles depuis n'importe quel appareil
- Découvrir de nouvelles oeuvres correspondant à leurs goûts
- Partager leurs avis et consulter ceux de la communauté
- Bénéficier d'une navigation fluide et d'une recherche efficace

**Besoin du personnel** : Les bibliothécaires et administrateurs ont besoin :
- D'outils simples pour enrichir et maintenir le catalogue
- D'une vision claire de l'activité et des ressources populaires
- De pouvoir modérer les contenus utilisateurs si nécessaire

### 1.3 Objectifs du projet

| Objectif | Description |
|----------|-------------|
| **Faciliter l'accès à la culture** | Permettre à tout utilisateur de consulter le catalogue depuis un ordinateur, une tablette ou un smartphone |
| **Favoriser la découverte** | Mettre en avant les nouveautés et les ressources plébiscitées par la communauté |
| **Encourager le partage d'avis** | Offrir aux utilisateurs la possibilité d'évaluer et de commenter les ressources |
| **Simplifier la gestion** | Fournir au personnel des outils intuitifs pour gérer le catalogue |
| **Garantir la fiabilité** | Assurer la sécurité des données et la disponibilité du service |

### 1.4 Périmètre du projet

**Inclus dans le projet** :
- Application web accessible sur tous les appareils (responsive)
- Gestion complète des ressources culturelles (livres et films)
- Système d'inscription et de connexion sécurisé
- Système d'évaluation et de notation par les utilisateurs
- Recherche multicritère avancée
- Interface d'administration pour le personnel

**Hors périmètre** :
- Application mobile native (iOS/Android)
- Système d'emprunt ou de réservation physique
- Paiement en ligne ou abonnement
- Lecture/streaming de contenu en ligne
- Messagerie ou chat avec les bibliothécaires
- Système de recommandations automatiques

---

## 2. SCÉNARIOS D'USAGE

Cette section présente les usages concrets du système du point de vue des différents utilisateurs.

### 2.1 Scénarios utilisateur (grand public)

**Scénario 1 : Découvrir les nouveautés**
> Marie, passionnée de lecture, ouvre la plateforme depuis son téléphone pendant sa pause déjeuner. Elle souhaite voir ce qui est nouveau. Dès la page d'accueil, elle aperçoit les dernières ressources ajoutées et repère un roman qui l'intéresse. En un clic, elle accède à sa fiche détaillée.

**Scénario 2 : Rechercher un film précis**
> Thomas se souvient d'un film de science-fiction vu il y a quelques années. Il utilise la recherche avancée, sélectionne le genre "Science-fiction" et indique une plage d'années approximative. Il retrouve rapidement le film et consulte les avis des autres utilisateurs.

**Scénario 3 : Partager son avis**
> Après avoir lu un livre recommandé par la plateforme, Sophie souhaite donner son avis. Elle se connecte, accède à la fiche du livre, attribue 4 étoiles et rédige une courte critique. Son avis sera visible par les autres utilisateurs.

**Scénario 4 : Explorer par thématique**
> Paul s'intéresse aux oeuvres traitant du thème de la liberté. Il navigue vers la section "Sélections" et choisit ce thème. Il découvre une liste de livres et films qui abordent ce sujet sous différents angles.

### 2.2 Scénarios bibliothécaire

**Scénario 5 : Enrichir le catalogue**
> La bibliothécaire Mme Dupont reçoit de nouveaux ouvrages. Elle se connecte à l'interface d'administration, crée les fiches correspondantes en renseignant les informations (titre, auteur, résumé, etc.) et les associe aux genres et thèmes appropriés. Les nouveautés apparaissent immédiatement sur la page d'accueil.

**Scénario 6 : Corriger une fiche**
> Un utilisateur signale une erreur sur la date de publication d'un film. Le bibliothécaire accède à la fiche, corrige l'information et enregistre. La modification est instantanément visible.

**Scénario 7 : Consulter les statistiques**
> En fin de mois, M. Martin consulte le tableau de bord pour voir les ressources les plus consultées et les mieux notées. Cela lui permet d'orienter ses prochains achats.

### 2.3 Scénarios administrateur

**Scénario 8 : Gérer les référentiels**
> L'administratrice souhaite ajouter un nouveau genre "Thriller psychologique" pour mieux catégoriser certains films. Elle accède à la gestion des genres, crée l'entrée, et peut désormais l'associer aux ressources concernées.

**Scénario 9 : Modérer un avis inapproprié**
> Un utilisateur a publié un commentaire offensant. L'administrateur, alerté, supprime l'évaluation concernée pour maintenir un environnement respectueux.

### 2.4 Objectifs utilisateurs

| Profil | Objectifs principaux |
|--------|---------------------|
| **Utilisateur** | Trouver rapidement une ressource - Découvrir de nouvelles oeuvres - Partager et consulter des avis - Naviguer simplement |
| **Bibliothécaire** | Gérer le catalogue de manière autonome - Maintenir des informations à jour - Suivre l'activité de la plateforme |
| **Administrateur** | Assurer la cohérence des données - Modérer les contenus - Administrer les référentiels |

---

## 3. ACTEURS DU SYSTÈME

### 3.1 Présentation des acteurs

**Visiteur (non connecté)**
Toute personne accédant au site sans être authentifiée. Il peut consulter le catalogue et effectuer des recherches, mais ne peut pas évaluer les ressources.

**Utilisateur inscrit**
Personne disposant d'un compte sur la plateforme. En plus des fonctionnalités du visiteur, il peut noter et commenter les ressources qu'il a consultées.

**Bibliothécaire**
Membre du personnel de la médiathèque. Il dispose de toutes les fonctionnalités utilisateur, plus la capacité de gérer le catalogue (ajout, modification, suppression de ressources).

**Administrateur**
Responsable technique et fonctionnel de la plateforme. Il dispose de toutes les fonctionnalités bibliothécaire, plus la gestion des référentiels (genres, thèmes) et la modération des évaluations.

### 3.2 Matrice des droits

| Fonctionnalité | Visiteur | Utilisateur | Bibliothécaire | Administrateur |
|----------------|----------|-------------|----------------|----------------|
| **Navigation et consultation** |
| Consulter le catalogue | Oui | Oui | Oui | Oui |
| Voir les nouveautés et top | Oui | Oui | Oui | Oui |
| Rechercher des ressources | Oui | Oui | Oui | Oui |
| Voir les fiches détaillées | Oui | Oui | Oui | Oui |
| Lire les évaluations | Oui | Oui | Oui | Oui |
| **Participation** |
| Créer un compte | Oui | - | - | - |
| Évaluer une ressource | - | Oui | Oui | Oui |
| Rédiger une critique | - | Oui | Oui | Oui |
| **Gestion du catalogue** |
| Ajouter une ressource | - | - | Oui | Oui |
| Modifier une ressource | - | - | Oui | Oui |
| Supprimer une ressource | - | - | Oui | Oui |
| Consulter le tableau de bord | - | - | Oui | Oui |
| **Administration** |
| Gérer les genres | - | - | - | Oui |
| Gérer les thèmes | - | - | - | Oui |
| Supprimer des évaluations | - | - | - | Oui |

---

## 4. EXPRESSION DES BESOINS FONCTIONNELS

### 4.1 Gestion des comptes utilisateurs

**Inscription**
- L'utilisateur peut créer un compte en fournissant : nom, prénom, adresse email et mot de passe
- L'adresse email doit être unique (un seul compte par email)
- Le mot de passe doit comporter au minimum 8 caractères
- Un message de confirmation informe l'utilisateur du succès de l'inscription

**Connexion et déconnexion**
- L'utilisateur se connecte avec son email et son mot de passe
- La session reste active jusqu'à déconnexion explicite ou fermeture du navigateur
- Des messages d'erreur clairs guident l'utilisateur en cas de problème

### 4.2 Consultation du catalogue

**Page d'accueil**
- Présentation des 8 dernières ressources ajoutées (section "Nouveautés")
- Présentation des 8 ressources les mieux notées (section "Top")
- Affichage des 5 derniers avis de la communauté
- Accès rapide aux différentes sections du site

**Catalogue complet**
- Liste de toutes les ressources disponibles
- Affichage de la note moyenne et du nombre d'évaluations pour chaque ressource
- Identification visuelle du type de ressource (livre ou film)

**Nouveautés**
- Liste des 20 dernières ressources ajoutées
- Classement par date d'ajout (les plus récentes en premier)

**Top des meilleures notes**
- Liste des 20 ressources les mieux notées
- Seules les ressources ayant reçu au moins une évaluation apparaissent
- Classement par note moyenne décroissante

**Sélections thématiques**
- Possibilité de filtrer les ressources par thème
- Présentation des ressources associées au thème choisi

### 4.3 Recherche de ressources

**Recherche multicritère**
L'utilisateur peut rechercher des ressources selon plusieurs critères combinables :
- **Mot-clé** : recherche dans le titre, l'auteur/réalisateur et le résumé
- **Type** : filtrer par livre ou film
- **Genre** : sélection parmi la liste des genres disponibles
- **Thème** : sélection parmi la liste des thèmes disponibles
- **Période** : définir une plage d'années (année minimale et/ou maximale)

Les résultats affichent les informations essentielles et la note moyenne de chaque ressource.

### 4.4 Fiches ressources détaillées

**Informations communes à toutes les ressources**
- Titre
- Auteur (livre) ou Réalisateur (film)
- Année de publication/sortie
- Pays d'origine
- Résumé
- Image de couverture
- Genres associés
- Thèmes associés
- Note moyenne (de 0 à 5 étoiles)
- Nombre d'évaluations

**Informations spécifiques aux livres**
- ISBN
- Éditeur
- Nombre de pages
- Langue
- Prix indicatif

**Informations spécifiques aux films**
- Durée
- Support disponible (DVD, Blu-ray, Streaming)
- Langue originale
- Sous-titres disponibles
- Distributeur/Proposé par
- Casting principal

**Section évaluations**
- Liste des avis des utilisateurs avec leur note, critique et date
- Affichage chronologique (plus récents en premier)
- Formulaire d'évaluation pour les utilisateurs connectés

### 4.5 Système d'évaluation

**Évaluer une ressource**
- L'utilisateur connecté peut attribuer une note de 0 à 5 étoiles
- Il peut accompagner sa note d'une critique textuelle (facultatif, maximum 1000 caractères)
- Chaque utilisateur ne peut évaluer qu'une seule fois chaque ressource
- L'évaluation est définitive après soumission

**Affichage des évaluations**
- Note moyenne calculée automatiquement à partir de toutes les évaluations
- Nombre total d'évaluations affiché
- Liste des critiques avec le nom de l'évaluateur et la date

### 4.6 Gestion du catalogue (bibliothécaires)

**Gestion des livres**
- Ajouter un nouveau livre avec toutes ses informations
- Modifier les informations d'un livre existant
- Supprimer un livre du catalogue
- Associer ou dissocier des genres et thèmes

**Gestion des films**
- Ajouter un nouveau film avec toutes ses informations
- Modifier les informations d'un film existant
- Supprimer un film du catalogue
- Associer ou dissocier des genres et thèmes

**Tableau de bord**
- Vue d'ensemble du catalogue : nombre total de ressources, de livres, de films
- Nombre total d'évaluations
- Top 5 des ressources les mieux notées
- Liste des 10 dernières évaluations

### 4.7 Administration (administrateurs)

**Gestion des référentiels**
- Créer, modifier et supprimer des genres
- Créer, modifier et supprimer des thèmes
- Les noms de genres et thèmes doivent être uniques

**Modération**
- Possibilité de supprimer des évaluations inappropriées
- Cette action est irréversible

---

## 5. EXIGENCES NON FONCTIONNELLES

### 5.1 Ergonomie et expérience utilisateur

| Exigence | Description |
|----------|-------------|
| **Accessibilité multi-supports** | Le site doit être consultable confortablement sur ordinateur, tablette et smartphone |
| **Navigation intuitive** | L'utilisateur doit pouvoir accéder à n'importe quelle section en 3 clics maximum |
| **Retour d'information** | Chaque action de l'utilisateur doit être confirmée par un message clair (succès ou erreur) |
| **Gestion des cas limites** | Affichage de messages adaptés lorsque le catalogue est vide ou qu'une recherche ne donne aucun résultat |
| **Confort visuel** | Interface moderne avec possibilité de basculer entre mode clair et mode sombre |

### 5.2 Performance

| Exigence | Description |
|----------|-------------|
| **Temps de réponse** | Les pages doivent s'afficher en moins de 2 secondes |
| **Recherche efficace** | Les résultats de recherche doivent s'afficher rapidement même sur un catalogue volumineux |
| **Fluidité** | La navigation entre les pages doit être fluide et sans latence perceptible |

### 5.3 Sécurité

| Exigence | Description |
|----------|-------------|
| **Protection des comptes** | Les mots de passe doivent être stockés de manière sécurisée (non lisibles) |
| **Protection des données** | Les données personnelles des utilisateurs doivent être protégées |
| **Contrôle d'accès** | Seuls les utilisateurs autorisés peuvent accéder aux fonctions d'administration |
| **Intégrité des données** | Les données saisies doivent être vérifiées avant enregistrement |
| **Protection contre les attaques** | Le système doit être protégé contre les attaques web courantes |

### 5.4 Fiabilité

| Exigence | Description |
|----------|-------------|
| **Cohérence des données** | Les informations affichées doivent toujours être à jour |
| **Pas de perte de données** | Les actions de l'utilisateur (évaluations, modifications) ne doivent pas être perdues |
| **Gestion des erreurs** | En cas de problème, l'utilisateur doit recevoir un message explicatif |

### 5.5 Compatibilité

| Exigence | Description |
|----------|-------------|
| **Navigateurs** | Le site doit fonctionner sur les navigateurs modernes (Chrome, Firefox, Safari, Edge) |
| **Pas de plugin requis** | L'utilisation du site ne doit nécessiter aucune installation de logiciel supplémentaire |

---

## 6. DONNÉES GÉRÉES

### 6.1 Données utilisateur

- Informations du compte : nom, prénom, email, rôle
- Historique des évaluations publiées

### 6.2 Données ressources

**Ressource (informations communes)**
- Type (livre ou film)
- Titre
- Auteur ou réalisateur
- Année
- Pays
- Résumé
- Image de couverture
- Date d'ajout au catalogue

**Livre (informations spécifiques)**
- ISBN (identifiant unique)
- Éditeur
- Nombre de pages
- Langue
- Prix

**Film (informations spécifiques)**
- Durée
- Support
- Langue
- Sous-titres
- Distributeur
- Casting

### 6.3 Données d'évaluation

- Note attribuée (0 à 5)
- Critique textuelle (optionnelle)
- Date de publication
- Référence à l'utilisateur et à la ressource concernée

### 6.4 Données de référentiel

- Liste des genres (ex : Science-fiction, Drame, Comédie...)
- Liste des thèmes (ex : Liberté, Amour, Aventure...)
- Associations entre ressources et genres/thèmes

### 6.5 Règles de gestion des données

| Règle | Description |
|-------|-------------|
| RG1 | Un email ne peut être associé qu'à un seul compte utilisateur |
| RG2 | Un ISBN identifie de manière unique un livre |
| RG3 | Un utilisateur ne peut publier qu'une seule évaluation par ressource |
| RG4 | La suppression d'une ressource entraîne la suppression de ses évaluations |
| RG5 | Les noms de genres et de thèmes doivent être uniques |
| RG6 | Une ressource peut être associée à plusieurs genres et plusieurs thèmes |

---

## 7. CONTRAINTES DU PROJET

### 7.1 Contraintes pédagogiques

Ce projet s'inscrit dans le cadre de la SAE R307. À ce titre, certaines contraintes sont imposées :

- **Architecture** : L'application doit suivre le patron de conception MVC (Modèle-Vue-Contrôleur)
- **Programmation** : Utilisation de PHP en programmation orientée objet
- **Base de données** : Utilisation de MySQL avec accès sécurisé
- **Sécurité** : Protection obligatoire contre les failles de sécurité courantes
- **Versionnement** : Utilisation de Git avec un historique traçable des contributions

### 7.2 Contraintes temporelles

| Phase | Contenu | Durée indicative |
|-------|---------|------------------|
| Analyse et conception | Cahier des charges, modélisation | Semaines 1-2 |
| Développement interface | Maquettes, intégration HTML/CSS | Semaines 2-4 |
| Développement fonctionnalités | Logique métier, base de données | Semaines 3-6 |
| Tests et corrections | Validation, corrections de bugs | Semaine 7 |
| Finalisation | Documentation, préparation livraison | Semaine 8 |

**Charge de travail estimée** : 40 heures par étudiant (15h interface + 25h fonctionnalités)

### 7.3 Contraintes de livraison

**Documents à remettre** :
- Cahier des charges (ce document)
- Spécifications techniques avec diagrammes de conception
- Document de répartition des tâches

**Code source** :
- Dépôt accessible (Git)
- Code fonctionnel et testable
- Documentation d'installation (README)

---

## 8. CRITÈRES D'ACCEPTATION

### 8.1 Fonctionnalités essentielles

| Fonctionnalité | Critère d'acceptation |
|----------------|----------------------|
| Inscription | Un visiteur peut créer un compte et se connecter ensuite |
| Connexion | Un utilisateur peut se connecter avec ses identifiants |
| Catalogue | Toutes les ressources sont visibles et consultables |
| Nouveautés | Les 20 dernières ressources ajoutées sont affichées dans le bon ordre |
| Top | Les ressources sont classées par note moyenne décroissante |
| Recherche | La recherche multicritère retourne des résultats pertinents |
| Fiche ressource | Toutes les informations sont affichées correctement |
| Évaluation | Un utilisateur connecté peut noter et commenter une ressource |
| Unicité évaluation | Un utilisateur ne peut pas évaluer deux fois la même ressource |
| Gestion ressources | Un bibliothécaire peut ajouter, modifier et supprimer des ressources |
| Gestion référentiels | Un administrateur peut gérer les genres et thèmes |
| Modération | Un administrateur peut supprimer une évaluation |

### 8.2 Qualité attendue

| Critère | Niveau attendu |
|---------|----------------|
| **Fonctionnement** | Toutes les fonctionnalités doivent être opérationnelles |
| **Ergonomie** | L'interface doit être intuitive et agréable |
| **Responsive** | Le site doit être utilisable sur mobile et desktop |
| **Sécurité** | Aucune faille de sécurité évidente |
| **Performance** | Temps de réponse acceptable |
| **Documentation** | Instructions d'installation claires et fonctionnelles |

---

## 9. RISQUES IDENTIFIÉS

| Risque | Impact | Mesure préventive |
|--------|--------|-------------------|
| Retard dans le développement | Livraison incomplète | Prioriser les fonctionnalités essentielles |
| Problèmes de sécurité | Données compromises | Appliquer les bonnes pratiques dès le début |
| Interface peu ergonomique | Mauvaise expérience utilisateur | Tester régulièrement avec des utilisateurs |
| Bugs en démonstration | Mauvaise évaluation | Prévoir une phase de test complète |
| Données incohérentes | Dysfonctionnements | Valider les données à l'entrée |

---

## 10. GLOSSAIRE

| Terme | Définition |
|-------|------------|
| **Catalogue** | Ensemble des ressources (livres et films) disponibles sur la plateforme |
| **Ressource** | Élément culturel (livre ou film) référencé dans le catalogue |
| **Évaluation** | Avis laissé par un utilisateur, composé d'une note et éventuellement d'une critique |
| **Genre** | Catégorie stylistique d'une oeuvre (ex : Science-fiction, Drame, Comédie) |
| **Thème** | Sujet ou idée abordé par une oeuvre (ex : Liberté, Amour, Guerre) |
| **Référentiel** | Liste de valeurs prédéfinies (genres, thèmes) utilisées pour catégoriser les ressources |
| **Responsive** | Capacité d'un site web à s'adapter à la taille de l'écran |
| **Dashboard** | Tableau de bord présentant des indicateurs et statistiques |
| **MVC** | Modèle-Vue-Contrôleur, patron d'architecture logicielle |
| **CRUD** | Create, Read, Update, Delete - les quatre opérations de base sur les données |

---

## 11. ANNEXES

### Annexe A : Comptes de test

Pour faciliter l'évaluation, des comptes de test seront créés :

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | admin@mediatheque.com | password123 |
| Bibliothécaire | biblio@mediatheque.com | password123 |
| Utilisateur | user@mediatheque.com | password123 |

### Annexe B : Données de démonstration

Le catalogue de démonstration contiendra :
- **Livres** : Dune, 1984, Le Petit Prince, Les Misérables, Sapiens
- **Films** : Inception, Le Parrain, Interstellar, Le Roi Lion, Matrix
- **Genres** : Science-fiction, Drame, Action, Aventure, Fantastique, Thriller, Comédie, Animation, Policier, Historique
- **Thèmes** : Pouvoir, Famille, Amour, Liberté, Guerre, Identité, Technologie, Survie, Amitié, Trahison

### Annexe C : Checklist de livraison

| Élément | À vérifier |
|---------|------------|
| **Documents** |
| Cahier des charges | Complet et relu |
| Spécifications techniques | Diagrammes inclus |
| Répartition des tâches | Contributions détaillées |
| **Application** |
| Inscription/Connexion | Fonctionnel |
| Catalogue et navigation | Fonctionnel |
| Recherche | Fonctionnel |
| Évaluation | Fonctionnel |
| Gestion catalogue | Fonctionnel |
| Gestion référentiels | Fonctionnel |
| **Qualité** |
| Responsive design | Testé sur mobile |
| Sécurité | Protections en place |
| Documentation | README complet |
| Code versionné | Historique Git propre |

---

## VALIDATION

**Date de validation** : _____________________

**Membres de l'équipe** :

| Nom et Prénom | Rôle | Signature |
|---------------|------|-----------|
| | | |
| | | |
| | | |

**Engagement** :
Nous nous engageons à respecter les spécifications décrites dans ce cahier des charges et à livrer une application conforme aux exigences dans les délais impartis.

---

**Document rédigé dans le cadre de la SAE R307**
**IUT Nice Côte d'Azur - 2025/2026**

---

*Fin du document - Cahier des charges E-Library v2.0*
