<?php
declare(strict_types=1);

class Menu
{
    public static function all(array $filters = []): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT m.*, t.libelle AS theme, r.libelle AS regime
                FROM menu m
                JOIN theme t ON t.id_theme = m.id_theme
                JOIN regime r ON r.id_regime = m.id_regime
                WHERE m.actif = 1";
        $params = [];

        if (!empty($filters['prix_max'])) {
            $sql .= " AND m.prix_minimum <= :prix_max";
            $params['prix_max'] = $filters['prix_max'];
        }

        if (!empty($filters['theme'])) {
            $sql .= " AND t.libelle = :theme";
            $params['theme'] = $filters['theme'];
        }

        if (!empty($filters['regime'])) {
            $sql .= " AND r.libelle = :regime";
            $params['regime'] = $filters['regime'];
        }

        if (!empty($filters['personnes'])) {
            $sql .= " AND m.nb_personnes_min <= :personnes";
            $params['personnes'] = $filters['personnes'];
        }

        $sql .= " ORDER BY m.titre ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT m.*, t.libelle AS theme, r.libelle AS regime
                               FROM menu m
                               JOIN theme t ON t.id_theme = m.id_theme
                               JOIN regime r ON r.id_regime = m.id_regime
                               WHERE m.id_menu = :id");
        $stmt->execute(['id' => $id]);
        $menu = $stmt->fetch();

        return $menu ?: null;
    }
    public static function create(array $data): int
    {
        $stmt = Database::getConnection()->prepare("INSERT INTO menu
            (id_theme, id_regime, titre, description, nb_personnes_min, prix_minimum, conditions_menu, stock_disponible, actif)
            VALUES (:theme, :regime, :titre, :description, :min, :prix, :conditions, :stock, 1)");
        $stmt->execute([
            'theme' => (int)$data['id_theme'],
            'regime' => (int)$data['id_regime'],
            'titre' => Security::e($data['titre']),
            'description' => Security::e($data['description']),
            'min' => (int)$data['nb_personnes_min'],
            'prix' => (float)$data['prix_minimum'],
            'conditions' => Security::e($data['conditions_menu']),
            'stock' => (int)$data['stock_disponible'],
        ]);
        return (int)Database::getConnection()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $stmt = Database::getConnection()->prepare("UPDATE menu SET
            id_theme = :theme,
            id_regime = :regime,
            titre = :titre,
            description = :description,
            nb_personnes_min = :min,
            prix_minimum = :prix,
            conditions_menu = :conditions,
            stock_disponible = :stock,
            actif = :actif
            WHERE id_menu = :id");
        return $stmt->execute([
            'id' => $id,
            'theme' => (int)$data['id_theme'],
            'regime' => (int)$data['id_regime'],
            'titre' => Security::e($data['titre']),
            'description' => Security::e($data['description']),
            'min' => (int)$data['nb_personnes_min'],
            'prix' => (float)$data['prix_minimum'],
            'conditions' => Security::e($data['conditions_menu']),
            'stock' => (int)$data['stock_disponible'],
            'actif' => isset($data['actif']) ? 1 : 0
        ]);
    }

    public static function softDelete(int $id): bool
    {
        $stmt = Database::getConnection()->prepare("UPDATE menu SET actif = 0 WHERE id_menu = :id");
        return $stmt->execute(['id' => $id]);
    }

    public static function addImage(int $menuId, string $url, string $alt): void
    {
        $stmt = Database::getConnection()->prepare("INSERT INTO image_menu (id_menu, url_image, texte_alternatif)
                                                    VALUES (:menu, :url, :alt)");
        $stmt->execute([
            'menu' => $menuId,
            'url' => $url,
            'alt' => $alt
        ]);
    }
}
