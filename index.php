<?php

/**
 * InvoHero - Sistema de facturación y contabilidad
 * 
 * Archivo principal para despliegue en servidor Plesk
 */

// Definir la ruta base de la aplicación
define('BASE_PATH', __DIR__);

// Redirigir todo al public/index.php
require __DIR__ . '/src/public/index.php'; 