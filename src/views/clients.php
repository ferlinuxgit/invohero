<?php
// Establecer título de la página
$pageTitle = __('app.clients');

// Iniciar buffer de salida
ob_start();
?>

<div class="space-y-6">
    <!-- Cabecera con buscador y botones -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-3 md:space-y-0">
        <h1 class="text-2xl font-bold text-gray-800"><?php echo __('app.client_list'); ?></h1>
        <div class="flex space-x-2">
            <div class="relative">
                <input type="text" placeholder="<?php echo __('app.search'); ?>..." class="pr-10 pl-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> <?php echo __('app.new'); ?>
            </button>
        </div>
    </div>

    <!-- Filtros y estadísticas -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="rounded-full p-3 bg-blue-100 text-blue-500 mr-4">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500"><?php echo __('app.total_clients'); ?></p>
                <p class="text-xl font-semibold">22</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="rounded-full p-3 bg-green-100 text-green-500 mr-4">
                <i class="fas fa-file-invoice-dollar text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500"><?php echo __('app.active_clients'); ?></p>
                <p class="text-xl font-semibold">15</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="rounded-full p-3 bg-purple-100 text-purple-500 mr-4">
                <i class="fas fa-money-bill-wave text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500"><?php echo __('app.avg_invoice'); ?></p>
                <p class="text-xl font-semibold">1.450,00 €</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="rounded-full p-3 bg-orange-100 text-orange-500 mr-4">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500"><?php echo __('app.growth'); ?></p>
                <p class="text-xl font-semibold">+12%</p>
            </div>
        </div>
    </div>

    <!-- Tabla de clientes -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="datatable min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.client_name'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.email'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.phone'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.tax_id'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.invoices'); ?></th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.actions'); ?></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/<?php echo rand(0, 1) ? 'men' : 'women'; ?>/<?php echo rand(1, 99); ?>.jpg" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Cliente Ejemplo <?php echo $i; ?> <?php echo rand(0, 1) ? 'S.L.' : ''; ?></div>
                                    <div class="text-sm text-gray-500"><?php echo rand(0, 1) ? 'Empresa' : 'Particular'; ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">cliente<?php echo $i; ?>@ejemplo.com</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">+34 6<?php echo str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo rand(0, 1) ? 'B' : 'A'; ?><?php echo rand(10000000, 99999999); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?php echo rand(1, 8); ?> <?php echo __('app.invoices'); ?></div>
                            <div class="text-sm text-gray-500"><?php echo number_format(rand(500, 10000), 2, ',', '.'); ?> €</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button class="text-blue-600 hover:text-blue-900" title="<?php echo __('app.view'); ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-indigo-600 hover:text-indigo-900" title="<?php echo __('app.edit'); ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-purple-600 hover:text-purple-900" title="<?php echo __('app.new_invoice'); ?>">
                                    <i class="fas fa-file-invoice"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900" title="<?php echo __('app.delete'); ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
// Obtener contenido del buffer
$content = ob_get_clean();

// Incluir el layout principal
include BASE_PATH . '/src/views/layouts/main.php';
?> 