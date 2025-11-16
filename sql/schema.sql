-- ============================================
-- SAE R307 - Médiathèque
-- SCRIPT FINAL COMPATIBLE PHPMyAdmin / IUT
-- ============================================

-- Suppression des tables dans le bon ordre
DROP TABLE IF EXISTS evaluation;
DROP TABLE IF EXISTS ressource_genre;
DROP TABLE IF EXISTS ressource_theme;
DROP TABLE IF EXISTS film;
DROP TABLE IF EXISTS livre;
DROP TABLE IF EXISTS ressource;
DROP TABLE IF EXISTS genre;
DROP TABLE IF EXISTS theme;
DROP TABLE IF EXISTS utilisateur;

-- ============================================
-- Table : utilisateur
-- ============================================
CREATE TABLE utilisateur (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL COMMENT 'Hash bcrypt via password_hash()',
    role ENUM('utilisateur', 'bibliothecaire', 'administrateur') NOT NULL DEFAULT 'utilisateur',
    date_inscription DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table : ressource (parent)
-- Remplacement YEAR → SMALLINT
-- ============================================
CREATE TABLE ressource (
    id_ressource INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('livre', 'film') NOT NULL,
    titre VARCHAR(255) NOT NULL,
    auteur_realisateur VARCHAR(255) NOT NULL,
    annee SMALLINT NOT NULL,  -- compatible pour 1800-2100
    resume TEXT,
    image_url VARCHAR(255),
    date_ajout DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_type (type),
    INDEX idx_titre (titre),
    INDEX idx_auteur_realisateur (auteur_realisateur),
    INDEX idx_date_ajout (date_ajout)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table : livre (enfant)
-- ============================================
CREATE TABLE livre (
    id_ressource INT PRIMARY KEY,
    isbn VARCHAR(13) NOT NULL UNIQUE,
    editeur VARCHAR(255) NOT NULL,
    nombre_pages INT NOT NULL,
    CONSTRAINT fk_livre_ressource FOREIGN KEY (id_ressource)
        REFERENCES ressource(id_ressource)
        ON DELETE CASCADE,
    INDEX idx_isbn (isbn)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table : film (enfant)
-- ============================================
CREATE TABLE film (
    id_ressource INT PRIMARY KEY,
    duree INT NOT NULL,
    support ENUM('DVD', 'Blu-ray', 'Streaming') NOT NULL,
    langue VARCHAR(50) NOT NULL,
    CONSTRAINT fk_film_ressource FOREIGN KEY (id_ressource)
        REFERENCES ressource(id_ressource)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table : theme
-- ============================================
CREATE TABLE theme (
    id_theme INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table : genre
-- ============================================
CREATE TABLE genre (
    id_genre INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table : ressource_theme (N:N)
-- ============================================
CREATE TABLE ressource_theme (
    id_ressource INT NOT NULL,
    id_theme INT NOT NULL,
    PRIMARY KEY (id_ressource, id_theme),
    CONSTRAINT fk_rt_ressource FOREIGN KEY (id_ressource)
        REFERENCES ressource(id_ressource)
        ON DELETE CASCADE,
    CONSTRAINT fk_rt_theme FOREIGN KEY (id_theme)
        REFERENCES theme(id_theme)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table : ressource_genre (N:N)
-- ============================================
CREATE TABLE ressource_genre (
    id_ressource INT NOT NULL,
    id_genre INT NOT NULL,
    PRIMARY KEY (id_ressource, id_genre),
    CONSTRAINT fk_rg_ressource FOREIGN KEY (id_ressource)
        REFERENCES ressource(id_ressource)
        ON DELETE CASCADE,
    CONSTRAINT fk_rg_genre FOREIGN KEY (id_genre)
        REFERENCES genre(id_genre)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table : evaluation
-- ============================================
CREATE TABLE evaluation (
    id_evaluation INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_ressource INT NOT NULL,
    note DECIMAL(2,1) NOT NULL,
    critique TEXT,
    date_evaluation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_evaluation (id_utilisateur, id_ressource),
    CONSTRAINT fk_eval_utilisateur FOREIGN KEY (id_utilisateur)
        REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE,
    CONSTRAINT fk_eval_ressource FOREIGN KEY (id_ressource)
        REFERENCES ressource(id_ressource)
        ON DELETE CASCADE,
    INDEX idx_ressource (id_ressource),
    INDEX idx_utilisateur (id_utilisateur),
    INDEX idx_note (note)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Vérification
-- ============================================
SHOW TABLES;
