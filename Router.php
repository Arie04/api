<?php

class Router {
    private $routes;
    private $connection;
    private $prefix = 'api/';

    public function __construct($connection, $routes) {
        $this->connection = $connection;
        $this->routes = array_map(function ($route) {
            $route['path'] = $this->prefix . $route['path'];
            return $route;
        }, $routes);
    }

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_-]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if ($method === $route['method'] && preg_match($pattern, $path, $matches)) {
                $controllerName = $route['controller'];
                $actionName = $route['action'];

                $params = array_slice($matches, 1);

                if ($route['requiresToken']) {
                    $headers = getallheaders();
                    $token = str_replace('Bearer ', '', $headers['Authorization'] ?? '');
                    if (empty($token)) {
                        http_response_code(401);
                        echo json_encode(['code' => 401, 'message' => 'Unauthorized access']);
                        return;
                    }
                } else {
                    $token = null;
                }

                $data = null;
                if ($route['requiresBody']) {
                    $data = json_decode(file_get_contents('php://input'), true);
                    if (!$data) {
                        http_response_code(400);
                        echo json_encode(['code' => 400, 'message' => 'Invalid request']);
                        return;
                    }
                }

                if (class_exists($controllerName)) {
                    $controller = new $controllerName($this->connection);
                    if (method_exists($controller, $actionName)) {
                        if ($data) {
                            call_user_func_array([$controller, $actionName], array_merge($params, [$data, $token]));
                        }
                        call_user_func_array([$controller, $actionName], array_merge($params, [$token, $data]));
                        return;
                    } else {
                        http_response_code(404);
                        echo json_encode(['code' => 404, 'message' => 'Action not found.']);
                        return;
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(['code' => 404, 'message' => 'Controller not found.']);
                    return;
                }
            }
        }

        http_response_code(404);
        echo json_encode(['code' => 404, 'message' => 'Route not found.']);
    }
}
