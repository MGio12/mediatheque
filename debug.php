<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');

echo "PHP Version: " . phpversion() . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "Session Save Path: " . session_save_path() . "<br>";
echo "Session Status: " . session_status() . "<br><br>";

session_start();
echo "Session started successfully<br><br>";

echo "<h3>Testing database connection...</h3>";

// Charger la config
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Database.php';

try {
    $pdo = Database::getPDO();
    echo "✓ PDO object created<br>";

    // Test simple
    $stmt = $pdo->query("SELECT COUNT(*) AS nb FROM utilisateur");
    $result = $stmt->fetch();

    echo "✓ Database connection OK<br>";
    echo "Utilisateurs en base : " . $result['nb'] . "<br>";

} catch (Exception $e) {
    echo "<b>DATABASE ERROR:</b><br>";
    echo nl2br($e->getMessage());
}
?>