<?php
// Configurar el listado
$title = $lang === 'es' ? 'Clientes' : 'Clients';
$icon = 'fas fa-users';
$action_text = $lang === 'es' ? 'Nuevo Cliente' : 'New Client';
$action_url = '/clients/create';
$action_icon = 'fas fa-plus';

// Configurar filtros
$filters = [
    [
        'label' => $lang === 'es' ? 'Tipo' : 'Type',
        'type' => 'select',
        'options' => [
            ['value' => '', 'label' => $lang === 'es' ? 'Todos' : 'All'],
            ['value' => 'individual', 'label' => $lang === 'es' ? 'Individual' : 'Individual'],
            ['value' => 'company', 'label' => $lang === 'es' ? 'Empresa' : 'Company']
        ]
    ],
    [
        'label' => $lang === 'es' ? 'País' : 'Country',
        'type' => 'select',
        'options' => array_map(function($country) {
            return ['value' => $country['code'], 'label' => $country['name']];
        }, $countries)
    ],
    [
        'label' => $lang === 'es' ? 'Estado' : 'Status',
        'type' => 'select',
        'options' => [
            ['value' => '', 'label' => $lang === 'es' ? 'Todos' : 'All'],
            ['value' => 'active', 'label' => $lang === 'es' ? 'Activo' : 'Active'],
            ['value' => 'inactive', 'label' => $lang === 'es' ? 'Inactivo' : 'Inactive']
        ]
    ]
];

// Configurar columnas
$columns = [
    [
        'key' => 'name',
        'label' => $lang === 'es' ? 'Nombre' : 'Name',
        'class' => 'font-medium text-gray-900'
    ],
    [
        'key' => 'type',
        'label' => $lang === 'es' ? 'Tipo' : 'Type',
        'render' => function($item) use ($lang) {
            return $item['type'] === 'individual' 
                ? ($lang === 'es' ? 'Individual' : 'Individual')
                : ($lang === 'es' ? 'Empresa' : 'Company');
        }
    ],
    [
        'key' => 'email',
        'label' => 'Email'
    ],
    [
        'key' => 'phone',
        'label' => $lang === 'es' ? 'Teléfono' : 'Phone'
    ],
    [
        'key' => 'country',
        'label' => $lang === 'es' ? 'País' : 'Country'
    ],
    [
        'key' => 'status',
        'label' => $lang === 'es' ? 'Estado' : 'Status',
        'render' => function($item) use ($lang) {
            $statusClasses = [
                'active' => 'bg-green-100 text-green-800',
                'inactive' => 'bg-gray-100 text-gray-800'
            ];
            $statusLabels = [
                'active' => $lang === 'es' ? 'Activo' : 'Active',
                'inactive' => $lang === 'es' ? 'Inactivo' : 'Inactive'
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
        'url' => function($id) { return "/clients/$id"; },
        'class' => 'text-blue-600 hover:text-blue-900',
        'icon' => 'fas fa-eye'
    ],
    [
        'type' => 'link',
        'url' => function($id) { return "/clients/$id/edit"; },
        'class' => 'text-blue-600 hover:text-blue-900',
        'icon' => 'fas fa-edit'
    ],
    [
        'type' => 'button',
        'onclick' => 'deleteClient',
        'class' => 'text-red-600 hover:text-red-900',
        'icon' => 'fas fa-trash'
    ]
];

// Configurar paginación
$pagination = [
    'from' => 1,
    'to' => 10,
    'total' => 45,
    'current_page' => 1,
    'last_page' => 5
];

// Incluir el componente de listado
include __DIR__ . '/../components/listing.php';
?>

<script>
function deleteClient(id) {
    if (confirm('<?php echo $lang === 'es' ? '¿Estás seguro de que deseas eliminar este cliente?' : 'Are you sure you want to delete this client?'; ?>')) {
        fetch(`/clients/${id}`, {
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
                alert('<?php echo $lang === 'es' ? 'Error al eliminar el cliente' : 'Error deleting client'; ?>');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('<?php echo $lang === 'es' ? 'Error al eliminar el cliente' : 'Error deleting client'; ?>');
        });
    }
}
</script> 