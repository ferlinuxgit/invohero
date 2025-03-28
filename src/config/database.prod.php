<?php
/**
 * Configuración de la base de datos para el entorno de producción
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'invohero');
define('DB_USER', 'invohero_user');
define('DB_PASS', 'your_secure_password_here');

// Configuración de la conexión PDO
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
]); 