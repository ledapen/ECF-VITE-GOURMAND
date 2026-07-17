<?php
declare(strict_types=1);

class Employee
{
    public static function all(): array
    {
        $pdo = Database::getConnection();
        return $pdo->query("SELECT u.*, r.libelle AS role
                            FROM utilisateur u
                            JOIN role r ON r.id_role = u.id_role
                            WHERE r.libelle = 'employe'
                            ORDER BY u.date_creation DESC")->fetchAll();
    }

    public static function create(array $data): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO utilisateur
            (id_role, nom, prenom, email, telephone, adresse, mot_de_passe_hash, actif)
            VALUES (2, :nom, :prenom, :email, :telephone, :adresse, :password, 1)");

        return $stmt->execute([
            'nom' => Security::e($data['nom']),
            'prenom' => Security::e($data['prenom']),
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            'telephone' => Security::e($data['telephone'] ?? '0000000000'),
            'adresse' => Security::e($data['adresse'] ?? 'Vite & Gourmand, Bordeaux'),
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ]);
    }

    public static function toggle(int $id): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE utilisateur SET actif = NOT actif WHERE id_utilisateur = :id AND id_role = 2");
        return $stmt->execute(['id' => $id]);
    }
}
