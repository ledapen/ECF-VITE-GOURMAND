<?php
declare(strict_types=1);

class ContactController extends Controller
{
    public function form(): void
    {
        $this->view('home/contact');
    }

    public function send(): void
    {
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO contact (titre, email, description, traite)
                               VALUES (:titre, :email, :description, 0)");
        $stmt->execute([
            'titre' => Security::e($_POST['titre']),
            'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
            'description' => Security::e($_POST['description'])
        ]);

        MailService::send('contact@vitegourmand.fr', 'Nouvelle demande de contact', $_POST['description']);

        $_SESSION['success'] = "Votre demande de contact a bien été envoyée.";
        $this->redirect('/contact');
    }
}
