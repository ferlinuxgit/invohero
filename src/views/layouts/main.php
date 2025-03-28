<!DOCTYPE html>
<html lang="<?php echo App\Config\I18n::getLocale(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo __('app.app_name'); ?> - <?php echo $pageTitle ?? __('app.dashboard'); ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwind.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- jQuery (requerido para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo url('/css/app.css'); ?>">
</head>
<body class="bg-gray-100">
    <!-- Language Switcher -->
    <div class="fixed top-4 right-4 z-50">
        <div class="flex bg-white rounded-lg shadow px-2 py-1">
            <a href="?lang=es" class="px-2 py-1 <?php echo App\Config\I18n::getLocale() === 'es' ? 'font-bold text-blue-600' : 'text-gray-600'; ?>">ES</a>
            <a href="?lang=en" class="px-2 py-1 <?php echo App\Config\I18n::getLocale() === 'en' ? 'font-bold text-blue-600' : 'text-gray-600'; ?>">EN</a>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 w-64 bg-gray-800 text-white transition-transform duration-300 transform" x-data="{ open: true }">
        <div class="p-4">
            <h1 class="text-2xl font-bold"><?php echo __('app.app_name'); ?></h1>
        </div>
        <nav class="mt-4">
            <a href="/" class="block py-2.5 px-4 hover:bg-gray-700">
                <i class="fas fa-home mr-2"></i> <?php echo __('app.dashboard'); ?>
            </a>
            <a href="/invoices" class="block py-2.5 px-4 hover:bg-gray-700">
                <i class="fas fa-file-invoice mr-2"></i> <?php echo __('app.invoices'); ?>
            </a>
            <a href="/clients" class="block py-2.5 px-4 hover:bg-gray-700">
                <i class="fas fa-users mr-2"></i> <?php echo __('app.clients'); ?>
            </a>
            <a href="/accounting" class="block py-2.5 px-4 hover:bg-gray-700">
                <i class="fas fa-calculator mr-2"></i> <?php echo __('app.accounting'); ?>
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <header class="bg-white shadow rounded-lg p-4 mb-6">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800"><?php echo $pageTitle ?? __('app.dashboard'); ?></h2>
                <div class="flex items-center space-x-4">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-plus mr-2"></i> <?php echo __('app.new'); ?>
                    </button>
                    <div class="relative" x-data="{ open: false }">
                        <button class="flex items-center space-x-2">
                            <img class="w-8 h-8 rounded-full" src="https://via.placeholder.com/32" alt="User">
                            <span class="text-gray-700">Usuario</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="bg-white shadow rounded-lg p-6">
            <?php echo $content ?? ''; ?>
        </main>
    </div>

    <!-- Custom JavaScript -->
    <script src="<?php echo url('/js/app.js'); ?>"></script>
    
    <!-- Inicializar plugins en base al idioma -->
    <script>
        // Configurar idioma para DataTables
        const locale = '<?php echo App\Config\I18n::getLocale(); ?>';
        const dtLanguageUrl = locale === 'es' 
            ? '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            : '//cdn.datatables.net/plug-ins/1.13.7/i18n/en-GB.json';
            
        $(document).ready(function() {
            $('.datatable').DataTable({
                language: {
                    url: dtLanguageUrl
                },
                responsive: true,
                pageLength: 10,
                order: [[0, 'desc']]
            });
        });
    </script>
</body>
</html> 