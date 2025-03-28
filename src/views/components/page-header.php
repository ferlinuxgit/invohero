<?php
/**
 * Componente de encabezado de página
 * 
 * @param string $title Título de la página
 * @param string $icon Icono de Font Awesome
 * @param string $action_text Texto del botón de acción (opcional)
 * @param string $action_url URL del botón de acción (opcional)
 * @param string $action_icon Icono del botón de acción (opcional)
 */
?>

<div class="flex items-center justify-between mb-6">
    <div class="flex items-center">
        <i class="<?php echo $icon; ?> text-2xl text-blue-600 mr-3"></i>
        <h1 class="text-2xl font-semibold text-gray-900"><?php echo $title; ?></h1>
    </div>
    
    <?php if (isset($action_text) && isset($action_url)): ?>
    <a href="<?php echo $action_url; ?>" 
       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
        <?php if (isset($action_icon)): ?>
            <i class="<?php echo $action_icon; ?> mr-2"></i>
        <?php endif; ?>
        <?php echo $action_text; ?>
    </a>
    <?php endif; ?>
</div> 