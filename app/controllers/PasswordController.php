<?php
declare(strict_types=1);

class PasswordController extends Controller
{
    public function forgotForm(): void
    {
        $this->view('auth/forgot');
    }

    public function sendLink(): void
    {
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $token = PasswordReset::create($email);

        if ($token) {
            $url = (getenv('BASE_URL') ?: 'http://localhost:8000') . '/password/reset?email=' . urlencode($email) . '&token=' . urlencode($token);
            MailService::send($email, 'Réinitialisation de mot de passe', "Cliquez sur ce lien : {$url}");
        }

        $_SESSION['success'] = "Si cette adresse existe, un lien de réinitialisation a été envoyé.";
        $this->redirect('/password/forgot');
    }

    public function resetForm(): void
    {
        $this->view('auth/reset');
    }

    public function reset(): void
    {
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!PasswordReset::verify($email, $token)) {
            $_SESSION['error'] = "Lien invalide ou expiré.";
            $this->redirect('/password/forgot');
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{10,}$/', $password)) {
            $_SESSION['error'] = "Le mot de passe ne respecte pas les règles de sécurité.";
            $this->redirect('/password/reset?email=' . urlencode($email) . '&token=' . urlencode($token));
        }

        User::updatePassword($email, $password);
        PasswordReset::delete($email);

        $_SESSION['success'] = "Mot de passe modifié. Vous pouvez vous connecter.";
        $this->redirect('/login');
    }
}
