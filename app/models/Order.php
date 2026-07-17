<?php
declare(strict_types=1);

class Order
{
    public static function create(array $data): bool
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("INSERT INTO commande
            (id_utilisateur, id_menu, id_statut, date_prestation, heure_livraison,
             adresse_livraison, ville_livraison, nb_personnes, prix_menu,
             frais_livraison, reduction, total)
            VALUES
            (:id_utilisateur, :id_menu, 1, :date_prestation, :heure_livraison,
             :adresse_livraison, :ville_livraison, :nb_personnes, :prix_menu,
             :frais_livraison, :reduction, :total)");

        return $stmt->execute($data);
    }
}
