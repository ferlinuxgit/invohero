<?php
/**
 * Configuración de la aplicación para el entorno de producción
 */

// Configuración de la aplicación
define('APP_NAME', 'InvoHero');
define('APP_URL', 'https://invohero.com');
define('APP_ENV', 'production');
define('APP_DEBUG', false);

// Configuración de sesión
define('SESSION_LIFETIME', 7200); // 2 horas
define('SESSION_NAME', 'invohero_session');

// Configuración de idiomas
define('DEFAULT_LANG', 'es');
define('AVAILABLE_LANGS', ['es', 'en']);

// Configuración de paginación
define('ITEMS_PER_PAGE', 10);

// Configuración de fechas
define('DATE_FORMAT', 'd/m/Y');
define('DATETIME_FORMAT', 'd/m/Y H:i');

// Configuración de moneda
define('CURRENCY_SYMBOL', '€');
define('CURRENCY_POSITION', 'after'); // before, after
define('DECIMAL_SEPARATOR', ',');
define('THOUSAND_SEPARATOR', '.');

// Configuración de correo
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', '');
define('MAIL_PASSWORD', '');
define('MAIL_ENCRYPTION', 'tls');
define('MAIL_FROM_ADDRESS', '');
define('MAIL_FROM_NAME', APP_NAME);

// Configuración de seguridad
define('CSRF_TOKEN_LIFETIME', 7200);
define('PASSWORD_MIN_LENGTH', 8);
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_TIMEOUT', 900); // 15 minutos

// Configuración de archivos
define('MAX_UPLOAD_SIZE', 5242880); // 5MB
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'pdf']);
define('UPLOAD_PATH', __DIR__ . '/../storage/uploads/');

// Configuración de caché
define('CACHE_ENABLED', true); // Activar caché en producción
define('CACHE_LIFETIME', 3600); // 1 hora
define('CACHE_PATH', __DIR__ . '/../storage/cache/'); 