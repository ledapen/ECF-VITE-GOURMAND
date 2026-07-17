<?php
declare(strict_types=1);

class OrderController extends Controller
{
    public function create(): void
    {
        $this->requireAuth();

        $menuId = (int)($_GET['menu_id'] ?? 0);
        $menu = Menu::find($menuId);

        if (!$menu) {
            http_response_code(404);
            echo 'Menu introuvable';
            return;
        }

        $this->view('orders/create', ['menu' => $menu]);
    }

    public function store(): void
    {
        $this->requireAuth();

        $menu = Menu::find((int)$_POST['id_menu']);
        $nbPersonnes = (int)$_POST['nb_personnes'];

        if ($nbPersonnes < (int)$menu['nb_personnes_min']) {
            $_SESSION['error'] = "Le nombre de personnes doit respecter le minimum du menu.";
            $this->redirect('/orders/create?menu_id=' . $menu['id_menu']);
        }

        $prixParPersonne = (float)$menu['prix_minimum'] / (int)$menu['nb_personnes_min'];
        $prixMenu = $prixParPersonne * $nbPersonnes;

        $reduction = 0;
        if ($nbPersonnes >= ((int)$menu['nb_personnes_min'] + 5)) {
            $reduction = $prixMenu * 0.10;
        }

        $fraisLivraison = strtolower($_POST['ville_livraison']) === 'bordeaux' ? 0 : 5.00;
        $total = $prixMenu + $fraisLivraison - $reduction;

        $created = Order::create([
            'id_utilisateur' => $_SESSION['user']['id'],
            'id_menu' => $menu['id_menu'],
            'date_prestation' => $_POST['date_prestation'],
            'heure_livraison' => $_POST['heure_livraison'],
            'adresse_livraison' => htmlspecialchars($_POST['adresse_livraison']),
            'ville_livraison' => htmlspecialchars($_POST['ville_livraison']),
            'nb_personnes' => $nbPersonnes,
            'prix_menu' => $prixMenu,
            'frais_livraison' => $fraisLivraison,
            'reduction' => $reduction,
            'total' => $total,
        ]);

        if ($created) {
            MailService::orderConfirmation($_SESSION['user']['email'], $menu['titre'], $total);
        }

        $_SESSION['success'] = "Commande enregistrée avec succès.";
        $this->redirect('/menus');
    }
}
