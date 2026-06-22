<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// public/index.php - Front Controller

// Define constants
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . DS . 'app');
define('VIEWS_DIR', APP_DIR . DS . 'Views');

// Dynamically determine BASE_URL
$scriptName = $_SERVER['SCRIPT_NAME'];
$baseDir = dirname(dirname($scriptName));
$baseUrl = str_replace('\\', '/', $baseDir);
if ($baseUrl === '/' || $baseUrl === '.') {
    $baseUrl = '';
}
define('BASE_URL', rtrim($baseUrl, '/'));

// Built-in PHP server routing (if serving static files directly)
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file(__DIR__ . $path)) {
        return false; // serve the requested resource as-is.
    }
}

// Autoloader
spl_autoload_register(function ($class) {
    // Map namespaces or class names to directories
    $directories = [
        APP_DIR . DS . 'Core',
        APP_DIR . DS . 'Controllers',
        APP_DIR . DS . 'Models',
        APP_DIR
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . DS . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Load Configuration
require_once ROOT_DIR . DS . 'config' . DS . 'config.php';

// Route the request
$url = $_GET['url'] ?? null;
if (!$url) {
    // Fallback for built-in PHP server which doesn't use .htaccess
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $basePath = str_replace('/public/index.php', '', $_SERVER['SCRIPT_NAME']);
    // Strip base path from request uri
    if (strpos($requestUri, $basePath) === 0) {
        $url = substr($requestUri, strlen($basePath));
    } else {
        $url = $requestUri;
    }
    // Remove BASE_URL if present
    if (strpos($url, BASE_URL) === 0) {
        $url = substr($url, strlen(BASE_URL));
    }
}

$router = new Router();
$router->dispatch($url ?? 'home/index');
