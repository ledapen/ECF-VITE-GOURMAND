<?php
declare(strict_types=1);

function assertEquals($expected, $actual, string $message): void {
    if ($expected !== $actual) {
        echo "ECHEC: $message\n";
        echo "Attendu: " . var_export($expected, true) . "\n";
        echo "Obtenu: " . var_export($actual, true) . "\n";
        exit(1);
    }
}

function computeOrder(float $prixMinimum, int $minimum, int $personnes, string $ville): array {
    if ($personnes < $minimum) {
        throw new InvalidArgumentException("Minimum non respecté");
    }

    $prixParPersonne = $prixMinimum / $minimum;
    $prixMenu = $prixParPersonne * $personnes;
    $reduction = $personnes >= ($minimum + 5) ? $prixMenu * 0.10 : 0.0;
    $livraison = strtolower($ville) === 'bordeaux' ? 0.0 : 5.0;
    $total = $prixMenu + $livraison - $reduction;

    return [
        'prix_menu' => round($prixMenu, 2),
        'reduction' => round($reduction, 2),
        'livraison' => round($livraison, 2),
        'total' => round($total, 2)
    ];
}

$result = computeOrder(120.00, 4, 9, 'Bordeaux');
assertEquals(270.00, $result['prix_menu'], 'Prix menu 9 personnes');
assertEquals(27.00, $result['reduction'], 'Réduction 10 %');
assertEquals(0.00, $result['livraison'], 'Livraison Bordeaux gratuite');
assertEquals(243.00, $result['total'], 'Total avec réduction');

$result = computeOrder(120.00, 4, 4, 'Paris');
assertEquals(5.00, $result['livraison'], 'Frais hors Bordeaux');

try {
    computeOrder(120.00, 4, 3, 'Bordeaux');
    echo "ECHEC: minimum non vérifié\n";
    exit(1);
} catch (InvalidArgumentException $e) {
    echo "OK business rules\n";
}
