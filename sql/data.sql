-- ============================================
-- SAE R307 - Médiathèque
-- Données de test
-- ============================================

-- ============================================
-- 1. UTILISATEURS
-- Tous les mots de passe = "password123"
-- ============================================

INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, role) VALUES
('Admin', 'Système', 'admin@mediatheque.fr',
 '$2y$12$hVpIjsngscoe7jGSaPFdEezS.K4Q908kIv7fZhA6unSGZEP/x3bxS',
 'administrateur'),

('Dupont', 'Marie', 'marie.dupont@mediatheque.fr',
 '$2y$12$hVpIjsngscoe7jGSaPFdEezS.K4Q908kIv7fZhA6unSGZEP/x3bxS',
 'bibliothecaire'),

('Martin', 'Julien', 'julien.martin@mail.fr',
 '$2y$12$hVpIjsngscoe7jGSaPFdEezS.K4Q908kIv7fZhA6unSGZEP/x3bxS',
 'utilisateur'),

('Bernard', 'Sophie', 'sophie.bernard@mail.fr',
 '$2y$12$hVpIjsngscoe7jGSaPFdEezS.K4Q908kIv7fZhA6unSGZEP/x3bxS',
 'utilisateur'),

('Durand', 'Thomas', 'thomas.durand@mail.fr',
 '$2y$12$hVpIjsngscoe7jGSaPFdEezS.K4Q908kIv7fZhA6unSGZEP/x3bxS',
 'utilisateur');

-- ============================================
-- 2. THÈMES
-- ============================================

INSERT INTO theme (nom) VALUES
('Science-Fiction'),
('Policier'),
('Romance'),
('Aventure'),
('Historique'),
('Fantastique'),
('Thriller'),
('Drame');

-- ============================================
-- 3. GENRES
-- ============================================

INSERT INTO genre (nom) VALUES
('Roman'),
('Nouvelle'),
('Essai'),
('Documentaire'),
('Action'),
('Comédie'),
('Animation'),
('Biographie');

-- ============================================
-- 4. LIVRES (avec transactions pour cohérence)
-- ============================================

-- Livre 1 : 1984
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', '1984', 'George Orwell', 1949,
'Dans un monde totalitaire, Winston Smith travaille au Ministère de la Vérité où il falsifie l\'histoire. Il commence à remettre en question le régime oppressif de Big Brother.',
'public/images/livres/1984.jpg');
SET @id_livre1 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre1, '9780451524935', 'Penguin Books', 328);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre1, 1), (@id_livre1, 5);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre1, 1);
COMMIT;

-- Livre 2 : Le Petit Prince
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'Le Petit Prince', 'Antoine de Saint-Exupéry', 1943,
'Un aviateur échoué dans le désert rencontre un petit prince venu d\'une autre planète. À travers leurs échanges, une réflexion poétique sur l\'amour, l\'amitié et la nature humaine.',
'public/images/livres/petit-prince.jpg');
SET @id_livre2 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre2, '9782070612758', 'Gallimard', 96);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre2, 6);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre2, 1);
COMMIT;

-- Livre 3 : Les Misérables
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'Les Misérables', 'Victor Hugo', 1862,
'L\'histoire de Jean Valjean, ancien forçat en quête de rédemption dans la France du XIXe siècle. Une fresque sociale monumentale sur la justice, la misère et l\'espoir.',
'public/images/livres/miserables.jpg');
SET @id_livre3 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre3, '9782070409228', 'Le Livre de Poche', 1664);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre3, 5), (@id_livre3, 8);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre3, 1);
COMMIT;

-- Livre 4 : Harry Potter à l'école des sorciers
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'Harry Potter à l\'école des sorciers', 'J.K. Rowling', 1997,
'Harry Potter découvre à ses 11 ans qu\'il est un sorcier et entre à Poudlard. Il y découvre un monde magique et l\'histoire de ses parents.',
'public/images/livres/harry-potter-1.jpg');
SET @id_livre4 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre4, '9782070643028', 'Gallimard Jeunesse', 320);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre4, 6), (@id_livre4, 4);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre4, 1);
COMMIT;

