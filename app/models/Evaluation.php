<?php


/**
 * Modèle Evaluation
 * SAE R307 - Médiathèque
 */

class Evaluation extends Model {
    protected $table = 'evaluation';

    /**
     * Vérifie si un utilisateur a déjà évalué une ressource
     * @param int $idUser ID de l'utilisateur
     * @param int $idRessource ID de la ressource
     * @return bool True si l'utilisateur a déjà évalué
     */
    public function hasUserEvaluated($idUser, $idRessource) {
        $sql = "SELECT COUNT(*) as count FROM evaluation
                WHERE id_utilisateur = ? AND id_ressource = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idUser, $idRessource]);
        $result = $stmt->fetch();

        return $result['count'] > 0;
    }

    /**
     * Créer une nouvelle évaluation
     * @param int $idUser ID de l'utilisateur
     * @param int $idRessource ID de la ressource
     * @param float $note Note (0.0 à 5.0)
     * @param string|null $critique Critique optionnelle
     * @return bool True si création réussie
     * @throws PDOException Si l'évaluation existe déjà (contrainte UNIQUE)
     */
    public function createEvaluation($idUser, $idRessource, $note, $critique = null) {
        $sql = "INSERT INTO evaluation (id_utilisateur, id_ressource, note, critique, date_evaluation)
                VALUES (?, ?, ?, ?, NOW())";

        try {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                $idUser,
                $idRessource,
                $note,
                $critique
            ]);

            return $result;
        } catch (PDOException $e) {
            // Vérifier si c'est une erreur de contrainte UNIQUE
            if ($e->getCode() == '23000') {
                error_log("Tentative d'évaluation en double - User: $idUser, Ressource: $idRessource");
                throw new PDOException("Vous avez déjà évalué cette ressource.");
            }

            // Autre erreur PDO
            error_log("Erreur création évaluation: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Calculer la note moyenne d'une ressource
     * @param int $idRessource ID de la ressource
     * @return float|null Note moyenne (0.0 à 5.0) ou null si aucune évaluation
     */
    public function getAverage($idRessource) {
        $sql = "SELECT AVG(note) as moyenne FROM evaluation
                WHERE id_ressource = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idRessource]);
        $result = $stmt->fetch();

        if ($result['moyenne'] === null) {
            return null;
        }

        return round($result['moyenne'], 1);
    }

    /**
     * Compter le nombre d'évaluations pour une ressource
     * @param int $idRessource ID de la ressource
     * @return int Nombre d'évaluations
     */
    public function countForRessource($idRessource) {
        $sql = "SELECT COUNT(*) as count FROM evaluation
                WHERE id_ressource = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idRessource]);
        $result = $stmt->fetch();

        return (int)$result['count'];
    }

    /**
     * Récupérer toutes les évaluations d'une ressource
     * @param int $idRessource ID de la ressource
     * @return array Liste des évaluations avec informations utilisateur
     */
    public function getByRessource($idRessource) {
        $sql = "SELECT e.*, u.nom, u.prenom
                FROM evaluation e
                JOIN utilisateur u ON e.id_utilisateur = u.id_utilisateur
                WHERE e.id_ressource = ?
                ORDER BY e.date_evaluation DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idRessource]);

        return $stmt->fetchAll();
    }
}
