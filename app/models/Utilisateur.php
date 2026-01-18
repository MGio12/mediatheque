<?php
/**
 * Modèle Utilisateur
 * SAE R307 - Médiathèque
 */

class Utilisateur extends Model {
    protected $table = 'utilisateur';

    /**
     * Recherche un utilisateur par email
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM utilisateur WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Créer un nouvel utilisateur
     */
    public function createUser($data) {
        $sql = "INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, role)
                VALUES (:nom, :prenom, :email, :mot_de_passe, :role)";

        $stmt = $this->pdo->prepare($sql);

        $result = $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'mot_de_passe' => password_hash($data['mot_de_passe'], PASSWORD_DEFAULT),
            'role' => $data['role'] ?? 'utilisateur'
        ]);

        if ($result) {
            return [
                'id_utilisateur' => $this->pdo->lastInsertId(),
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email'],
                'role' => $data['role'] ?? 'utilisateur'
            ];
        }

        return false;
    }

    /**
     * Vérifier les identifiants de connexion
     */
    public function verifyCredentials($email, $password) {
    $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        return $user;
    }

    return false;
}

}
