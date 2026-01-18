# E-LIBRARY - SAE R307 (2025/2026)

## Presentation
E-Library est un site web permettant de gerer les ressources (livres, DVD, etc.) d'une mediatheque. Ce projet respecte une architecture MVC en PHP Objet avec une base de donnees MySQL via PDO.

## Installation
1. Cloner le depot : git clone https://github.com/MGio12/mediatheque.git
2. Configuration de la base de donnees :
   - Creer une base de donnees nommee mediatheque.
   - Importer le schema SQL situe dans le dossier sql/.
3. Configuration PHP :
   - Modifier le fichier config/config.php avec vos identifiants de connexion PDO.
4. Lancement :
   - Pointer votre serveur local (Apache/WAMP/XAMPP) sur le dossier racine du projet.

## Comptes de Test
Trois types d'utilisateurs sont configures pour tester les niveaux d'acces :

| Role | Email | Mot de passe | Permissions |
| :--- | :--- | :--- | :--- |
| Administrateur | admin@mediatheque.com | password123 | Gestion complete des ressources + Suppression des avis. |
| Bibliothecaire | biblio@mediatheque.com | password123 | Gestion complete des ressources (Livres/Films). |
| Utilisateur | user@mediatheque.com | password123 | Consultation, recherche et notation. |

## Fonctionnalites Principales
- Catalogue : Organisation des ressources en catalogue.
- Nouveautes : Presentation des 8 dernieres ressources ajoutees sur l'accueil.
- Top : Presentation des 8 ressources les mieux notees sur l'accueil.
- Recherche : Outil de recherche multicritere.
- Evaluation : Systeme de notation et de critiques par les utilisateurs.
- Moderation : La seule difference de pouvoir entre l'Administrateur et le Bibliothecaire est que l'Administrateur peut supprimer les avis/commentaires.

## Technologies Utilisees
- Back end : PHP Objet, MySQL (PDO).
- Front end : JS, CSS, HTML.
- Securite : Requetes preparees PDO contre les injections SQL et protection XSS.

## Documents de Rendu
Les documents obligatoires suivants sont disponibles dans le depot :
1. Cahier des charges detaille.
2. Specification du systeme (Diagrammes UML : Cas d'utilisation, Sequence, Classes, etc.).
3. Conception de la base de donnees (MCD, MLD et script SQL).
4. Document de repartition des taches et temps de travail personnel.

---
Projet realise dans le cadre de la SAE R307 
IUT Nice Cote d'Azur.