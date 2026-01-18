<?php
/**
 * Modèle Ressource
 * SAE R307 - Médiathèque
 */

require_once __DIR__ . '/../../core/Model.php';

class Ressource extends Model {

    /**
     * Récupère toutes les ressources avec informations livre/film
     * @return array Liste des ressources
     */
    public function getAll() {
        $sql = "SELECT
                    r.*,
                    l.isbn, l.editeur, l.nombre_pages, l.prix,
                    f.duree, f.support, f.langue, f.sous_titres, f.propose_par, f.casting
                FROM ressource r
                LEFT JOIN livre l ON r.id_ressource = l.id_ressource
                LEFT JOIN film f ON r.id_ressource = f.id_ressource
                ORDER BY r.date_ajout DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une ressource par ID avec JOIN
     * @param int $id ID ressource
     * @return array|false Données ressource ou false
     */
    public function findById($id) {
        $sql = "SELECT
                    r.*,
                    l.isbn, l.editeur, l.nombre_pages, l.prix,
                    f.duree, f.support, f.langue, f.sous_titres, f.propose_par, f.casting
                FROM ressource r
                LEFT JOIN livre l ON r.id_ressource = l.id_ressource
                LEFT JOIN film f ON r.id_ressource = f.id_ressource
                WHERE r.id_ressource = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Calcule la note moyenne d'une ressource
     * @param int $id ID ressource
     * @return float Note moyenne (0.0 si aucune évaluation)
     */
    public function getAverageRating($id) {
        $sql = "SELECT AVG(note) as moyenne
                FROM evaluation
                WHERE id_ressource = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['moyenne'] ? round($result['moyenne'], 1) : 0.0;
    }

    /**
     * Compte le nombre d'évaluations d'une ressource
     * @param int $id ID ressource
     * @return int Nombre d'évaluations
     */
    public function getEvaluationCount($id) {
        $sql = "SELECT COUNT(*) as total
                FROM evaluation
                WHERE id_ressource = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    /**
     * Récupère les genres d'une ressource
     * @param int $id ID ressource
     * @return array Liste des genres
     */
    public function getGenres($id) {
        $sql = "SELECT g.*
                FROM genre g
                JOIN ressource_genre rg ON g.id_genre = rg.id_genre
                WHERE rg.id_ressource = :id
                ORDER BY g.nom";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les thèmes d'une ressource
     * @param int $id ID ressource
     * @return array Liste des thèmes
     */
    public function getThemes($id) {
        $sql = "SELECT t.*
                FROM theme t
                JOIN ressource_theme rt ON t.id_theme = rt.id_theme
                WHERE rt.id_ressource = :id
                ORDER BY t.nom";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les évaluations d'une ressource avec nom utilisateur
     * @param int $id ID ressource
     * @return array Liste des évaluations
     */
    public function getEvaluations($id) {
        $sql = "SELECT e.*, u.nom, u.prenom
                FROM evaluation e
                JOIN utilisateur u ON e.id_utilisateur = u.id_utilisateur
                WHERE e.id_ressource = :id
                ORDER BY e.date_evaluation DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les ressources les plus récentes (Nouveautés)
     * @param int $limit Nombre de ressources à retourner
     * @return array Liste des nouvelles ressources
     */
    public function getNewest($limit = 10) {
        $sql = "SELECT
                    r.*,
                    l.isbn, l.editeur, l.nombre_pages, l.prix,
                    f.duree, f.support, f.langue, f.sous_titres, f.propose_par, f.casting
                FROM ressource r
                LEFT JOIN livre l ON r.id_ressource = l.id_ressource
                LEFT JOIN film f ON r.id_ressource = f.id_ressource
                ORDER BY r.date_ajout DESC
                LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les ressources les mieux notées (Top)
     * @param int $limit Nombre de ressources à retourner
     * @param int $minEvaluations Nombre minimum d'évaluations requises (0 = inclure les non notées)
     * @return array Liste des ressources avec note_moyenne et nb_evaluations
     */
    public function getTopRated($limit = 10, $minEvaluations = 0) {
        $sql = "SELECT
                    r.*,
                    l.isbn, l.editeur, l.nombre_pages, l.prix,
                    f.duree, f.support, f.langue, f.sous_titres, f.propose_par, f.casting,
                    COALESCE(AVG(e.note), 0) as note_moyenne,
                    COUNT(e.id_evaluation) as nb_evaluations
                FROM ressource r
                LEFT JOIN livre l ON r.id_ressource = l.id_ressource
                LEFT JOIN film f ON r.id_ressource = f.id_ressource
                LEFT JOIN evaluation e ON r.id_ressource = e.id_ressource
                GROUP BY r.id_ressource
                HAVING COUNT(e.id_evaluation) >= :minEval
                ORDER BY note_moyenne DESC, nb_evaluations DESC
                LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':minEval', $minEvaluations, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les ressources d'un thème donné (Sélection)
     * @param int $idTheme ID du thème
     * @return array Liste des ressources du thème
     */
    public function getByTheme($idTheme) {
        $sql = "SELECT
                    r.*,
                    l.isbn, l.editeur, l.nombre_pages, l.prix,
                    f.duree, f.support, f.langue, f.sous_titres, f.propose_par, f.casting
                FROM ressource r
                LEFT JOIN livre l ON r.id_ressource = l.id_ressource
                LEFT JOIN film f ON r.id_ressource = f.id_ressource
                JOIN ressource_theme rt ON r.id_ressource = rt.id_ressource
                WHERE rt.id_theme = :themeId
                ORDER BY r.date_ajout DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['themeId' => $idTheme]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Construit le chemin complet de l'image d'une ressource
     * @param array $ressource Tableau associatif avec 'type' et 'image_url'
     * @return string Chemin complet vers l'image ou le placeholder
     */
    public static function buildImagePath(array $ressource): string {
        // Si image_url est vide ou NULL, utiliser le placeholder
        if (empty($ressource['image_url'])) {
            return 'public/img/placeholders/cover-default.jpg';
        }

        // Construire le chemin selon le type
        $type = $ressource['type'] ?? '';
        $filename = $ressource['image_url'];

        if ($type === 'livre') {
            return 'public/img/livres/' . $filename;
        } elseif ($type === 'film') {
            return 'public/img/films/' . $filename;
        }

        // Fallback au placeholder si type inconnu
        return 'public/img/placeholders/cover-default.jpg';
    }

    /**
     * Recherche multicritère de ressources (Recherche)
     * @param array $criteria Critères de recherche (search, type, genreId, themeId, anneeMin, anneeMax)
     * @return array Liste des ressources correspondantes
     */
    public function search($criteria) {
        $sql = "SELECT
                    r.*,
                    l.isbn, l.editeur, l.nombre_pages, l.prix,
                    f.duree, f.support, f.langue, f.sous_titres, f.propose_par, f.casting
                FROM ressource r
                LEFT JOIN livre l ON r.id_ressource = l.id_ressource
                LEFT JOIN film f ON r.id_ressource = f.id_ressource
                WHERE 1=1";

        $params = [];

        // Recherche textuelle (titre, auteur, résumé)
        if (!empty($criteria['search'])) {
            $sql .= " AND (
                r.titre LIKE :searchTitre
                OR r.auteur_realisateur LIKE :searchAuteur
                OR r.resume LIKE :searchResume
            )";
            $like = '%' . $criteria['search'] . '%';
            $params['searchTitre'] = $like;
            $params['searchAuteur'] = $like;
            $params['searchResume'] = $like;
        }

        // Filtre par type (livre/film)
        if (!empty($criteria['type'])) {
            $sql .= " AND r.type = :type";
            $params['type'] = $criteria['type'];
        }

        // Filtre par genre
        if (!empty($criteria['genreId'])) {
            $sql .= " AND EXISTS (
                SELECT 1 FROM ressource_genre rg
                WHERE rg.id_ressource = r.id_ressource
                AND rg.id_genre = :genreId
            )";
            $params['genreId'] = $criteria['genreId'];
        }

        // Filtre par thème
        if (!empty($criteria['themeId'])) {
            $sql .= " AND EXISTS (
                SELECT 1 FROM ressource_theme rt
                WHERE rt.id_ressource = r.id_ressource
                AND rt.id_theme = :themeId
            )";
            $params['themeId'] = $criteria['themeId'];
        }

        // Filtre par année min
        if (!empty($criteria['anneeMin'])) {
            $sql .= " AND r.annee >= :anneeMin";
            $params['anneeMin'] = $criteria['anneeMin'];
        }

        // Filtre par année max
        if (!empty($criteria['anneeMax'])) {
            $sql .= " AND r.annee <= :anneeMax";
            $params['anneeMax'] = $criteria['anneeMax'];
        }

        $sql .= " ORDER BY r.date_ajout DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
