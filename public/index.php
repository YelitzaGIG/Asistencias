<?php
// ============================================================
// public/index.php — Front Controller (punto de entrada único)
// ============================================================

define('ROOT', dirname(__DIR__));

// Cargar configuraciones
require_once ROOT . '/config/app.php';
require_once ROOT . '/config/database.php';

// Autoloader simple para modelos y controladores
spl_autoload_register(function (string $class): void {
    $paths = [
        ROOT . '/app/controllers/' . $class . '.php',
        ROOT . '/app/models/'      . $class . '.php',
        ROOT . '/app/core/'        . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Iniciar sesión
session_name(SESSION_NAME);
session_start();

// ── Router simple ──────────────────────────────
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base   = rtrim(str_replace('/public', '', dirname($_SERVER['SCRIPT_NAME'])), '/');
$route  = trim(str_replace($base, '', $uri), '/');
$parts  = explode('/', $route);

$controllerName = !empty($parts[0]) ? ucfirst(strtolower($parts[0])) . 'Controller' : 'AuthController';
$action         = !empty($parts[1]) ? strtolower($parts[1]) : 'index';
$param          = $parts[2] ?? null;

// Mapa de rutas permitidas
$routes = [
    'AuthController'          => ['index', 'login', 'logout', 'register', 'registerpost', 'forgotpassword', 'resetpassword', 'resetpost'],
    'DashboardController'     => ['index', 'perfil'],
    'JustificantesController' => ['index', 'create', 'store', 'show', 'edit', 'update', 'delete'],
];

// Resolver controlador
if (!isset($routes[$controllerName])) {
    $controllerName = 'AuthController';
    $action = 'index';
}
if (!in_array($action, $routes[$controllerName])) {
    $action = 'index';
}

$controllerFile = ROOT . '/app/controllers/' . $controllerName . '.php';
if (!file_exists($controllerFile)) {
    http_response_code(404);
    echo 'Controlador no encontrado.';
    exit;
}

require_once $controllerFile;
$controller = new $controllerName();
$controller->$action($param);
