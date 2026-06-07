<?php

class Router {
    public function dispatch($url) {
        $url = trim($url, '/');
        $urlParts = explode('/', $url);
        
        $controllerName = !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'HomeController';
        $methodName = !empty($urlParts[1]) ? $urlParts[1] : 'index';
        
        // Remove controller and method from parts to pass the rest as arguments
        array_shift($urlParts);
        array_shift($urlParts);
        $params = $urlParts;
        
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (method_exists($controller, $methodName)) {
                call_user_func_array([$controller, $methodName], $params);
            } else {
                $this->notFound("Method $methodName not found in controller $controllerName");
            }
        } else {
            $this->notFound("Controller $controllerName not found");
        }
    }
    
    private function notFound($message = "Page not found") {
        http_response_code(404);
        echo "<h2>404 Not Found</h2>";
        echo "<p>" . htmlspecialchars($message) . "</p>";
        exit;
    }
}