-- Livre 5 : Le Seigneur des Anneaux - La Communauté de l'Anneau
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'Le Seigneur des Anneaux : La Communauté de l\'Anneau', 'J.R.R. Tolkien', 1954,
'Frodon Sacquet hérite d\'un anneau magique qui se révèle être l\'Anneau Unique forgé par Sauron. Il doit le détruire pour sauver la Terre du Milieu.',
'public/images/livres/lotr-1.jpg');
SET @id_livre5 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre5, '9782266154345', 'Pocket', 640);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre5, 6), (@id_livre5, 4);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre5, 1);
COMMIT;

-- Livre 6 : Sapiens
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'Sapiens : Une brève histoire de l\'humanité', 'Yuval Noah Harari', 2011,
'De la préhistoire à nos jours, Harari retrace l\'histoire de l\'humanité en explorant les révolutions cognitives, agricoles et scientifiques qui ont façonné notre espèce.',
'public/images/livres/sapiens.jpg');
SET @id_livre6 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre6, '9782226257017', 'Albin Michel', 512);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre6, 5);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre6, 3);
COMMIT;

-- Livre 7 : Le Parfum
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'Le Parfum', 'Patrick Süskind', 1985,
'Jean-Baptiste Grenouille, doté d\'un odorat extraordinaire, devient parfumeur dans la France du XVIIIe siècle. Obsédé par les odeurs, il sombre dans la folie meurtrière.',
'public/images/livres/parfum.jpg');
SET @id_livre7 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre7, '9782253035527', 'Le Livre de Poche', 320);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre7, 2), (@id_livre7, 5);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre7, 1);
COMMIT;

-- Livre 8 : L'Étranger
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'L\'Étranger', 'Albert Camus', 1942,
'Meursault, employé de bureau à Alger, assiste à l\'enterrement de sa mère avec indifférence. Peu après, il tue un homme sur la plage sans raison apparente.',
'public/images/livres/etranger.jpg');
SET @id_livre8 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre8, '9782070360024', 'Gallimard', 186);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre8, 8);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre8, 1);
COMMIT;

-- Livre 9 : Dune
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'Dune', 'Frank Herbert', 1965,
'Sur la planète désertique Arrakis, Paul Atréides doit survivre aux complots politiques et devenir le messie attendu par le peuple Fremen.',
'public/images/livres/dune.jpg');
SET @id_livre9 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre9, '9782266320481', 'Pocket', 928);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre9, 1), (@id_livre9, 4);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre9, 1);
COMMIT;

-- Livre 10 : Pride and Prejudice
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'Orgueil et Préjugés', 'Jane Austen', 1813,
'Elizabeth Bennet et Mr. Darcy surmontent leurs préjugés initiaux dans l\'Angleterre du début du XIXe siècle pour découvrir l\'amour.',
'public/images/livres/orgueil-prejuges.jpg');
SET @id_livre10 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre10, '9782253004448', 'Le Livre de Poche', 512);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre10, 3), (@id_livre10, 5);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre10, 1);
COMMIT;

-- Livre 11 : Le Comte de Monte-Cristo
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'Le Comte de Monte-Cristo', 'Alexandre Dumas', 1844,
'Edmond Dantès, injustement emprisonné, s\'évade et revient sous l\'identité du Comte de Monte-Cristo pour se venger de ceux qui l\'ont trahi.',
'public/images/livres/monte-cristo.jpg');
SET @id_livre11 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre11, '9782253098058', 'Le Livre de Poche', 1376);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre11, 4), (@id_livre11, 5);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre11, 1);
COMMIT;

