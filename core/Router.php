<?php
class Router {
    private $routes = [
        'GET' => [],
        'POST' => []
    ];

    // Definisanje GET rute
    public function get($path, $action) {
        $this->routes['GET'][$path] = $action;
    }

    // Definisanje POST rute
    public function post($path, $action) {
        $this->routes['POST'][$path] = $action;
    }

    // Pokretanje rutera
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $uri = str_replace('/SalaHub/public', '', $uri);


        // ukloni trailing slash ako postoji
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }

        $action = $this->routes[$method][$uri] ?? null;

        if (!$action) {
            http_response_code(404);
            echo "<h2 style='font-family:sans-serif;text-align:center;margin-top:50px;'>404 - Stranica nije pronađena</h2>";
            return;
        }

        list($controller, $methodName) = explode('@', $action);

        $controllerPath = __DIR__ . '/../app/Controllers/' . $controller . '.php';
        if (!file_exists($controllerPath)) {
            die("Controller $controller ne postoji.");
        }

        require_once $controllerPath;

        if (!class_exists($controller)) {
            die("Klasa $controller nije pronađena u $controllerPath.");
        }

        $controllerInstance = new $controller();

        if (!method_exists($controllerInstance, $methodName)) {
            die("Metoda $methodName ne postoji u kontroleru $controller.");
        }

        $controllerInstance->$methodName();
    }
}
?>
