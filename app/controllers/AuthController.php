<?php
declare(strict_types=1);

class AuthController extends Controller
{
    public function loginForm(): void
    {
        $this->view('auth/login');
    }

    public function login(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['mot_de_passe_hash'])) {
            $_SESSION['error'] = "Identifiants incorrects.";
            $this->redirect('/login');
        }

        $_SESSION['user'] = [
            'id' => $user['id_utilisateur'],
            'email' => $user['email'],
            'role' => $user['role'],
            'prenom' => $user['prenom'],
        ];

        $this->redirect('/');
    }

    public function registerForm(): void
    {
        $this->view('auth/register');
    }

    public function register(): void
    {
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        $password = $_POST['password'] ?? '';

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{10,}$/', $password)) {
            $_SESSION['error'] = "Le mot de passe doit contenir 10 caractères minimum, une majuscule, une minuscule, un chiffre et un caractère spécial.";
            $this->redirect('/register');
        }

        User::create($_POST);
        MailService::welcome($_POST['email'], $_POST['prenom']);
        $_SESSION['success'] = "Compte créé avec succès.";
        $this->redirect('/login');
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/');
    }
}
