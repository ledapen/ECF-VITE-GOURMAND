<?php
declare(strict_types=1);

class PlateController extends Controller
{
    private function guard(): void
    {
        Security::requireRole(['employe', 'administrateur']);
    }

    public function index(): void
    {
        $this->guard();
        $this->view('employee/plates', ['plates' => Plate::all()]);
    }

    public function store(): void
    {
        $this->guard();
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        Plate::create($_POST);
        $_SESSION['success'] = 'Plat créé.';
        $this->redirect('/employee/plates');
    }

    public function delete(): void
    {
        $this->guard();
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        Plate::delete((int)$_POST['id_plat']);
        $_SESSION['success'] = 'Plat désactivé.';
        $this->redirect('/employee/plates');
    }
}
