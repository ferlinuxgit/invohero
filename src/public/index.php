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

// Obtener la ruta base desde la configuración
$basePath = config('app.base_path', '');

// Eliminar parámetros GET de la URL
$uri = parse_url($request, PHP_URL_PATH);

// Eliminar el path base de la URL si existe
if (!empty($basePath) && strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

// Asegurarse de que la URI comienza con /
$uri = '/' . ltrim($uri, '/');

// Cambio de idioma
if (isset($_GET['lang']) && in_array($_GET['lang'], ['es', 'en'])) {
    App\config\I18n::setLocale($_GET['lang']);
    
    // Redirigir a la misma página sin el parámetro de idioma
    $redirectUrl = $uri;
    redirect($redirectUrl);
}

// Routing básico
switch ($uri) {
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
        // Comprobar si es un archivo estático en la carpeta public
        $publicPath = __DIR__ . parse_url($uri, PHP_URL_PATH);
        if (file_exists($publicPath) && is_file($publicPath)) {
            // Es un archivo estático, servir directamente
            $ext = pathinfo($publicPath, PATHINFO_EXTENSION);
            $contentTypes = [
                'css' => 'text/css',
                'js' => 'application/javascript',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'svg' => 'image/svg+xml',
            ];
            
            if (isset($contentTypes[$ext])) {
                header('Content-Type: ' . $contentTypes[$ext]);
            }
            
            readfile($publicPath);
            exit;
        }
        
        // No es un archivo estático, mostrar error 404
        http_response_code(404);
        require BASE_PATH . '/src/views/404.php';
        break;
} 