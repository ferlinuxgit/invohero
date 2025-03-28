<?php
// Incluir el componente de encabezado
include __DIR__ . '/../components/page-header.php';
?>

<!-- Encabezado de la página -->
<?php
$title = $lang === 'es' ? 'Facturas' : 'Invoices';
$icon = 'fas fa-file-invoice';
$action_text = $lang === 'es' ? 'Nueva Factura' : 'New Invoice';
$action_url = '/invoices/create';
$action_icon = 'fas fa-plus';
include __DIR__ . '/../components/page-header.php';
?>

<!-- Filtros -->
<div class="bg-white rounded-lg shadow-sm p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                <?php echo $lang === 'es' ? 'Estado' : 'Status'; ?>
            </label>
            <select class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value=""><?php echo $lang === 'es' ? 'Todos' : 'All'; ?></option>
                <option value="draft"><?php echo $lang === 'es' ? 'Borrador' : 'Draft'; ?></option>
                <option value="sent"><?php echo $lang === 'es' ? 'Enviada' : 'Sent'; ?></option>
                <option value="paid"><?php echo $lang === 'es' ? 'Pagada' : 'Paid'; ?></option>
                <option value="overdue"><?php echo $lang === 'es' ? 'Vencida' : 'Overdue'; ?></option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                <?php echo $lang === 'es' ? 'Cliente' : 'Client'; ?>
            </label>
            <select class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value=""><?php echo $lang === 'es' ? 'Todos' : 'All'; ?></option>
                <?php foreach ($clients as $client): ?>
                <option value="<?php echo $client['id']; ?>">
                    <?php echo htmlspecialchars($client['name']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                <?php echo $lang === 'es' ? 'Fecha desde' : 'Date from'; ?>
            </label>
            <input type="date" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                <?php echo $lang === 'es' ? 'Fecha hasta' : 'Date to'; ?>
            </label>
            <input type="date" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>
    <div class="mt-4 flex justify-end">
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <i class="fas fa-filter mr-2"></i>
            <?php echo $lang === 'es' ? 'Filtrar' : 'Filter'; ?>
        </button>
    </div>
</div>

<!-- Lista de facturas -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo $lang === 'es' ? 'Número' : 'Number'; ?>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo $lang === 'es' ? 'Cliente' : 'Client'; ?>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo $lang === 'es' ? 'Fecha' : 'Date'; ?>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo $lang === 'es' ? 'Total' : 'Total'; ?>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo $lang === 'es' ? 'Estado' : 'Status'; ?>
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo $lang === 'es' ? 'Acciones' : 'Actions'; ?>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($invoices as $invoice): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <?php echo htmlspecialchars($invoice['number']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo htmlspecialchars($invoice['client_name']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo date('d/m/Y', strtotime($invoice['date'])); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo number_format($invoice['total'], 2, ',', '.'); ?> €
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php
                            switch ($invoice['status']) {
                                case 'draft':
                                    echo 'bg-gray-100 text-gray-800';
                                    break;
                                case 'sent':
                                    echo 'bg-blue-100 text-blue-800';
                                    break;
                                case 'paid':
                                    echo 'bg-green-100 text-green-800';
                                    break;
                                case 'overdue':
                                    echo 'bg-red-100 text-red-800';
                                    break;
                            }
                            ?>">
                            <?php
                            switch ($invoice['status']) {
                                case 'draft':
                                    echo $lang === 'es' ? 'Borrador' : 'Draft';
                                    break;
                                case 'sent':
                                    echo $lang === 'es' ? 'Enviada' : 'Sent';
                                    break;
                                case 'paid':
                                    echo $lang === 'es' ? 'Pagada' : 'Paid';
                                    break;
                                case 'overdue':
                                    echo $lang === 'es' ? 'Vencida' : 'Overdue';
                                    break;
                            }
                            ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <a href="/invoices/<?php echo $invoice['id']; ?>" 
                               class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/invoices/<?php echo $invoice['id']; ?>/edit" 
                               class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteInvoice(<?php echo $invoice['id']; ?>)" 
                                    class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Paginación -->
<div class="mt-4 flex justify-between items-center">
    <div class="text-sm text-gray-700">
        <?php echo $lang === 'es' ? 'Mostrando' : 'Showing'; ?> 
        <span class="font-medium">1</span> 
        <?php echo $lang === 'es' ? 'a' : 'to'; ?> 
        <span class="font-medium">10</span> 
        <?php echo $lang === 'es' ? 'de' : 'of'; ?> 
        <span class="font-medium">97</span> 
        <?php echo $lang === 'es' ? 'resultados' : 'results'; ?>
    </div>
    <div class="flex space-x-2">
        <button class="px-3 py-1 border rounded-lg text-sm text-gray-700 hover:bg-gray-50">
            <?php echo $lang === 'es' ? 'Anterior' : 'Previous'; ?>
        </button>
        <button class="px-3 py-1 border rounded-lg text-sm text-gray-700 hover:bg-gray-50">
            <?php echo $lang === 'es' ? 'Siguiente' : 'Next'; ?>
        </button>
    </div>
</div>

<script>
function deleteInvoice(id) {
    if (confirm('<?php echo $lang === 'es' ? '¿Estás seguro de que deseas eliminar esta factura?' : 'Are you sure you want to delete this invoice?'; ?>')) {
        fetch(`/invoices/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('<?php echo $lang === 'es' ? 'Error al eliminar la factura' : 'Error deleting invoice'; ?>');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('<?php echo $lang === 'es' ? 'Error al eliminar la factura' : 'Error deleting invoice'; ?>');
        });
    }
}
</script> 