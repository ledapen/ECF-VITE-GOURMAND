<?php
declare(strict_types=1);

class Plate
{
    public static function all(): array
    {
        return Database::getConnection()
            ->query("SELECT * FROM plat ORDER BY type_plat, nom")
            ->fetchAll();
    }

    public static function create(array $data): bool
    {
        $stmt = Database::getConnection()->prepare("INSERT INTO plat (nom, description, type_plat, actif)
                                                    VALUES (:nom, :description, :type_plat, 1)");
        return $stmt->execute([
            'nom' => Security::e($data['nom']),
            'description' => Security::e($data['description'] ?? ''),
            'type_plat' => $data['type_plat']
        ]);
    }

    public static function delete(int $id): bool
    {
        $stmt = Database::getConnection()->prepare("UPDATE plat SET actif = 0 WHERE id_plat = :id");
        return $stmt->execute(['id' => $id]);
    }
}
