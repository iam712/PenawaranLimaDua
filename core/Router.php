<?php
// core/Router.php

class Router {
    private $routes = [];

    public function get($uri, $callback) {
        $this->addRoute('GET', $uri, $callback);
    }

    public function post($uri, $callback) {
        $this->addRoute('POST', $uri, $callback);
    }

    private function addRoute($method, $uri, $callback) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'callback' => $callback
        ];
    }

    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['uri'] === $requestUri) {
                if (is_callable($route['callback'])) {
                    call_user_func($route['callback']);
                } else {
                    $this->callController($route['callback']);
                }
                return;
            }
        }

        // If no route matched, return a 404 response
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }

    private function callController($callback) {
        list($controller, $method) = explode('@', $callback);
        require_once __DIR__ . '/../app/controllers/' . $controller . '.php';
        $controller = new $controller($GLOBALS['db']);
        $controller->$method();
    }
}