-- Livre 12 : Fahrenheit 451
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'Fahrenheit 451', 'Ray Bradbury', 1953,
'Dans une société future où les livres sont interdits et brûlés, un pompier chargé de cette tâche commence à remettre en question son rôle.',
'public/images/livres/fahrenheit-451.jpg');
SET @id_livre12 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre12, '9782072762536', 'Gallimard', 256);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre12, 1), (@id_livre12, 8);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre12, 1);
COMMIT;

-- Livre 13 : Les Raisins de la colère
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'Les Raisins de la colère', 'John Steinbeck', 1939,
'Durant la Grande Dépression, la famille Joad quitte l\'Oklahoma pour la Californie en quête d\'une vie meilleure, mais se heurte à la misère et l\'injustice.',
'public/images/livres/raisins-colere.jpg');
SET @id_livre13 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre13, '9782070360512', 'Gallimard', 768);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre13, 5), (@id_livre13, 8);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre13, 1);
COMMIT;

-- Livre 14 : Ne tirez pas sur l'oiseau moqueur
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'Ne tirez pas sur l\'oiseau moqueur', 'Harper Lee', 1960,
'Dans l\'Alabama des années 1930, l\'avocat Atticus Finch défend un homme noir accusé à tort de viol, vu à travers les yeux de sa fille Scout.',
'public/images/livres/oiseau-moqueur.jpg');
SET @id_livre14 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre14, '9782253148678', 'Le Livre de Poche', 448);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre14, 5), (@id_livre14, 8);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre14, 1);
COMMIT;

-- Livre 15 : Le Vieil Homme et la Mer
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('livre', 'Le Vieil Homme et la Mer', 'Ernest Hemingway', 1952,
'Un vieux pêcheur cubain mène un combat épique contre un espadon géant dans le Gulf Stream, affrontant la nature et sa propre mortalité.',
'public/images/livres/vieil-homme-mer.jpg');
SET @id_livre15 = LAST_INSERT_ID();
INSERT INTO livre (id_ressource, isbn, editeur, nombre_pages) VALUES
(@id_livre15, '9782070360079', 'Gallimard', 160);
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_livre15, 4), (@id_livre15, 8);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_livre15, 2);
COMMIT;

-- ============================================
-- 5. FILMS (avec transactions pour cohérence)
-- ============================================

-- Film 1 : Inception
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'Inception', 'Christopher Nolan', 2010,
'Dom Cobb est un voleur spécialisé dans l\'extraction de secrets au sein des rêves. On lui propose une mission inverse : implanter une idée dans l\'esprit d\'un homme.',
'public/images/films/inception.jpg');
SET @id_film1 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film1, 148, 'Blu-ray', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film1, 1), (@id_film1, 7);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film1, 5);
COMMIT;


-- Film 2 : Le Parrain
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'Le Parrain', 'Francis Ford Coppola', 1972,
'L\'ascension de Michael Corleone dans le monde de la mafia new-yorkaise des années 1940. Un portrait puissant de la famille, du pouvoir et de la violence.',
'public/images/films/parrain.jpg');
SET @id_film2 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film2, 175, 'Blu-ray', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film2, 2), (@id_film2, 8);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film2, 8);
COMMIT;

-- Film 3 : La Liste de Schindler
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'La Liste de Schindler', 'Steven Spielberg', 1993,
'L\'histoire vraie d\'Oskar Schindler, industriel allemand qui sauva plus de 1000 juifs durant l\'Holocauste en les employant dans ses usines.',
'public/images/films/schindler.jpg');
SET @id_film3 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film3, 195, 'DVD', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film3, 5), (@id_film3, 8);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film3, 8);
COMMIT;

-- Film 4 : Interstellar
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'Interstellar', 'Christopher Nolan', 2014,
'Face à la fin de l\'humanité sur Terre, un groupe d\'explorateurs traverse un trou de ver pour trouver une nouvelle planète habitable.',
'public/images/films/interstellar.jpg');
SET @id_film4 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film4, 169, 'Blu-ray', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film4, 1), (@id_film4, 8);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film4, 5);
COMMIT;

