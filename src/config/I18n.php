<?php

namespace App\config;

/**
 * Clase para manejar la internacionalización (i18n) de la aplicación
 */
class I18n
{
    /**
     * Idioma por defecto
     */
    private static string $defaultLocale = 'es';
    
    /**
     * Idioma actual
     */
    private static string $currentLocale;
    
    /**
     * Traducciones cargadas
     */
    private static array $translations = [];
    
    /**
     * Inicializar el sistema de internacionalización
     */
    public static function init(): void
    {
        // Obtener el idioma de la sesión o la cookie si existe
        self::$currentLocale = $_SESSION['locale'] ?? $_COOKIE['locale'] ?? self::$defaultLocale;
        
        // Cargar las traducciones del idioma actual
        self::loadTranslations();
    }
    
    /**
     * Cambiar el idioma
     */
    public static function setLocale(string $locale): void
    {
        // Verificar si el idioma solicitado es válido
        if (file_exists(__DIR__ . '/../lang/' . $locale)) {
            self::$currentLocale = $locale;
            
            // Guardar en sesión y cookie
            $_SESSION['locale'] = $locale;
            setcookie('locale', $locale, time() + (86400 * 30), '/'); // 30 días
            
            // Recargar traducciones
            self::loadTranslations();
        }
    }
    
    /**
     * Obtener el idioma actual
     */
    public static function getLocale(): string
    {
        return self::$currentLocale;
    }
    
    /**
     * Cargar las traducciones del idioma actual
     */
    private static function loadTranslations(): void
    {
        $langPath = __DIR__ . '/../lang/' . self::$currentLocale;
        
        // Recorrer todos los archivos de idioma
        foreach (glob($langPath . '/*.php') as $file) {
            $fileName = basename($file, '.php');
            $translations = include $file;
            
            // Agregar las traducciones al array
            self::$translations[$fileName] = $translations;
        }
    }
    
    /**
     * Traducir una clave
     */
    public static function trans(string $key, array $replace = []): string
    {
        // Separar el archivo y la clave (formato: archivo.clave)
        $parts = explode('.', $key);
        
        if (count($parts) !== 2) {
            return $key; // Si no tiene el formato correcto, devolver la clave
        }
        
        [$file, $translationKey] = $parts;
        
        // Buscar la traducción
        $translation = self::$translations[$file][$translationKey] ?? $key;
        
        // Reemplazar variables si existen
        if (!empty($replace)) {
            foreach ($replace as $search => $value) {
                $translation = str_replace(':' . $search, $value, $translation);
            }
        }
        
        return $translation;
    }
} 