<?php
// router.php for PHP built-in server
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;

// Serve existing files as-is
if (is_file($file)) {
    return false;
}

// Redirect everything else to public/index.php
$_SERVER['SCRIPT_NAME'] = '/public/index.php';
require __DIR__ . '/public/index.php';
