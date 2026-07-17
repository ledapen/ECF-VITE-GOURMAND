<?php
declare(strict_types=1);

class Router
{
    private array $routes = [];

    public function get(string $path, array $action): void
    {
        $this->routes['GET'][$path] = $action;
    }

    public function post(string $path, array $action): void
    {
        $this->routes['POST'][$path] = $action;
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);

        if (!isset($this->routes[$method][$path])) {
            http_response_code(404);
            echo 'Page introuvable';
            return;
        }

        [$controllerClass, $methodName] = $this->routes[$method][$path];
        $controller = new $controllerClass();
        $controller->$methodName();
    }
}
