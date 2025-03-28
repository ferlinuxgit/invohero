<?php
// Incluir el componente de encabezado
include __DIR__ . '/../components/page-header.php';

// Configurar el encabezado
$title = $lang === 'es' ? 'Facturas' : 'Invoices';
$icon = 'fas fa-file-invoice';
$action_text = $lang === 'es' ? 'Nueva Factura' : 'New Invoice';
$action_url = '/invoices/create';
$action_icon = 'fas fa-plus';

// Incluir el encabezado una sola vez
include __DIR__ . '/../components/page-header.php';

// Configurar filtros
$filters = [
    [
        'label' => $lang === 'es' ? 'Estado' : 'Status',
        'type' => 'select',
        'options' => [
            ['value' => '', 'label' => $lang === 'es' ? 'Todos' : 'All'],
            ['value' => 'draft', 'label' => $lang === 'es' ? 'Borrador' : 'Draft'],
            ['value' => 'sent', 'label' => $lang === 'es' ? 'Enviada' : 'Sent'],
            ['value' => 'paid', 'label' => $lang === 'es' ? 'Pagada' : 'Paid'],
            ['value' => 'overdue', 'label' => $lang === 'es' ? 'Vencida' : 'Overdue']
        ]
    ],
    [
        'label' => $lang === 'es' ? 'Cliente' : 'Client',
        'type' => 'select',
        'options' => array_map(function($client) {
            return ['value' => $client['id'], 'label' => $client['name']];
        }, $clients)
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
        'key' => 'number',
        'label' => $lang === 'es' ? 'Número' : 'Number',
        'class' => 'font-medium text-gray-900'
    ],
    [
        'key' => 'client_name',
        'label' => $lang === 'es' ? 'Cliente' : 'Client'
    ],
    [
        'key' => 'date',
        'label' => $lang === 'es' ? 'Fecha' : 'Date',
        'render' => function($item) {
            return date('d/m/Y', strtotime($item['date']));
        }
    ],
    [
        'key' => 'total',
        'label' => $lang === 'es' ? 'Total' : 'Total',
        'render' => function($item) {
            return number_format($item['total'], 2, ',', '.') . ' €';
        }
    ],
    [
        'key' => 'status',
        'label' => $lang === 'es' ? 'Estado' : 'Status',
        'render' => function($item) use ($lang) {
            $statusClasses = [
                'draft' => 'bg-gray-100 text-gray-800',
                'sent' => 'bg-blue-100 text-blue-800',
                'paid' => 'bg-green-100 text-green-800',
                'overdue' => 'bg-red-100 text-red-800'
            ];
            $statusLabels = [
                'draft' => $lang === 'es' ? 'Borrador' : 'Draft',
                'sent' => $lang === 'es' ? 'Enviada' : 'Sent',
                'paid' => $lang === 'es' ? 'Pagada' : 'Paid',
                'overdue' => $lang === 'es' ? 'Vencida' : 'Overdue'
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
        'url' => function($id) { return "/invoices/$id"; },
        'class' => 'text-blue-600 hover:text-blue-900',
        'icon' => 'fas fa-eye'
    ],
    [
        'type' => 'link',
        'url' => function($id) { return "/invoices/$id/edit"; },
        'class' => 'text-blue-600 hover:text-blue-900',
        'icon' => 'fas fa-edit'
    ],
    [
        'type' => 'button',
        'onclick' => 'deleteInvoice',
        'class' => 'text-red-600 hover:text-red-900',
        'icon' => 'fas fa-trash'
    ]
];

// Configurar paginación
$pagination = [
    'from' => 1,
    'to' => 10,
    'total' => 97,
    'current_page' => 1,
    'last_page' => 10
];

// Incluir el componente de listado
include __DIR__ . '/../components/listing.php';
?>

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