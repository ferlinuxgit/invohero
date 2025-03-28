<?php
// Establecer título de la página
$pageTitle = __('app.accounting');

// Iniciar buffer de salida
ob_start();
?>

<div class="space-y-6">
    <!-- Cabecera con período y botones -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-3 md:space-y-0">
        <h1 class="text-2xl font-bold text-gray-800"><?php echo __('app.accounting'); ?></h1>
        <div class="flex space-x-2">
            <div class="relative">
                <select class="pr-10 pl-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="month"><?php echo __('app.this_month'); ?></option>
                    <option value="quarter"><?php echo __('app.this_quarter'); ?></option>
                    <option value="year"><?php echo __('app.this_year'); ?></option>
                    <option value="custom"><?php echo __('app.custom_period'); ?></option>
                </select>
            </div>
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2.5 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> <?php echo __('app.new_transaction'); ?>
            </button>
            <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2.5 rounded-lg flex items-center">
                <i class="fas fa-file-excel mr-2"></i> <?php echo __('app.export'); ?>
            </button>
        </div>
    </div>

    <!-- Tarjetas de resumen financiero -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm text-gray-500"><?php echo __('app.total_income'); ?></p>
                    <p class="text-2xl font-bold text-gray-800">12.540,00 €</p>
                </div>
                <div class="rounded-full bg-green-100 p-3 h-12 w-12 flex items-center justify-center">
                    <i class="fas fa-arrow-up text-green-500"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span class="text-sm text-green-500 flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i> 7.2%
                    </span>
                    <span class="text-sm text-gray-500 ml-2"><?php echo __('app.vs_last_period'); ?></span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm text-gray-500"><?php echo __('app.total_expenses'); ?></p>
                    <p class="text-2xl font-bold text-gray-800">8.350,00 €</p>
                </div>
                <div class="rounded-full bg-red-100 p-3 h-12 w-12 flex items-center justify-center">
                    <i class="fas fa-arrow-down text-red-500"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span class="text-sm text-red-500 flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i> 2.5%
                    </span>
                    <span class="text-sm text-gray-500 ml-2"><?php echo __('app.vs_last_period'); ?></span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm text-gray-500"><?php echo __('app.balance'); ?></p>
                    <p class="text-2xl font-bold text-gray-800">4.190,00 €</p>
                </div>
                <div class="rounded-full bg-blue-100 p-3 h-12 w-12 flex items-center justify-center">
                    <i class="fas fa-chart-line text-blue-500"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span class="text-sm text-green-500 flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i> 12.8%
                    </span>
                    <span class="text-sm text-gray-500 ml-2"><?php echo __('app.vs_last_period'); ?></span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm text-gray-500"><?php echo __('app.pending_invoices'); ?></p>
                    <p class="text-2xl font-bold text-gray-800">6</p>
                </div>
                <div class="rounded-full bg-yellow-100 p-3 h-12 w-12 flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-500"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span class="text-xl text-gray-800">3.250,00 €</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Gráfico de Ingresos vs Gastos -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4"><?php echo __('app.income_vs_expenses'); ?></h2>
            <div class="h-80">
                <canvas id="incomeExpensesChart"></canvas>
            </div>
        </div>

        <!-- Gráfico de distribución de gastos -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4"><?php echo __('app.expense_distribution'); ?></h2>
            <div class="h-80">
                <canvas id="expensesDistributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabla de transacciones recientes -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800"><?php echo __('app.recent_transactions'); ?></h3>
        </div>
        <table class="datatable min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.date'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.description'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.category'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.type'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.amount'); ?></th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.actions'); ?></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php 
                $types = ['income', 'expense'];
                $incomeCategories = ['Ventas', 'Servicios', 'Otros ingresos'];
                $expenseCategories = ['Materiales', 'Salarios', 'Alquiler', 'Servicios Públicos', 'Marketing'];
                
                for ($i = 1; $i <= 10; $i++): 
                    $type = $types[array_rand($types)];
                    $categories = $type === 'income' ? $incomeCategories : $expenseCategories;
                    $category = $categories[array_rand($categories)];
                    $amount = $type === 'income' ? rand(500, 3000) : rand(100, 1500);
                ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo date('d/m/Y', strtotime("-" . rand(1, 30) . " days")); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php 
                            if ($type === 'income') {
                                echo "Factura " . sprintf('INV-%03d', rand(1, 999));
                            } else {
                                echo $category . " - " . date('F', mktime(0, 0, 0, rand(1, 12), 10));
                            }
                            ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo $category; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo __('app.' . $type); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm <?php echo $type === 'income' ? 'text-green-600' : 'text-red-600'; ?>">
                            <?php echo $type === 'income' ? '+' : '-'; ?><?php echo number_format($amount, 2, ',', '.'); ?> €
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button class="text-blue-600 hover:text-blue-900" title="<?php echo __('app.view'); ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-indigo-600 hover:text-indigo-900" title="<?php echo __('app.edit'); ?>">
                                    <i class="fas fa-edit"></i>
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

<!-- Scripts para los gráficos -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos para el gráfico de ingresos vs gastos
    const incomeExpensesCtx = document.getElementById('incomeExpensesChart').getContext('2d');
    const incomeExpensesChart = new Chart(incomeExpensesCtx, {
        type: 'bar',
        data: {
            labels: ['<?php echo __("app.january"); ?>', '<?php echo __("app.february"); ?>', '<?php echo __("app.march"); ?>', '<?php echo __("app.april"); ?>', '<?php echo __("app.may"); ?>', '<?php echo __("app.june"); ?>'],
            datasets: [
                {
                    label: '<?php echo __("app.income"); ?>',
                    data: [2200, 1800, 2400, 2600, 2300, 3200],
                    backgroundColor: 'rgba(34, 197, 94, 0.5)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 1
                },
                {
                    label: '<?php echo __("app.expenses"); ?>',
                    data: [1800, 1600, 1900, 2100, 1500, 1900],
                    backgroundColor: 'rgba(239, 68, 68, 0.5)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Datos para el gráfico de distribución de gastos
    const expensesDistributionCtx = document.getElementById('expensesDistributionChart').getContext('2d');
    const expensesDistributionChart = new Chart(expensesDistributionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Materiales', 'Salarios', 'Alquiler', 'Servicios Públicos', 'Marketing'],
            datasets: [
                {
                    data: [25, 40, 15, 10, 10],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(99, 102, 241, 0.7)',
                        'rgba(168, 85, 247, 0.7)',
                        'rgba(236, 72, 153, 0.7)',
                        'rgba(249, 115, 22, 0.7)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(99, 102, 241, 1)',
                        'rgba(168, 85, 247, 1)',
                        'rgba(236, 72, 153, 1)',
                        'rgba(249, 115, 22, 1)'
                    ],
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
});
</script>

<?php
// Obtener contenido del buffer
$content = ob_get_clean();

// Incluir el layout principal
include BASE_PATH . '/src/views/layouts/main.php';
?> 