-- Film 5 : Pulp Fiction
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'Pulp Fiction', 'Quentin Tarantino', 1994,
'Histoires entremêlées de criminels, boxeurs et gangsters dans le Los Angeles underground. Un film culte au montage non-linéaire.',
'public/images/films/pulp-fiction.jpg');
SET @id_film5 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film5, 154, 'DVD', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film5, 2), (@id_film5, 8);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film5, 5);
COMMIT;

-- Film 6 : Forrest Gump
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'Forrest Gump', 'Robert Zemeckis', 1994,
'L\'histoire extraordinaire de Forrest Gump, homme simple d\'esprit qui traverse 40 ans d\'histoire américaine et influence des événements majeurs.',
'public/images/films/forrest-gump.jpg');
SET @id_film6 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film6, 142, 'DVD', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film6, 8), (@id_film6, 5);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film6, 8);
COMMIT;

-- Film 7 : Le Roi Lion
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'Le Roi Lion', 'Roger Allers, Rob Minkoff', 1994,
'Simba, jeune lionceau promis au trône, doit surmonter la mort de son père et affronter son oncle Scar pour reprendre sa place de roi.',
'public/images/films/roi-lion.jpg');
SET @id_film7 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film7, 88, 'DVD', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film7, 4);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film7, 7);
COMMIT;

-- Film 8 : Matrix
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'Matrix', 'Lana Wachowski, Lilly Wachowski', 1999,
'Neo découvre que la réalité qu\'il connaît est une simulation informatique créée par des machines pour asservir l\'humanité.',
'public/images/films/matrix.jpg');
SET @id_film8 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film8, 136, 'Blu-ray', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film8, 1), (@id_film8, 7);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film8, 5);
COMMIT;

-- Film 9 : Le Seigneur des Anneaux : La Communauté de l'Anneau
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'Le Seigneur des Anneaux : La Communauté de l\'Anneau', 'Peter Jackson', 2001,
'Adaptation du roman de Tolkien : Frodon et ses compagnons entreprennent un périlleux voyage pour détruire l\'Anneau Unique en Mordor.',
'public/images/films/lotr-1.jpg');
SET @id_film9 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film9, 178, 'Blu-ray', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film9, 6), (@id_film9, 4);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film9, 5);
COMMIT;

-- Film 10 : La Ligne verte
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'La Ligne verte', 'Frank Darabont', 1999,
'Dans un pénitencier américain des années 1930, un gardien découvre qu\'un condamné à mort possède un don surnaturel de guérison.',
'public/images/films/ligne-verte.jpg');
SET @id_film10 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film10, 189, 'DVD', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film10, 6), (@id_film10, 8);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film10, 8);
COMMIT;

-- Film 11 : Seven
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'Seven', 'David Fincher', 1995,
'Deux détectives traquent un tueur en série qui base ses meurtres sur les sept péchés capitaux dans une ville pluvieuse et oppressante.',
'public/images/films/seven.jpg');
SET @id_film11 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film11, 127, 'DVD', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film11, 2), (@id_film11, 7);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film11, 5);
COMMIT;

-- Film 12 : Vol au-dessus d'un nid de coucou
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'Vol au-dessus d\'un nid de coucou', 'Miloš Forman', 1975,
'Randle McMurphy simule la folie pour échapper à la prison et se retrouve dans un asile psychiatrique où il défie l\'autorité tyrannique de l\'infirmière Ratched.',
'public/images/films/coucou.jpg');
SET @id_film12 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film12, 133, 'DVD', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film12, 8);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film12, 8);
COMMIT;

