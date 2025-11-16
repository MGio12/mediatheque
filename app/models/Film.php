<?php
/**
 * Modèle Film
 * SAE R307 - Médiathèque
 */

require_once __DIR__ . '/Ressource.php';

class Film extends Model {
    protected $table = 'film';

    /**
     * Récupère tous les films avec infos ressource
     * @return array
     */
    public function getAllWithDetails() {
        $sql = "SELECT r.*, f.duree, f.support, f.langue
                FROM ressource r
                JOIN film f ON r.id_ressource = f.id_ressource
                WHERE r.type = 'film'
                ORDER BY r.date_ajout DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un film par ID avec détails
     * @param int $id
     * @return array|false
     */
    public function findByIdWithDetails($id) {
        $sql = "SELECT r.*, f.duree, f.support, f.langue
                FROM ressource r
                JOIN film f ON r.id_ressource = f.id_ressource
                WHERE r.id_ressource = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les IDs des genres d'un film
     * @param int $id
     * @return array
     */
    public function getGenreIds($id) {
        $sql = "SELECT id_genre FROM ressource_genre WHERE id_ressource = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Récupère les IDs des thèmes d'un film
     * @param int $id
     * @return array
     */
    public function getThemeIds($id) {
        $sql = "SELECT id_theme FROM ressource_theme WHERE id_ressource = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Créer un film (avec transaction)
     * @param array $dataRessource
     * @param array $dataFilm
     * @param array $genreIds
     * @param array $themeIds
     * @return int ID ressource créé
     * @throws PDOException
     */
    public function create($data) {
        $dataRessource = $data['ressource'] ?? [];
        $dataFilm = $data['film'] ?? [];
        $genreIds = $data['genres'] ?? [];
        $themeIds = $data['themes'] ?? [];

        try {
            $this->pdo->beginTransaction();

            // 1. Insérer ressource
            $sql = "INSERT INTO ressource (type, titre, auteur_realisateur, annee, resume, image_url)
                    VALUES ('film', ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $dataRessource['titre'],
                $dataRessource['auteur_realisateur'],
                $dataRessource['annee'],
                $dataRessource['resume'] ?? null,
                $dataRessource['image_url'] ?? null
            ]);
            $idRessource = $this->pdo->lastInsertId();

            // 2. Insérer film
            $sql = "INSERT INTO film (id_ressource, duree, support, langue)
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $idRessource,
                $dataFilm['duree'],
                $dataFilm['support'],
                $dataFilm['langue']
            ]);

            // 3. Insérer genres
            if (!empty($genreIds)) {
                $sql = "INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (?, ?)";
                $stmt = $this->pdo->prepare($sql);
                foreach ($genreIds as $gid) {
                    $stmt->execute([$idRessource, $gid]);
                }
            }

            // 4. Insérer thèmes
            if (!empty($themeIds)) {
                $sql = "INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (?, ?)";
                $stmt = $this->pdo->prepare($sql);
                foreach ($themeIds as $tid) {
                    $stmt->execute([$idRessource, $tid]);
                }
            }

            $this->pdo->commit();
            return $idRessource;

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Erreur création film: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Modifier un film (avec transaction)
     * @param int $id
     * @param array $dataRessource
     * @param array $dataFilm
     * @param array $genreIds
     * @param array $themeIds
     * @return bool
     * @throws PDOException
     */
    public function update($id, $data) {
        $dataRessource = $data['ressource'] ?? [];
        $dataFilm = $data['film'] ?? [];
        $genreIds = $data['genres'] ?? [];
        $themeIds = $data['themes'] ?? [];

        try {
            $this->pdo->beginTransaction();

            // 1. Mettre à jour ressource
            $sql = "UPDATE ressource
                    SET titre = ?, auteur_realisateur = ?, annee = ?,
                        resume = ?, image_url = ?
                    WHERE id_ressource = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $dataRessource['titre'],
                $dataRessource['auteur_realisateur'],
                $dataRessource['annee'],
                $dataRessource['resume'] ?? null,
                $dataRessource['image_url'] ?? null,
                $id
            ]);

            // 2. Mettre à jour film
            $sql = "UPDATE film
                    SET duree = ?, support = ?, langue = ?
                    WHERE id_ressource = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $dataFilm['duree'],
                $dataFilm['support'],
                $dataFilm['langue'],
                $id
            ]);

            // 3. Supprimer puis réinsérer genres
            $sql = "DELETE FROM ressource_genre WHERE id_ressource = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);

            if (!empty($genreIds)) {
                $sql = "INSERT INTO ressource_genre (id_ressource, id_genre) VALUES (?, ?)";
                $stmt = $this->pdo->prepare($sql);
                foreach ($genreIds as $gid) {
                    $stmt->execute([$id, $gid]);
                }
            }

            // 4. Supprimer puis réinsérer thèmes
            $sql = "DELETE FROM ressource_theme WHERE id_ressource = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);

            if (!empty($themeIds)) {
                $sql = "INSERT INTO ressource_theme (id_ressource, id_theme) VALUES (?, ?)";
                $stmt = $this->pdo->prepare($sql);
                foreach ($themeIds as $tid) {
                    $stmt->execute([$id, $tid]);
                }
            }

            $this->pdo->commit();
            return true;

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Erreur modification film: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Supprimer un film (CASCADE auto)
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        // La suppression de ressource déclenche CASCADE pour film + relations
        $sql = "DELETE FROM ressource WHERE id_ressource = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
