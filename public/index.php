<?php
require_once(__DIR__ . '/../vendor/autoload.php');

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

session_start();

$months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) use ($months) {
    $r->get('/', '\Fruits\Controllers\FruitController::month');
    $r->get('/about', '\Fruits\Controllers\PageController::about');
    $r->get('/all', '\Fruits\Controllers\FruitController::all');
    $r->get('/{var:' . implode('|', $months) . '}', '\Fruits\Controllers\FruitController::month');
    $r->get('/{name:.*}', '\Fruits\Controllers\FruitController::show');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri        = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo 'not found'; exit;
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo 'not allowed'; exit;
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars    = $routeInfo[2];

        list($class, $method) = explode('::', $handler, 2);
        echo call_user_func_array([new $class, $method], $vars);

        break;
}

