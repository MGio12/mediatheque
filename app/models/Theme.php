<?php
/**
 * Modèle Theme
 * SAE R307 - Médiathèque
 */

require_once __DIR__ . '/../../core/Model.php';

class Theme extends Model {
    protected $table = 'theme';

    /**
     * Récupère tous les thèmes
     * @return array
     */
    public function getAll() {
        $sql = "SELECT * FROM theme ORDER BY nom ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un thème par ID
     * @param int $id
     * @return array|false
     */
    public function findById($id) {
        $sql = "SELECT * FROM theme WHERE id_theme = ?";
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
            $sql = "SELECT COUNT(*) FROM theme WHERE nom = ? AND id_theme != ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nom, $excludeId]);
        } else {
            $sql = "SELECT COUNT(*) FROM theme WHERE nom = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nom]);
        }
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Créer un thème
     * @param string $nom
     * @return int ID inséré
     */
    public function create($nom) {
        $sql = "INSERT INTO theme (nom) VALUES (?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nom]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Modifier un thème
     * @param int $id
     * @param string $nom
     * @return bool
     */
    public function update($id, $nom) {
        $sql = "UPDATE theme SET nom = ? WHERE id_theme = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom, $id]);
    }

    /**
     * Supprimer un thème
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $sql = "DELETE FROM theme WHERE id_theme = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
