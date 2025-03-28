<?php

use App\Config\I18n;

/**
 * Función para traducir textos
 * 
 * @param string $key Clave de traducción en formato 'archivo.clave'
 * @param array $replace Valores para reemplazar en la traducción
 * @return string
 */
function __($key, array $replace = []): string 
{
    return I18n::trans($key, $replace);
}

/**
 * Obtener valor de configuración
 * 
 * @param string $key Clave de configuración en formato 'seccion.clave'
 * @param mixed $default Valor por defecto si no se encuentra
 * @return mixed
 */
function config($key, $default = null)
{
    static $config = null;
    
    // Cargar configuración si aún no se ha cargado
    if ($config === null) {
        $config = require __DIR__ . '/config/config.php';
    }
    
    // Separar la sección y la clave
    $parts = explode('.', $key);
    
    if (count($parts) !== 2) {
        return $default;
    }
    
    [$section, $item] = $parts;
    
    return $config[$section][$item] ?? $default;
}

/**
 * Escapar HTML
 * 
 * @param string $text Texto a escapar
 * @return string
 */
function e($text): string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Generar URL relativa a la raíz
 * 
 * @param string $path Ruta relativa
 * @return string
 */
function url($path = ''): string
{
    $basePath = config('app.url');
    
    if (empty($path)) {
        return $basePath;
    }
    
    return rtrim($basePath, '/') . '/' . ltrim($path, '/');
}

/**
 * Redireccionar a una URL
 * 
 * @param string $url URL a redireccionar
 * @return void
 */
function redirect($url): void
{
    header('Location: ' . url($url));
    exit;
}

/**
 * Formatear moneda
 * 
 * @param float $amount Monto a formatear
 * @param string $currency Código de moneda
 * @return string
 */
function formatCurrency($amount, $currency = 'EUR'): string
{
    $locale = I18n::getLocale() === 'es' ? 'es_ES' : 'en_US';
    
    $fmt = new NumberFormatter($locale, NumberFormatter::CURRENCY);
    return $fmt->formatCurrency($amount, $currency);
}

/**
 * Formatear fecha
 * 
 * @param string $date Fecha en formato Y-m-d
 * @param string $format Formato de fecha (opcional)
 * @return string
 */
function formatDate($date, $format = null): string
{
    $locale = I18n::getLocale() === 'es' ? 'es_ES' : 'en_US';
    $dateTime = new DateTime($date);
    
    if ($format) {
        return $dateTime->format($format);
    }
    
    $intlFormat = new IntlDateFormatter(
        $locale,
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE
    );
    
    return $intlFormat->format($dateTime);
} 