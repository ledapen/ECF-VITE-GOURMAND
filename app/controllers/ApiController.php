<?php
declare(strict_types=1);

class ApiController extends Controller
{
    public function menus(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(Menu::all($_GET), JSON_UNESCAPED_UNICODE);
    }
}
