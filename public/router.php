<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$path = rawurldecode($path);

$aliases = [
    '/catalogocompleto.php' => '/Catalogocompleto.php',
];

if (isset($aliases[$path])) {
    header('Location: ' . $aliases[$path], true, 301);
    exit();
}

$file = __DIR__ . $path;

if ($path !== '/' && is_file($file)) {
    return false;
}

if ($path === '/') {
    require __DIR__ . '/index.php';
    exit();
}

http_response_code(404);
echo 'Not Found';
