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
-- Mot de passe pour tous : "password" ($2y$10$...)
INSERT INTO utilisateur (id_utilisateur, nom, prenom, email, mot_de_passe, role) VALUES
(1, 'Admin', 'System', 'admin@mediatheque.com', '$2y$10$3.q/k.u.v.w.x.y.z.A.B.C.D.E.F.G.H.I.J.K.L.M.N.O.P.Q', 'administrateur'),
(2, 'Biblio', 'Thecaire', 'biblio@mediatheque.com', '$2y$10$3.q/k.u.v.w.x.y.z.A.B.C.D.E.F.G.H.I.J.K.L.M.N.O.P.Q', 'bibliothecaire'),
(3, 'Doe', 'John', 'user@mediatheque.com', '$2y$10$3.q/k.u.v.w.x.y.z.A.B.C.D.E.F.G.H.I.J.K.L.M.N.O.P.Q', 'utilisateur');

-- 2. Thèmes
INSERT INTO theme (id_theme, nom) VALUES
(1, 'Science-Fiction'),
(2, 'Fantastique'),
(3, 'Histoire'),
(4, 'Romance'),
(5, 'Thriller'),
(6, 'Jeunesse'),
(7, 'Drame');

-- 3. Genres
INSERT INTO genre (id_genre, nom) VALUES
(1, 'Roman'),
(2, 'Essai'),
(3, 'BD'),
(4, 'Action'),
(5, 'Comédie'),
(6, 'Aventure');

-- 4. Ressources (Livres)

-- Livre 1 : Dune
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(1, 'livre', 'Dune', 'Frank Herbert', 1965, 'Dans un futur lointain, le duc Leto Atréides reçoit la charge de la planète Arrakis, unique source de l\'Épice.', 'Dune.jpg', 'États-Unis');

INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages, prix) VALUES
(1, '9782266283053', 'Pocket', 832, 12.50);

INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (1, 1), (1, 6); -- SF, Jeunesse
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (1, 1); -- Roman

-- Livre 2 : 1984
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(2, 'livre', '1984', 'George Orwell', 1949, 'De tous les carrefours importants, le visage à la moustache noire vous fixait du regard. BIG BROTHER VOUS REGARDE.', '1984.jpg', 'Royaume-Uni');

INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages, prix) VALUES
(2, '9782070368228', 'Gallimard', 448, 8.90);

INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (2, 1), (2, 5); -- SF, Thriller
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (2, 1); -- Roman

-- Livre 3 : Le Petit Prince
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(3, 'livre', 'Le Petit Prince', 'Antoine de Saint-Exupéry', 1943, 'J\'ai ainsi vécu seul, sans personne avec qui parler véritablement, jusqu\'à une panne dans le désert du Sahara.', 'LePetitPrince.jpg', 'France');

INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages, prix) VALUES
(3, '9782070408504', 'Gallimard', 96, 6.50);

INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (3, 6), (3, 2); -- Jeunesse, Fantastique
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (3, 1); -- Roman

-- Livre 4 : Les Misérables
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(4, 'livre', 'Les Misérables', 'Victor Hugo', 1862, 'Le destin de Jean Valjean, forçat évadé, et de Cosette, fille de Fantine, dans la France du XIXe siècle.', 'LesMiserables.jpg', 'France');

INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages, prix) VALUES
(4, '9782253096337', 'Livre de Poche', 1600, 18.00);

INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (4, 3), (4, 7); -- Histoire, Drame
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (4, 1); -- Roman

-- Livre 5 : Sapiens
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(5, 'livre', 'Sapiens : Une brève histoire de l\'humanité', 'Yuval Noah Harari', 2011, 'Comment l\'Homo sapiens a-t-il réussi à dominer la planète ? Une fresque historique audacieuse.', 'Sapiens.jpg', 'Israël');

INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages, prix) VALUES
(5, '9782226257017', 'Albin Michel', 512, 24.00);

INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (5, 3); -- Histoire
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (5, 2); -- Essai

-- 5. Ressources (Films)

-- Film 1 : Inception
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(6, 'film', 'Inception', 'Christopher Nolan', 2010, 'Dom Cobb est un voleur expérimenté, le meilleur dans l\'art dangereux de l\'extraction.', 'Inception.jpg', 'États-Unis');

INSERT INTO film (id_ressource, duree, support, langue, sous_titres) VALUES
(6, 148, 'Blu-ray', 'Anglais', 'Français, Anglais, Espagnol');

INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (6, 1), (6, 5); -- SF, Thriller
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (6, 4); -- Action

-- Film 2 : Le Parrain
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(7, 'film', 'Le Parrain', 'Francis Ford Coppola', 1972, 'L\'histoire de la famille Corleone, une des plus grandes familles de la mafia américaine.', 'LeParrain.jpg', 'États-Unis');

INSERT INTO film (id_ressource, duree, support, langue, sous_titres) VALUES
(7, 175, 'DVD', 'Anglais', 'Français');

INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (7, 7), (7, 3); -- Drame, Histoire
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (7, 4); -- Action (approx)

-- Film 3 : Interstellar
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(8, 'film', 'Interstellar', 'Christopher Nolan', 2014, 'Une équipe d\'explorateurs voyage à travers un trou de ver pour assurer la survie de l\'humanité.', 'Interstellar.jpg', 'États-Unis');

INSERT INTO film (id_ressource, duree, support, langue, sous_titres) VALUES
(8, 169, 'Streaming', 'Anglais', 'Français, Allemand');

INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (8, 1), (8, 7); -- SF, Drame
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (8, 6); -- Aventure

-- Film 4 : Le Roi Lion
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(9, 'film', 'Le Roi Lion', 'Roger Allers', 1994, 'Le lionceau Simba est exilé après la mort de son père, le roi Mufasa.', 'LeRoiLion.webp', 'États-Unis');

INSERT INTO film (id_ressource, duree, support, langue, sous_titres) VALUES
(9, 88, 'DVD', 'Français', 'Aucun');

INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (9, 6), (9, 7); -- Jeunesse, Drame
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (9, 6); -- Aventure

-- Film 5 : Matrix
INSERT INTO ressource (id_ressource, type, titre, auteur_realisateur, annee, resume, image_url, pays) VALUES
(10, 'film', 'Matrix', 'Lana & Lilly Wachowski', 1999, 'Un pirate informatique découvre que la réalité n\'est qu\'une simulation virtuelle.', 'Matrix.png', 'États-Unis');

INSERT INTO film (id_ressource, duree, support, langue, sous_titres) VALUES
(10, 136, 'Blu-ray', 'Anglais', 'Français, Japonais');

INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (10, 1), (10, 4); -- SF, Romance (approx)
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (10, 4); -- Action