-- Film 13 : Les Évadés
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'Les Évadés', 'Frank Darabont', 1994,
'Andy Dufresne, banquier condamné à perpétuité pour un crime qu\'il n\'a pas commis, noue une amitié avec Red et prépare une évasion spectaculaire.',
'public/images/films/evades.jpg');
SET @id_film13 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film13, 142, 'Blu-ray', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film13, 8);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film13, 8);
COMMIT;

-- Film 14 : Gladiator
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'Gladiator', 'Ridley Scott', 2000,
'Maximus, général romain trahi et réduit en esclavage, devient gladiateur pour se venger de l\'empereur corrompu qui a assassiné sa famille.',
'public/images/films/gladiator.jpg');
SET @id_film14 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film14, 155, 'Blu-ray', 'Anglais');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film14, 5), (@id_film14, 4);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film14, 5);
COMMIT;

-- Film 15 : Amélie Poulain
START TRANSACTION;
INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url) VALUES
('film', 'Le Fabuleux Destin d\'Amélie Poulain', 'Jean-Pierre Jeunet', 2001,
'Amélie, jeune serveuse parisienne, décide de faire le bonheur des autres tout en cherchant le sien dans le Montmartre pittoresque.',
'public/images/films/amelie.jpg');
SET @id_film15 = LAST_INSERT_ID();
INSERT INTO film (id_ressource, duree, support, langue) VALUES
(@id_film15, 122, 'DVD', 'Français');
INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (@id_film15, 3);
INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (@id_film15, 6);
COMMIT;

-- ============================================
-- 6. ÉVALUATIONS
-- ============================================

-- Évaluations sur 1984
INSERT INTO evaluation (id_utilisateur, id_ressource, note, critique) VALUES
(3, 1, 5.0, 'Un chef-d\'œuvre absolu de la dystopie. Orwell a créé un univers terrifiant et prémonitoire qui résonne encore aujourd\'hui.'),
(4, 1, 4.5, 'Lecture indispensable pour comprendre les mécanismes totalitaires. Certains passages sont un peu lents mais l\'ensemble est brillant.'),
(5, 1, 5.0, 'Big Brother is watching you... Un livre qui fait froid dans le dos par son actualité. À lire absolument.');

-- Évaluations sur Le Petit Prince
INSERT INTO evaluation (id_utilisateur, id_ressource, note, critique) VALUES
(3, 2, 5.0, 'Poésie pure. Chaque relecture apporte de nouvelles réflexions. Un trésor de la littérature française.'),
(4, 2, 4.5, 'Magnifique conte philosophique qui touche autant les enfants que les adultes.');

-- Évaluations sur Harry Potter
INSERT INTO evaluation (id_utilisateur, id_ressource, note, critique) VALUES
(5, 4, 5.0, 'Le début d\'une saga extraordinaire. L\'univers créé par Rowling est fascinant et addictif.'),
(3, 4, 4.0, 'Très bon premier tome, même si les suivants sont encore meilleurs. Parfait pour jeunes lecteurs.');

-- Évaluations sur Le Seigneur des Anneaux (livre)
INSERT INTO evaluation (id_utilisateur, id_ressource, note, critique) VALUES
(4, 5, 5.0, 'L\'œuvre fondatrice de la fantasy moderne. Tolkien a créé un monde d\'une richesse incroyable.'),
(5, 5, 4.5, 'Un peu long au début mais absolument génial une fois lancé. Les descriptions sont magnifiques.');

-- Évaluations sur Inception (film)
INSERT INTO evaluation (id_utilisateur, id_ressource, note, critique) VALUES
(3, 16, 5.0, 'Un chef-d\'œuvre de science-fiction. Nolan repousse les limites du genre avec intelligence et spectacle.'),
(4, 16, 4.5, 'Film complexe qui demande toute votre attention, mais tellement gratifiant. Les effets visuels sont bluffants.'),
(5, 16, 5.0, 'Une des meilleures expériences cinématographiques de la décennie. À voir et revoir.');

