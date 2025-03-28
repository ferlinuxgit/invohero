<?php
/**
 * Componente de listado reutilizable
 * 
 * @param string $title Título de la página
 * @param string $icon Icono de Font Awesome
 * @param string $action_text Texto del botón de acción
 * @param string $action_url URL del botón de acción
 * @param string $action_icon Icono del botón de acción
 * @param array $filters Array de filtros
 * @param array $columns Array de columnas
 * @param array $items Array de elementos a mostrar
 * @param array $pagination Datos de paginación
 */

// Incluir el encabezado
include __DIR__ . '/page-header.php';

// Configurar el encabezado
$title = $title;
$icon = $icon;
$action_text = $action_text;
$action_url = $action_url;
$action_icon = $action_icon;

// Incluir el encabezado una sola vez
include __DIR__ . '/page-header.php';
?>

<!-- Filtros -->
<?php if (!empty($filters)): ?>
<div class="bg-white rounded-lg shadow-sm p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-<?php echo count($filters); ?> gap-4">
        <?php foreach ($filters as $filter): ?>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                <?php echo $filter['label']; ?>
            </label>
            <?php if ($filter['type'] === 'select'): ?>
                <select class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value=""><?php echo $lang === 'es' ? 'Todos' : 'All'; ?></option>
                    <?php foreach ($filter['options'] as $option): ?>
                    <option value="<?php echo $option['value']; ?>">
                        <?php echo $option['label']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            <?php elseif ($filter['type'] === 'date'): ?>
                <input type="date" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="mt-4 flex justify-end">
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <i class="fas fa-filter mr-2"></i>
            <?php echo $lang === 'es' ? 'Filtrar' : 'Filter'; ?>
        </button>
    </div>
</div>
<?php endif; ?>

<!-- Lista de elementos -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <?php foreach ($columns as $column): ?>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo $column['label']; ?>
                    </th>
                    <?php endforeach; ?>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo $lang === 'es' ? 'Acciones' : 'Actions'; ?>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($items as $item): ?>
                <tr>
                    <?php foreach ($columns as $column): ?>
                    <td class="px-6 py-4 whitespace-nowrap text-sm <?php echo $column['class'] ?? 'text-gray-500'; ?>">
                        <?php if (isset($column['render'])): ?>
                            <?php echo $column['render']($item); ?>
                        <?php else: ?>
                            <?php echo htmlspecialchars($item[$column['key']]); ?>
                        <?php endif; ?>
                    </td>
                    <?php endforeach; ?>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <?php if (isset($actions)): ?>
                                <?php foreach ($actions as $action): ?>
                                    <?php if ($action['type'] === 'link'): ?>
                                        <a href="<?php echo $action['url']($item['id']); ?>" 
                                           class="<?php echo $action['class']; ?>">
                                            <i class="<?php echo $action['icon']; ?>"></i>
                                        </a>
                                    <?php elseif ($action['type'] === 'button'): ?>
                                        <button onclick="<?php echo $action['onclick']; ?>(<?php echo $item['id']; ?>)" 
                                                class="<?php echo $action['class']; ?>">
                                            <i class="<?php echo $action['icon']; ?>"></i>
                                        </button>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Paginación -->
<?php if (isset($pagination)): ?>
<div class="mt-4 flex justify-between items-center">
    <div class="text-sm text-gray-700">
        <?php echo $lang === 'es' ? 'Mostrando' : 'Showing'; ?> 
        <span class="font-medium"><?php echo $pagination['from']; ?></span> 
        <?php echo $lang === 'es' ? 'a' : 'to'; ?> 
        <span class="font-medium"><?php echo $pagination['to']; ?></span> 
        <?php echo $lang === 'es' ? 'de' : 'of'; ?> 
        <span class="font-medium"><?php echo $pagination['total']; ?></span> 
        <?php echo $lang === 'es' ? 'resultados' : 'results'; ?>
    </div>
    <div class="flex space-x-2">
        <?php if ($pagination['current_page'] > 1): ?>
        <button class="px-3 py-1 border rounded-lg text-sm text-gray-700 hover:bg-gray-50">
            <?php echo $lang === 'es' ? 'Anterior' : 'Previous'; ?>
        </button>
        <?php endif; ?>
        <?php if ($pagination['current_page'] < $pagination['last_page']): ?>
        <button class="px-3 py-1 border rounded-lg text-sm text-gray-700 hover:bg-gray-50">
            <?php echo $lang === 'es' ? 'Siguiente' : 'Next'; ?>
        </button>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?> 