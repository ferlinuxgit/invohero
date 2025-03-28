<?php
// Configurar el listado
$title = $lang === 'es' ? 'Contabilidad' : 'Accounting';
$icon = 'fas fa-calculator';
$action_text = $lang === 'es' ? 'Nueva Transacción' : 'New Transaction';
$action_url = '/accounting/create';
$action_icon = 'fas fa-plus';

// Configurar filtros
$filters = [
    [
        'label' => $lang === 'es' ? 'Tipo' : 'Type',
        'type' => 'select',
        'options' => [
            ['value' => '', 'label' => $lang === 'es' ? 'Todos' : 'All'],
            ['value' => 'income', 'label' => $lang === 'es' ? 'Ingreso' : 'Income'],
            ['value' => 'expense', 'label' => $lang === 'es' ? 'Gasto' : 'Expense'],
            ['value' => 'transfer', 'label' => $lang === 'es' ? 'Transferencia' : 'Transfer']
        ]
    ],
    [
        'label' => $lang === 'es' ? 'Categoría' : 'Category',
        'type' => 'select',
        'options' => array_map(function($category) {
            return ['value' => $category['id'], 'label' => $category['name']];
        }, $categories)
    ],
    [
        'label' => $lang === 'es' ? 'Fecha desde' : 'Date from',
        'type' => 'date'
    ],
    [
        'label' => $lang === 'es' ? 'Fecha hasta' : 'Date to',
        'type' => 'date'
    ]
];

// Configurar columnas
$columns = [
    [
        'key' => 'date',
        'label' => $lang === 'es' ? 'Fecha' : 'Date',
        'render' => function($item) {
            return date('d/m/Y', strtotime($item['date']));
        }
    ],
    [
        'key' => 'type',
        'label' => $lang === 'es' ? 'Tipo' : 'Type',
        'render' => function($item) use ($lang) {
            $typeClasses = [
                'income' => 'bg-green-100 text-green-800',
                'expense' => 'bg-red-100 text-red-800',
                'transfer' => 'bg-blue-100 text-blue-800'
            ];
            $typeLabels = [
                'income' => $lang === 'es' ? 'Ingreso' : 'Income',
                'expense' => $lang === 'es' ? 'Gasto' : 'Expense',
                'transfer' => $lang === 'es' ? 'Transferencia' : 'Transfer'
            ];
            return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ' . 
                   $typeClasses[$item['type']] . '">' . 
                   $typeLabels[$item['type']] . '</span>';
        }
    ],
    [
        'key' => 'description',
        'label' => $lang === 'es' ? 'Descripción' : 'Description',
        'class' => 'font-medium text-gray-900'
    ],
    [
        'key' => 'category',
        'label' => $lang === 'es' ? 'Categoría' : 'Category'
    ],
    [
        'key' => 'amount',
        'label' => $lang === 'es' ? 'Importe' : 'Amount',
        'render' => function($item) {
            $amount = number_format($item['amount'], 2, ',', '.') . ' €';
            $class = $item['type'] === 'income' ? 'text-green-600' : 'text-red-600';
            return "<span class='$class'>$amount</span>";
        }
    ],
    [
        'key' => 'status',
        'label' => $lang === 'es' ? 'Estado' : 'Status',
        'render' => function($item) use ($lang) {
            $statusClasses = [
                'pending' => 'bg-yellow-100 text-yellow-800',
                'completed' => 'bg-green-100 text-green-800',
                'cancelled' => 'bg-red-100 text-red-800'
            ];
            $statusLabels = [
                'pending' => $lang === 'es' ? 'Pendiente' : 'Pending',
                'completed' => $lang === 'es' ? 'Completado' : 'Completed',
                'cancelled' => $lang === 'es' ? 'Cancelado' : 'Cancelled'
            ];
            return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ' . 
                   $statusClasses[$item['status']] . '">' . 
                   $statusLabels[$item['status']] . '</span>';
        }
    ]
];

// Configurar acciones
$actions = [
    [
        'type' => 'link',
        'url' => function($id) { return "/accounting/$id"; },
        'class' => 'text-blue-600 hover:text-blue-900',
        'icon' => 'fas fa-eye'
    ],
    [
        'type' => 'link',
        'url' => function($id) { return "/accounting/$id/edit"; },
        'class' => 'text-blue-600 hover:text-blue-900',
        'icon' => 'fas fa-edit'
    ],
    [
        'type' => 'button',
        'onclick' => 'deleteTransaction',
        'class' => 'text-red-600 hover:text-red-900',
        'icon' => 'fas fa-trash'
    ]
];

// Configurar paginación
$pagination = [
    'from' => 1,
    'to' => 10,
    'total' => 156,
    'current_page' => 1,
    'last_page' => 16
];

// Incluir el componente de listado
include __DIR__ . '/../components/listing.php';
?>

<script>
function deleteTransaction(id) {
    if (confirm('<?php echo $lang === 'es' ? '¿Estás seguro de que deseas eliminar esta transacción?' : 'Are you sure you want to delete this transaction?'; ?>')) {
        fetch(`/accounting/${id}`, {
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
                alert('<?php echo $lang === 'es' ? 'Error al eliminar la transacción' : 'Error deleting transaction'; ?>');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('<?php echo $lang === 'es' ? 'Error al eliminar la transacción' : 'Error deleting transaction'; ?>');
        });
    }
}
</script> 