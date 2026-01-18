<?php
/**
 * Modèle Genre
 * SAE R307 - Médiathèque
 */

require_once __DIR__ . '/../../core/Model.php';

class Genre extends Model {
    protected $table = 'genre';

    /**
     * Récupère tous les genres
     * @return array
     */
    public function getAll() {
        $sql = "SELECT * FROM genre ORDER BY nom ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un genre par ID
     * @param int $id
     * @return array|false
     */
    public function findById($id) {
        $sql = "SELECT * FROM genre WHERE id_genre = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie si un nom existe déjà
     * @param string $nom
     * @param int|null $excludeId ID à exclure (pour edit)
     * @return bool
     */
    public function existsByName($nom, $excludeId = null) {
        if ($excludeId) {
            $sql = "SELECT COUNT(*) FROM genre WHERE nom = ? AND id_genre != ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nom, $excludeId]);
        } else {
            $sql = "SELECT COUNT(*) FROM genre WHERE nom = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nom]);
        }
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Créer un genre
     * @param string $nom
     * @return int ID inséré
     */
    public function create($nom) {
        $sql = "INSERT INTO genre (nom) VALUES (?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nom]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Modifier un genre
     * @param int $id
     * @param string $nom
     * @return bool
     */
    public function update($id, $nom) {
        $sql = "UPDATE genre SET nom = ? WHERE id_genre = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom, $id]);
    }

    /**
     * Supprimer un genre
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $sql = "DELETE FROM genre WHERE id_genre = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
