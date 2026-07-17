<?php
declare(strict_types=1);

class UserController extends Controller
{
    public function orders(): void
    {
        $this->requireAuth();
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT c.*, m.titre AS menu_titre, s.libelle AS statut
                               FROM commande c
                               JOIN menu m ON m.id_menu = c.id_menu
                               JOIN statut_commande s ON s.id_statut = c.id_statut
                               WHERE c.id_utilisateur = :id
                               ORDER BY c.date_commande DESC");
        $stmt->execute(['id' => $_SESSION['user']['id']]);
        $this->view('user/orders', ['orders' => $stmt->fetchAll()]);
    }
    public function cancelOrder(): void
    {
        $this->requireAuth();
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE commande
                               SET id_statut = 8
                               WHERE id_commande = :id
                               AND id_utilisateur = :user
                               AND id_statut = 1");
        $stmt->execute([
            'id' => (int)$_POST['id_commande'],
            'user' => $_SESSION['user']['id']
        ]);

        $_SESSION['success'] = 'Demande traitée. Si la commande était encore en attente, elle a été annulée.';
        $this->redirect('/user/orders');
    }

    public function profile(): void
    {
        $this->requireAuth();
        $this->view('user/profile', ['user' => User::find($_SESSION['user']['id'])]);
    }

    public function updateProfile(): void
    {
        $this->requireAuth();
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        User::updateProfile($_SESSION['user']['id'], $_POST);
        $_SESSION['success'] = 'Profil mis à jour.';
        $this->redirect('/user/profile');
    }
}
