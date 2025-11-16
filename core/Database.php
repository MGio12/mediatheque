<?php
/**
 * Singleton Database
 * SAE R307 - Médiathèque
 */

class Database {
    private static $instance = null;

    /**
     * Récupère l'instance unique de PDO
     * @return PDO Instance PDO configurée
     * @throws Exception Si la connexion échoue
     */
    public static function getInstance() {
        if (self::$instance === null) {
            try {
                self::$instance = getPDO();
            } catch (Exception $e) {
                // Logger l'erreur
                error_log("Database::getInstance() - Erreur: " . $e->getMessage());

                // Relancer l'exception pour qu'elle soit capturée plus haut
                throw new Exception("Impossible de se connecter à la base de données: " . $e->getMessage());
            }
        }
        return self::$instance;
    }

    /**
     * Alias compatible pour debug.php
     * → Permet d'appeler Database::getPDO()
     * @return PDO
     */
    public static function getPDO() {
        return self::getInstance();
    }

    /**
     * Vérifie si la connexion est établie
     * @return bool True si connecté
     */
    public static function isConnected() {
        return self::$instance !== null;
    }

    // Empêcher l'instanciation directe
    private function __construct() {}
    private function __clone() {}
    public function __wakeup() {}
}
?>