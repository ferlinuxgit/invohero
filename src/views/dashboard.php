<?php
// Establecer título de la página
$pageTitle = __('app.dashboard');

// Iniciar buffer de salida
ob_start();
?>

<div class="space-y-6">
    <!-- Tarjetas de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                    <i class="fas fa-file-invoice text-blue-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-600"><?php echo __('app.total_invoices'); ?></h2>
                    <p class="text-2xl font-semibold text-gray-800">24</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                    <i class="fas fa-users text-green-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-600"><?php echo __('app.total_clients'); ?></h2>
                    <p class="text-2xl font-semibold text-gray-800">12</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                    <i class="fas fa-money-bill-wave text-purple-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-600"><?php echo __('app.total_income'); ?></h2>
                    <p class="text-2xl font-semibold text-gray-800">8.540,00 €</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-100 rounded-full p-3">
                    <i class="fas fa-credit-card text-red-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-600"><?php echo __('app.total_expenses'); ?></h2>
                    <p class="text-2xl font-semibold text-gray-800">2.156,25 €</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gráfico de ingresos/gastos -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4"><?php echo __('app.total_income'); ?> / <?php echo __('app.total_expenses'); ?></h2>
        <div>
            <canvas id="incomeExpensesChart" height="200"></canvas>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Facturas recientes -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4"><?php echo __('app.recent_invoices'); ?></h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.invoice_number'); ?></th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.client'); ?></th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.amount'); ?></th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo __('app.status'); ?></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">INV-001</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Cliente Ejemplo S.L.</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1.210,00 €</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <?php echo __('app.paid'); ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">INV-002</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Empresa Demo</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">845,50 €</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <?php echo __('app.sent'); ?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Clientes recientes -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4"><?php echo __('app.recent_clients'); ?></h2>
            <div class="space-y-4">
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/40" alt="Cliente">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Cliente Ejemplo S.L.</p>
                        <p class="text-sm text-gray-500">cliente@ejemplo.com</p>
                    </div>
                    <div class="ml-auto">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-file-invoice mr-1"></i> 3
                        </span>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/40" alt="Cliente">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Empresa Demo</p>
                        <p class="text-sm text-gray-500">info@empresa-demo.com</p>
                    </div>
                    <div class="ml-auto">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-file-invoice mr-1"></i> 1
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inicializar gráfico -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('incomeExpensesChart').getContext('2d');
    
    const labels = [
        '<?php echo __("app.january"); ?>',
        '<?php echo __("app.february"); ?>',
        '<?php echo __("app.march"); ?>',
        '<?php echo __("app.april"); ?>',
        '<?php echo __("app.may"); ?>',
        '<?php echo __("app.june"); ?>'
    ];
    
    const data = {
        labels: labels,
        datasets: [
            {
                label: '<?php echo __("app.total_income"); ?>',
                data: [1500, 1900, 2200, 1800, 2400, 2800],
                backgroundColor: 'rgba(79, 70, 229, 0.2)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 2
            },
            {
                label: '<?php echo __("app.total_expenses"); ?>',
                data: [500, 650, 750, 800, 950, 1100],
                backgroundColor: 'rgba(239, 68, 68, 0.2)',
                borderColor: 'rgba(239, 68, 68, 1)',
                borderWidth: 2
            }
        ]
    };
    
    new Chart(ctx, {
        type: 'line',
        data: data,
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
});
</script>

<?php
// Obtener contenido del buffer
$content = ob_get_clean();

// Incluir el layout principal
include BASE_PATH . '/src/views/layouts/main.php';
?> 