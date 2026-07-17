<?php
declare(strict_types=1);

class EmployeeController extends Controller
{
    private function guard(): void
    {
        Security::requireRole(['employe', 'administrateur']);
    }

    public function dashboard(): void
    {
        $this->guard();
        $this->view('employee/dashboard');
    }

    public function menus(): void
    {
        $this->guard();
        $this->view('employee/menus', ['menus' => Menu::all()]);
    }

    public function createMenu(): void
    {
        $this->guard();
        $this->view('employee/menu_create');
    }

    public function storeMenu(): void
    {
        $this->guard();
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        $menuId = Menu::create($_POST);

        if (!empty($_FILES['image']['name'])) {
            $this->uploadMenuImage($menuId, $_FILES['image'], $_POST['titre']);
        }

        $_SESSION['success'] = 'Menu créé avec succès.';
        $this->redirect('/employee/menus');
    }

    public function orders(): void
    {
        $this->guard();
        $pdo = Database::getConnection();
        $orders = $pdo->query("SELECT c.*, u.email, m.titre AS menu_titre, s.libelle AS statut
                               FROM commande c
                               JOIN utilisateur u ON u.id_utilisateur = c.id_utilisateur
                               JOIN menu m ON m.id_menu = c.id_menu
                               JOIN statut_commande s ON s.id_statut = c.id_statut
                               ORDER BY c.date_prestation ASC")->fetchAll();
        $statuses = $pdo->query("SELECT * FROM statut_commande ORDER BY ordre_affichage")->fetchAll();
        $this->view('employee/orders', ['orders' => $orders, 'statuses' => $statuses]);
    }

    public function updateOrderStatus(): void
    {
        $this->guard();
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE commande SET id_statut = :statut WHERE id_commande = :commande");
        $stmt->execute(['statut' => (int)$_POST['id_statut'], 'commande' => (int)$_POST['id_commande']]);

        $hist = $pdo->prepare("INSERT INTO historique_statut (id_commande, id_statut, id_utilisateur, commentaire)
                               VALUES (:commande, :statut, :user, :commentaire)");
        $hist->execute([
            'commande' => (int)$_POST['id_commande'],
            'statut' => (int)$_POST['id_statut'],
            'user' => $_SESSION['user']['id'],
            'commentaire' => Security::e($_POST['commentaire'] ?? 'Mise à jour du statut')
        ]);

        $_SESSION['success'] = 'Statut mis à jour.';
        $this->redirect('/employee/orders');
    }
    public function editMenu(): void
    {
        $this->guard();
        $menu = Menu::find((int)($_GET['id'] ?? 0));
        if (!$menu) {
            http_response_code(404);
            exit('Menu introuvable');
        }
        $this->view('employee/menu_edit', ['menu' => $menu]);
    }

    public function updateMenu(): void
    {
        $this->guard();
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        $id = (int)$_POST['id_menu'];
        Menu::update($id, $_POST);

        if (!empty($_FILES['image']['name'])) {
            $this->uploadMenuImage($id, $_FILES['image'], $_POST['titre']);
        }

        $_SESSION['success'] = 'Menu mis à jour.';
        $this->redirect('/employee/menus');
    }

    public function deleteMenu(): void
    {
        $this->guard();
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        Menu::softDelete((int)$_POST['id_menu']);
        $_SESSION['success'] = 'Menu désactivé.';
        $this->redirect('/employee/menus');
    }

    private function uploadMenuImage(int $menuId, array $file, string $title): void
    {
        $config = require __DIR__ . '/../config/config.php';
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];

        if (!isset($allowed[$file['type']])) {
            return;
        }

        $name = 'menu_' . $menuId . '_' . time() . '.' . $allowed[$file['type']];
        $target = $config['upload_dir'] . '/' . $name;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            Menu::addImage($menuId, $config['upload_url'] . '/' . $name, 'Image du menu ' . $title);
        }
    }

    public function contacts(): void
    {
        $this->guard();
        $contacts = Database::getConnection()
            ->query("SELECT * FROM contact ORDER BY date_envoi DESC")
            ->fetchAll();
        $this->view('employee/contacts', ['contacts' => $contacts]);
    }

    public function markContactTreated(): void
    {
        $this->guard();
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        $stmt = Database::getConnection()->prepare("UPDATE contact SET traite = 1 WHERE id_contact = :id");
        $stmt->execute(['id' => (int)$_POST['id_contact']]);
        $_SESSION['success'] = 'Demande marquée comme traitée.';
        $this->redirect('/employee/contacts');
    }

    public function reviews(): void
    {
        $this->guard();
        $pdo = Database::getConnection();
        $reviews = $pdo->query("SELECT a.*, u.email, m.titre AS menu_titre
                                FROM avis a
                                JOIN utilisateur u ON u.id_utilisateur = a.id_utilisateur
                                JOIN commande c ON c.id_commande = a.id_commande
                                JOIN menu m ON m.id_menu = c.id_menu
                                ORDER BY a.date_avis DESC")->fetchAll();
        $this->view('employee/reviews', ['reviews' => $reviews]);
    }

    public function validateReview(): void
    {
        $this->guard();
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE avis SET valide = :valide WHERE id_avis = :id");
        $stmt->execute([
            'valide' => (int)$_POST['valide'],
            'id' => (int)$_POST['id_avis']
        ]);

        $_SESSION['success'] = 'Avis mis à jour.';
        $this->redirect('/employee/reviews');
    }

}
