<?php

// Definir la ruta base si no está definida (cuando se accede directamente)
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2));
}

// Cargar autoloader de Composer
require_once BASE_PATH . '/vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Iniciar sesión
session_start();

// Inicializar sistema de internacionalización
App\config\I18n::init();

// Configuración de errores
if (config('app.debug')) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// Router básico
$request = $_SERVER['REQUEST_URI'];
$basePath = config('app.base_path', ''); // Path base de la URL

// Eliminar el path base de la URL
if (!empty($basePath)) {
    $request = str_replace($basePath, '', $request);
}

// Cambio de idioma
if (isset($_GET['lang']) && in_array($_GET['lang'], ['es', 'en'])) {
    App\config\I18n::setLocale($_GET['lang']);
    
    // Redirigir a la misma página sin el parámetro de idioma
    $redirectUrl = strtok($request, '?');
    redirect($redirectUrl);
}

// Routing básico
switch ($request) {
    case '':
    case '/':
        require BASE_PATH . '/src/views/dashboard.php';
        break;
    case '/invoices':
        require BASE_PATH . '/src/views/invoices.php';
        break;
    case '/clients':
        require BASE_PATH . '/src/views/clients.php';
        break;
    case '/accounting':
        require BASE_PATH . '/src/views/accounting.php';
        break;
    default:
        http_response_code(404);
        require BASE_PATH . '/src/views/404.php';
        break;
} 