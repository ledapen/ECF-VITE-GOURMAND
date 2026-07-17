<?php
declare(strict_types=1);

class Hours
{
    public static function all(): array
    {
        return Database::getConnection()
            ->query("SELECT * FROM horaire ORDER BY id_horaire")
            ->fetchAll();
    }

    public static function update(array $rows): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE horaire
                               SET heure_ouverture = :ouverture,
                                   heure_fermeture = :fermeture,
                                   ferme = :ferme
                               WHERE id_horaire = :id");

        foreach ($rows as $id => $row) {
            $ferme = isset($row['ferme']) ? 1 : 0;
            $stmt->execute([
                'id' => (int)$id,
                'ouverture' => $ferme ? null : ($row['ouverture'] ?: null),
                'fermeture' => $ferme ? null : ($row['fermeture'] ?: null),
                'ferme' => $ferme
            ]);
        }
    }
}
