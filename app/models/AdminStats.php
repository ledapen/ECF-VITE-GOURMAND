<?php
declare(strict_types=1);

class AdminStats
{
    public static function revenueByMenu(): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT m.titre, COUNT(c.id_commande) AS nombre_commandes, COALESCE(SUM(c.total), 0) AS chiffre_affaires
                FROM menu m
                LEFT JOIN commande c ON c.id_menu = m.id_menu
                GROUP BY m.id_menu, m.titre
                ORDER BY chiffre_affaires DESC";
        return $pdo->query($sql)->fetchAll();
    }
}
