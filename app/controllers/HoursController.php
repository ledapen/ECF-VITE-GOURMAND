<?php
declare(strict_types=1);

class HoursController extends Controller
{
    private function guard(): void
    {
        Security::requireRole(['employe', 'administrateur']);
    }

    public function index(): void
    {
        $this->guard();
        $this->view('employee/hours', ['hours' => Hours::all()]);
    }

    public function update(): void
    {
        $this->guard();
        if (!Security::checkCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(400);
            exit('Jeton CSRF invalide');
        }

        Hours::update($_POST['hours'] ?? []);
        $_SESSION['success'] = 'Horaires mis à jour.';
        $this->redirect('/employee/hours');
    }
}
