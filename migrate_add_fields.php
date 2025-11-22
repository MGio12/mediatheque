<?php
// Force CLI to simulate local env if needed, or just bypass config
$host = '127.0.0.1';
$dbname = 'gm401942_elibrary2';
$user = 'gm401942';
$password = 'gm401942';
$ports = [3306, 8889];

$pdo = null;

foreach ($ports as $port) {
    try {
        echo "Tentative de connexion sur le port $port...\n";
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        echo "Connexion réussie sur le port $port.\n";
        break;
    } catch (PDOException $e) {
        echo "Échec sur le port $port: " . $e->getMessage() . "\n";
    }
}

if (!$pdo) {
    die("Impossible de se connecter à la base de données sur aucun port standard.\n");
}

try {
    // 1. Ajouter 'prix' à la table 'livre'
    try {
        $pdo->exec("ALTER TABLE livre ADD COLUMN prix DECIMAL(10,2) DEFAULT NULL");
        echo "Colonne 'prix' ajoutée à la table 'livre'.\n";
    } catch (PDOException $e) {
        echo "Info (livre): " . $e->getMessage() . "\n";
    }

    // 2. Ajouter 'pays' à la table 'ressource'
    try {
        $pdo->exec("ALTER TABLE ressource ADD COLUMN pays VARCHAR(100) DEFAULT NULL");
        echo "Colonne 'pays' ajoutée à la table 'ressource'.\n";
    } catch (PDOException $e) {
        echo "Info (ressource): " . $e->getMessage() . "\n";
    }

    // 3. Ajouter 'sous_titres' à la table 'film'
    try {
        $pdo->exec("ALTER TABLE film ADD COLUMN sous_titres VARCHAR(255) DEFAULT NULL");
        echo "Colonne 'sous_titres' ajoutée à la table 'film'.\n";
    } catch (PDOException $e) {
        echo "Info (film): " . $e->getMessage() . "\n";
    }

    echo "Migration terminée avec succès.\n";

} catch (Exception $e) {
    die("Erreur lors de la migration : " . $e->getMessage() . "\n");
}
