<?php
/**
 * Middleware d'authentification
 * SAE R307 - Médiathèque
 */

class Auth {

    /**
     * Vérifie si l'utilisateur est connecté
     */
    public static function check() {
        return isset($_SESSION['user']);
    }

    /**
     * Récupère l'utilisateur connecté
     */
    public static function user() {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Vérifie si l'utilisateur a un rôle spécifique
     */
    public static function hasRole($role) {
        if (!self::check()) {
            return false;
        }
        return $_SESSION['user']['role'] === $role;
    }

    /**
     * Requiert un rôle spécifique (redirection si non autorisé)
     */
    public static function requireRole($role) {
        if (!self::check() || $_SESSION['user']['role'] !== $role) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
    }

    /**
     * Requiert d'être connecté (peu importe le rôle)
     */
    public static function requireAuth() {
        if (!self::check()) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
    }

    /**
     * Vérifie si l'utilisateur est staff (admin ou bibliothécaire)
     */
    public static function isStaff() {
        return self::hasRole('administrateur') || self::hasRole('bibliothecaire');
    }

    /**
     * Requiert rôle staff (admin ou bibliothécaire)
     */
    public static function requireStaff() {
        if (!self::isStaff()) {
            $_SESSION['error'] = "Accès réservé aux administrateurs et bibliothécaires.";
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
    }
}
