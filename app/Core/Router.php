<?php
// app/Core/Router.php

class Router {
    private $routes = [];

    public function add($method, $route, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch($url) {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'];

        // Remove base path if necessary, but with built-in server, path is root-relative
        // For simplicity, assume $path starts with /

        foreach ($this->routes as $route) {
            if ($route['method'] == $requestMethod) {
                $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $route['route']);
                $pattern = "@^" . $pattern . "$@D";

                if (preg_match($pattern, $path, $matches)) {
                    $controllerName = $route['controller'];
                    $actionName = $route['action'];

                    require_once '../app/Controllers/' . $controllerName . '.php';
                    $controller = new $controllerName();

                    $params = [];
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            $params[$key] = $value;
                        }
                    }

                    call_user_func_array([$controller, $actionName], $params);
                    return;
                }
            }
        }

        // Handle 404
        http_response_code(404);
        echo "404 Not Found";
    }
}
