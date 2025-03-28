<?php
/**
 * Archivo de entrada principal de la aplicación
 */

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

// Cargar configuración según el entorno
if (APP_ENV === 'production') {
    require_once __DIR__ . '/../config/app.prod.php';
} else {
    require_once __DIR__ . '/../config/app.dev.php';
}

require_once __DIR__ . '/../config/i18n.php';

// Cargar configuración de base de datos según el entorno
if (APP_ENV === 'production') {
    require_once __DIR__ . '/../config/database.prod.php';
} else {
    require_once __DIR__ . '/../config/database.dev.php';
}

// Cargar controlador base
require_once __DIR__ . '/../controllers/BaseController.php';

// Obtener la ruta actual
$route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Manejar cambio de idioma
if (isset($_GET['lang']) && in_array($_GET['lang'], AVAILABLE_LANGS)) {
    I18n::setLocale($_GET['lang']);
    // Redirigir a la misma página sin el parámetro de idioma
    $redirectUrl = $route;
    header('Location: ' . $redirectUrl);
    exit;
}

// Cargar traducciones
I18n::loadTranslations();

// Inicializar el controlador
$controller = new BaseController();

// Manejar la ruta
$controller->handleRoute($route); 