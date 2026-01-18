<?php
/**
 * Configuration de la base de données
 * SAE R307 - Médiathèque
 */

/**
 * Détecte l'environnement d'exécution (local ou production)
 * @return bool True si environnement de production (serveur IUT)
 */
function isProduction() {
    $host = $_SERVER['HTTP_HOST'] ?? '';

    // Détecter serveur IUT
    return (
        strpos($host, 'unice.fr') !== false ||
        strpos($host, 'linserv') !== false ||
        strpos($host, 'iut') !== false
    );
}

/**
 * Retourne une instance PDO singleton
 * @return PDO Instance PDO configurée
 * @throws PDOException En cas d'erreur de connexion
 */
function getPDO() {
    static $pdo = null;

    if ($pdo === null) {
        try {
            // Configuration selon environnement
            if (isProduction()) {
                // SERVEUR IUT (linserv-info-01.unice.fr)
                $host = 'localhost';
                $port = 3306;  // Port MySQL standard
                $dbname = 'gm401942_elibrary2';  // Base de données production
                $user = 'gm401942';
                $password = 'gm401942';  // ⚠️ À modifier avec le vrai mot de passe IUT
            } else {
                // DÉVELOPPEMENT LOCAL (MAMP)
                $host = 'localhost';
                $port = 8889;  // Port MAMP
                $dbname = 'gm401942_elibrary2';  // Base de données locale
                $user = 'gm401942';
                $password = 'gm401942';
            }

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

            $pdo = new PDO(
                $dsn,
                $user,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                ]
            );

            // Logger la connexion réussie (optionnel)
            error_log("Connexion BDD réussie - Environnement: " . (isProduction() ? 'PRODUCTION' : 'LOCAL'));

        } catch (PDOException $e) {
            // Logger l'erreur
            error_log("Erreur PDO: " . $e->getMessage());

            // Message différencié selon environnement
            if (isProduction()) {
                // En production : message générique
                die('Erreur de connexion à la base de données. Veuillez contacter l\'administrateur.');
            } else {
                // En développement : message détaillé
                die('Erreur de connexion à la base de données : ' . $e->getMessage() . '<br>DSN: ' . ($dsn ?? 'non défini'));
            }
        }
    }

    return $pdo;
}
