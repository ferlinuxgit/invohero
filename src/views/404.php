<?php
// Establecer título de la página
$pageTitle = __('app.error_404');

// Iniciar buffer de salida
ob_start();
?>

<div class="flex flex-col items-center justify-center py-12">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-gray-800 mb-4">404</h1>
        <p class="text-2xl font-medium text-gray-600 mb-6"><?php echo __('app.error_404'); ?></p>
        <img src="https://illustrations.popsy.co/amber/web-error.svg" alt="Error 404" class="w-64 h-64 mx-auto mb-6">
        <a href="/" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
            <i class="fas fa-home mr-2"></i> <?php echo __('app.go_back'); ?>
        </a>
    </div>
</div>

<?php
// Obtener contenido del buffer
$content = ob_get_clean();

// Incluir el layout principal
include BASE_PATH . '/src/views/layouts/main.php';
?> 