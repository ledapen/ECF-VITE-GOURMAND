<?php
declare(strict_types=1);

class AdminController extends Controller
{
    private function guard(): void
    {
        Security::requireRole(['administrateur']);
    }

    public function dashboard(): void
    {
        $this->guard();
        $this->view('admin/dashboard', ['stats' => AdminStats::revenueByMenu()]);
    }

    public function employees(): void
    {
        $this->guard();
        $this->view('admin/employees', ['employees' => Employee::all()]);
    }

    public function storeEmployee(): void
    {
        $this->guard();
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        Employee::create($_POST);
        $_SESSION['success'] = 'Compte employé créé.';
        $this->redirect('/admin/employees');
    }

    public function toggleEmployee(): void
    {
        $this->guard();
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        Employee::toggle((int)$_POST['id_utilisateur']);
        $_SESSION['success'] = 'Statut du compte employé modifié.';
        $this->redirect('/admin/employees');
    }
    public function statsJson(): void
    {
        $this->guard();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(AdminStats::revenueByMenu(), JSON_UNESCAPED_UNICODE);
    }
}
