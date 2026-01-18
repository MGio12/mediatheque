-- ============================================
-- Données de test pour Médiathèque (SAE R307)
-- Inclut les nouveaux champs : prix, pays, sous_titres
-- ============================================

SET FOREIGN_KEY_CHECKS = 0;

-- Mise à jour de la structure (au cas où)
-- On utilise IGNORE ou des procédures stockées pour éviter les erreurs si les colonnes existent déjà,
-- mais ici on va faire simple pour PHPMyAdmin qui gère souvent ça ou on suppose que ça manque.
-- Note: Sur MySQL pur, ALTER TABLE IF NOT EXISTS n'existe pas toujours nativement pour les colonnes de cette façon simple.
-- On va faire les ALTER qui échoueront si la colonne existe, mais c'est mieux que rien.
-- Pour être sûr, le mieux est de lancer ces commandes manuellement si elles échouent ici.


TRUNCATE TABLE evaluation;
TRUNCATE TABLE ressource_genre;
TRUNCATE TABLE ressource_theme;
TRUNCATE TABLE film;
TRUNCATE TABLE livre;
TRUNCATE TABLE ressource;
TRUNCATE TABLE genre;
TRUNCATE TABLE theme;
TRUNCATE TABLE utilisateur;

SET FOREIGN_KEY_CHECKS = 1;

-- 1. Utilisateurs
-- Mot de passe pour tous : "password123" ($2y$12$...)
INSERT INTO utilisateur (id_utilisateur, nom, prenom, email, mot_de_passe, role) VALUES
(1, 'Admin', 'System', 'admin@mediatheque.com', '$2y$12$xEP8ydYuuO8vBjyh3r9kduyiFE2f.32RhM49WOfu7U.fFYGBF59nq', 'administrateur'),
(2, 'Biblio', 'Thecaire', 'biblio@mediatheque.com', '$2y$12$xEP8ydYuuO8vBjyh3r9kduyiFE2f.32RhM49WOfu7U.fFYGBF59nq', 'bibliothecaire'),
(3, 'Doe', 'John', 'user@mediatheque.com', '$2y$12$xEP8ydYuuO8vBjyh3r9kduyiFE2f.32RhM49WOfu7U.fFYGBF59nq', 'utilisateur');

-- 2. Thèmes (de quoi ça parle - les idées abordées)
INSERT INTO theme (id_theme, nom) VALUES
(1, 'Pouvoir'),
(2, 'Famille'),
(3, 'Amour'),
(4, 'Liberté'),
(5, 'Guerre'),
(6, 'Identité'),
(7, 'Technologie'),
(8, 'Survie'),
(9, 'Amitié'),
(10, 'Trahison');

-- 3. Genres (comment l'histoire est racontée - le style)
INSERT INTO genre (id_genre, nom) VALUES
(1, 'Science-fiction'),
(2, 'Drame'),
(3, 'Action'),
(4, 'Aventure'),
(5, 'Fantastique'),
(6, 'Thriller'),
(7, 'Comédie'),
(8, 'Animation'),
(9, 'Policier'),
(10, 'Historique');

-- 4. Ressources (Livres)

-- Livre 1 : Dune
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(1, 'livre', 'Dune', 'Frank Herbert', 1965, 'Dans un futur lointain, le duc Leto Atréides reçoit la charge de la planète Arrakis, unique source de l\'Épice.', 'Dune.jpg', 'États-Unis');

INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages, prix, langue) VALUES
(1, '9782266283053', 'Pocket', 832, 12.50, 'Français');

INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (1, 1), (1, 4); -- Science-fiction, Aventure
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (1, 1), (1, 8), (1, 6); -- Pouvoir, Survie, Identité

-- Livre 2 : 1984
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(2, 'livre', '1984', 'George Orwell', 1949, 'De tous les carrefours importants, le visage à la moustache noire vous fixait du regard. BIG BROTHER VOUS REGARDE.', '1984.jpg', 'Royaume-Uni');

INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages, prix, langue) VALUES
(2, '9782070368228', 'Gallimard', 448, 8.90, 'Français');

INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (2, 1), (2, 6); -- Science-fiction, Thriller
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (2, 1), (2, 4), (2, 7); -- Pouvoir, Liberté, Technologie

-- Livre 3 : Le Petit Prince
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(3, 'livre', 'Le Petit Prince', 'Antoine de Saint-Exupéry', 1943, 'J\'ai ainsi vécu seul, sans personne avec qui parler véritablement, jusqu\'à une panne dans le désert du Sahara.', 'LePetitPrince.jpg', 'France');

INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages, prix, langue) VALUES
(3, '9782070408504', 'Gallimard', 96, 6.50, 'Français');

INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (3, 5); -- Fantastique
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (3, 9), (3, 3), (3, 6); -- Amitié, Amour, Identité

-- Livre 4 : Les Misérables
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(4, 'livre', 'Les Misérables', 'Victor Hugo', 1862, 'Le destin de Jean Valjean, forçat évadé, et de Cosette, fille de Fantine, dans la France du XIXe siècle.', 'LesMiserables.jpg', 'France');

INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages, prix, langue) VALUES
(4, '9782253096337', 'Livre de Poche', 1600, 18.00, 'Français');

INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (4, 2), (4, 10); -- Drame, Historique
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (4, 4), (4, 3), (4, 2); -- Liberté, Amour, Famille

-- Livre 5 : Sapiens
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(5, 'livre', 'Sapiens : Une brève histoire de l\'humanité', 'Yuval Noah Harari', 2011, 'Comment l\'Homo sapiens a-t-il réussi à dominer la planète ? Une fresque historique audacieuse.', 'Sapiens.jpg', 'Israël');

INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages, prix, langue) VALUES
(5, '9782226257017', 'Albin Michel', 512, 24.00, 'Français');

INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (5, 10); -- Historique
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (5, 1), (5, 8), (5, 6); -- Pouvoir, Survie, Identité

-- 5. Ressources (Films)

-- Film 1 : Inception
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(6, 'film', 'Inception', 'Christopher Nolan', 2010, 'Dom Cobb est un voleur expérimenté, le meilleur dans l\'art dangereux de l\'extraction.', 'Inception.jpg', 'États-Unis');

INSERT INTO film (id_ressource, duree, support, langue, sous_titres, propose_par, casting) VALUES
(6, 148, 'Blu-ray', 'Anglais', 'Français, Anglais, Espagnol', 'UniversCiné', 'Leonardo DiCaprio, Joseph Gordon-Levitt, Ellen Page, Tom Hardy, Marion Cotillard');

INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (6, 1), (6, 3), (6, 6); -- Science-fiction, Action, Thriller
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (6, 7), (6, 6), (6, 3); -- Technologie, Identité, Amour

-- Film 2 : Le Parrain
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(7, 'film', 'Le Parrain', 'Francis Ford Coppola', 1972, 'L\'histoire de la famille Corleone, une des plus grandes familles de la mafia américaine.', 'LeParrain.jpg', 'États-Unis');

INSERT INTO film (id_ressource, duree, support, langue, sous_titres, propose_par, casting) VALUES
(7, 175, 'DVD', 'Anglais', 'Français', 'CNC', 'Marlon Brando, Al Pacino, James Caan, Robert Duvall, Diane Keaton');

INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (7, 2), (7, 9); -- Drame, Policier
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (7, 1), (7, 2), (7, 10); -- Pouvoir, Famille, Trahison

-- Film 3 : Interstellar
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(8, 'film', 'Interstellar', 'Christopher Nolan', 2014, 'Une équipe d\'explorateurs voyage à travers un trou de ver pour assurer la survie de l\'humanité.', 'Interstellar.jpg', 'États-Unis');

INSERT INTO film (id_ressource, duree, support, langue, sous_titres, propose_par, casting) VALUES
(8, 169, 'Streaming', 'Anglais', 'Français, Allemand', 'Arte', 'Matthew McConaughey, Anne Hathaway, Jessica Chastain, Michael Caine, Matt Damon');

INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (8, 1), (8, 2), (8, 4); -- Science-fiction, Drame, Aventure
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (8, 8), (8, 2), (8, 3); -- Survie, Famille, Amour

-- Film 4 : Le Roi Lion
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(9, 'film', 'Le Roi Lion', 'Roger Allers', 1994, 'Le lionceau Simba est exilé après la mort de son père, le roi Mufasa.', 'LeRoiLion.webp', 'États-Unis');

INSERT INTO film (id_ressource, duree, support, langue, sous_titres, propose_par, casting) VALUES
(9, 88, 'DVD', 'Français', 'Aucun', 'Médiathèque numérique', 'Matthew Broderick, James Earl Jones, Jeremy Irons, Whoopi Goldberg, Nathan Lane');

INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (9, 8), (9, 4), (9, 2); -- Animation, Aventure, Drame
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (9, 2), (9, 6), (9, 10); -- Famille, Identité, Trahison

-- Film 5 : Matrix
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(10, 'film', 'Matrix', 'Lana & Lilly Wachowski', 1999, 'Un pirate informatique découvre que la réalité n\'est qu\'une simulation virtuelle.', 'Matrix.png', 'États-Unis');

INSERT INTO film (id_ressource, duree, support, langue, sous_titres, propose_par, casting) VALUES
(10, 136, 'Blu-ray', 'Anglais', 'Français, Japonais', 'UniversCiné', 'Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss, Hugo Weaving, Joe Pantoliano');

INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (10, 1), (10, 3); -- Science-fiction, Action
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (10, 7), (10, 4), (10, 6); -- Technologie, Liberté, Identité

-- ============================================
-- MIGRATION : Ajout de la langue aux livres
-- (Exécuter ces commandes sur une BD existante)
-- ============================================

-- Étape 1 : Ajouter la colonne langue à la table livre
-- ALTER TABLE livre ADD COLUMN langue VARCHAR(50) NOT NULL DEFAULT 'Français';

-- Étape 2 : Mettre à jour tous les livres existants avec la langue Français
-- UPDATE livre SET langue = 'Français';

