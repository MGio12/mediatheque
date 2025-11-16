<?php
/**
 * Classe abstraite Model
 * SAE R307 - Médiathèque
 */

abstract class Model {
    protected $pdo;
    protected $table;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    /**
     * Récupérer tous les enregistrements
     */
    public function findAll() {
        // À implémenter
    }

    /**
     * Récupérer un enregistrement par ID
     */
    public function findById($id) {
        // À implémenter
    }

    /**
     * Créer un nouvel enregistrement
     */
    public function create($data) {
        // À implémenter
    }

    /**
     * Mettre à jour un enregistrement
     */
    public function update($id, $data) {
        // À implémenter
    }

    /**
     * Supprimer un enregistrement
     */
    public function delete($id) {
        // À implémenter
    }
}
