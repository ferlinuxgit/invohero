<?php
// Establecer título de la página
$pageTitle = __('app.invoices');

// Iniciar buffer de salida
ob_start();
?>

<div class="space-y-6">
    <!-- Cabecera con buscador y botones -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-3 md:space-y-0">
        <h1 class="text-2xl font-bold text-gray-800"><?php echo __('app.invoice_list'); ?></h1>
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

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-wrap gap-3">
            <div class="w-full md:w-auto">
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo __('app.status'); ?></label>
                <select class="w-full md:w-48 border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value=""><?php echo __('app.all'); ?></option>
                    <option value="draft"><?php echo __('app.draft'); ?></option>
                    <option value="sent"><?php echo __('app.sent'); ?></option>
                    <option value="paid"><?php echo __('app.paid'); ?></option>
                    <option value="overdue"><?php echo __('app.overdue'); ?></option>
                </select>
            </div>
            <div class="w-full md:w-auto">
                <label class="block text-sm font-medium text-gray-700 mb-1"><?php echo __('app.date_range'); ?></label>
                <div class="flex space-x-2">
                    <input type="date" class="border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="self-center">-</span>
                    <input type="date" class="border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="w-full md:w-auto flex items-end">
                <button class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-filter mr-2"></i> <?php echo __('app.filter'); ?>
                </button>
            </div>
        </div>
    </div>

    <!-- Tabla de facturas -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="datatable min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.invoice_number'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.client'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.issue_date'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.due_date'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.amount'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.status'); ?></th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.actions'); ?></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">INV-<?php echo str_pad($i, 3, '0', STR_PAD_LEFT); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Cliente Ejemplo <?php echo $i; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('d/m/Y', strtotime("-{$i} days")); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('d/m/Y', strtotime("+". (30-$i) ." days")); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo number_format(rand(100, 5000), 2, ',', '.'); ?> €</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                            $statuses = ['draft', 'sent', 'paid', 'overdue'];
                            $status = $statuses[array_rand($statuses)];
                            $statusClass = [
                                'draft' => 'bg-gray-100 text-gray-800',
                                'sent' => 'bg-blue-100 text-blue-800',
                                'paid' => 'bg-green-100 text-green-800',
                                'overdue' => 'bg-red-100 text-red-800'
                            ];
                            ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $statusClass[$status]; ?>">
                                <?php echo __("app.{$status}"); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button class="text-blue-600 hover:text-blue-900" title="<?php echo __('app.view'); ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-indigo-600 hover:text-indigo-900" title="<?php echo __('app.edit'); ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-green-600 hover:text-green-900" title="<?php echo __('app.duplicate'); ?>">
                                    <i class="fas fa-copy"></i>
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