-- Évaluations sur Le Parrain (film)
INSERT INTO evaluation (id_utilisateur, id_ressource, note, critique) VALUES
(3, 17, 5.0, 'LE film de gangsters par excellence. Performances magistrales, mise en scène parfaite.'),
(4, 17, 5.0, 'Un monument du cinéma. Chaque scène est iconique.');

-- Évaluations sur Interstellar (film)
INSERT INTO evaluation (id_utilisateur, id_ressource, note, critique) VALUES
(5, 19, 4.5, 'Ambitieux et émouvant. La bande-son de Hans Zimmer est exceptionnelle.'),
(3, 19, 4.0, 'Visuellement époustouflant mais parfois un peu trop complexe.');

-- Évaluations sur Matrix (film)
INSERT INTO evaluation (id_utilisateur, id_ressource, note, critique) VALUES
(4, 23, 5.0, 'Révolutionnaire pour l\'époque. Les scènes d\'action ont redéfini le genre.'),
(5, 23, 4.5, 'Un concept fascinant sur la réalité. Les effets spéciaux ont très bien vieilli.');

-- Évaluations sur LOTR La Communauté (film)
INSERT INTO evaluation (id_utilisateur, id_ressource, note, critique) VALUES
(3, 24, 5.0, 'Adaptation parfaite du roman. Peter Jackson a réussi l\'impossible.'),
(4, 24, 5.0, 'Un voyage épique et magique. La Terre du Milieu prend vie à l\'écran.');

-- Évaluations sur Les Évadés (film)
INSERT INTO evaluation (id_utilisateur, id_ressource, note, critique) VALUES
(5, 28, 5.0, 'Le meilleur film de tous les temps selon moi. Histoire d\'espoir et d\'amitié magnifique.'),
(3, 28, 5.0, 'Perfection du début à la fin. Performances exceptionnelles de Morgan Freeman et Tim Robbins.');

-- Évaluations supplémentaires variées
INSERT INTO evaluation (id_utilisateur, id_ressource, note, critique) VALUES
(4, 3, 4.5, 'Victor Hugo au sommet de son art. Une fresque sociale monumentale.'),
(5, 6, 4.0, 'Essai passionnant qui remet en perspective notre histoire. Parfois un peu dense.'),
(3, 9, 4.5, 'Dune est un univers fascinant. L\'écologie et la politique s\'entremêlent brillamment.'),
(4, 18, 4.5, 'La Liste de Schindler est un film nécessaire. Bouleversant et magnifiquement réalisé.'),
(5, 20, 4.0, 'Pulp Fiction reste un classique du cinéma indépendant. Dialogues inoubliables.'),
(3, 30, 5.0, 'Amélie Poulain est un bijou de poésie visuelle. Audrey Tautou est parfaite.'),
(4, 11, 3.5, 'Le Comte de Monte-Cristo est une belle histoire de vengeance, mais très long.'),
(5, 7, 4.5, 'Le Parfum est dérangeant mais brillamment écrit. Süskind maîtrise son art.'),
(3, 21, 4.0, 'Forrest Gump est touchant et drôle. Un Tom Hanks au sommet.'),
(4, 26, 4.5, 'Seven est glaçant. David Fincher crée une atmosphère oppressante unique.');

-- ============================================
-- Vérification des données
-- ============================================

-- Afficher le nombre d'enregistrements par table
SELECT 'Utilisateurs' as Table_Name, COUNT(*) as Count FROM utilisateur
UNION ALL
SELECT 'Ressources', COUNT(*) FROM ressource
UNION ALL
SELECT 'Livres', COUNT(*) FROM livre
UNION ALL
SELECT 'Films', COUNT(*) FROM film
UNION ALL
SELECT 'Thèmes', COUNT(*) FROM theme
UNION ALL
SELECT 'Genres', COUNT(*) FROM genre
UNION ALL
SELECT 'Évaluations', COUNT(*) FROM evaluation;
