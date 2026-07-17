<?php
declare(strict_types=1);

class ReviewController extends Controller
{
    public function store(): void
    {
        $this->requireAuth();

        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        $note = (int)$_POST['note'];
        if ($note < 1 || $note > 5) {
            $_SESSION['error'] = 'La note doit être comprise entre 1 et 5.';
            $this->redirect('/user/orders');
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO avis (id_commande, id_utilisateur, note, commentaire, valide)
                               VALUES (:commande, :user, :note, :commentaire, 0)");
        $stmt->execute([
            'commande' => (int)$_POST['id_commande'],
            'user' => $_SESSION['user']['id'],
            'note' => $note,
            'commentaire' => Security::e($_POST['commentaire'])
        ]);

        $_SESSION['success'] = 'Votre avis a été envoyé et sera visible après validation.';
        $this->redirect('/user/orders');
    }
}
