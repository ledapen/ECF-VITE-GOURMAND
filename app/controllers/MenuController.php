<?php
declare(strict_types=1);

class MenuController extends Controller
{
    public function index(): void
    {
        $menus = Menu::all($_GET);
        $this->view('menus/index', ['menus' => $menus]);
    }

    public function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $menu = Menu::find($id);

        if (!$menu) {
            http_response_code(404);
            echo 'Menu introuvable';
            return;
        }

        $this->view('menus/show', ['menu' => $menu]);
    }
}
