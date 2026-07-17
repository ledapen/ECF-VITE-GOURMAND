<?php
declare(strict_types=1);

class User
{
    public static function findByEmail(string $email): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT u.*, r.libelle AS role
                               FROM utilisateur u
                               JOIN role r ON r.id_role = u.id_role
                               WHERE u.email = :email AND u.actif = 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public static function create(array $data): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO utilisateur
            (id_role, nom, prenom, email, telephone, adresse, mot_de_passe_hash)
            VALUES (3, :nom, :prenom, :email, :telephone, :adresse, :password)");

        return $stmt->execute([
            'nom' => htmlspecialchars($data['nom']),
            'prenom' => htmlspecialchars($data['prenom']),
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            'telephone' => htmlspecialchars($data['telephone']),
            'adresse' => htmlspecialchars($data['adresse']),
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ]);
    }
    public static function updatePassword(string $email, string $password): bool
    {
        $stmt = Database::getConnection()->prepare("UPDATE utilisateur
                                                    SET mot_de_passe_hash = :password
                                                    WHERE email = :email");
        return $stmt->execute([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public static function updateProfile(int $id, array $data): bool
    {
        $stmt = Database::getConnection()->prepare("UPDATE utilisateur
            SET nom = :nom, prenom = :prenom, telephone = :telephone, adresse = :adresse
            WHERE id_utilisateur = :id");
        return $stmt->execute([
            'id' => $id,
            'nom' => Security::e($data['nom']),
            'prenom' => Security::e($data['prenom']),
            'telephone' => Security::e($data['telephone']),
            'adresse' => Security::e($data['adresse'])
        ]);
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
}
