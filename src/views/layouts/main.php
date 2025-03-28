<!DOCTYPE html>
<html lang="<?php echo App\config\I18n::getLocale(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo __('app.app_name'); ?> - <?php echo $pageTitle ?? __('app.dashboard'); ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwind.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- jQuery (requerido para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo url('/css/app.css'); ?>">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            min-width: 200px;
            background-color: #fff;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-radius: 0.5rem;
            z-index: 50;
        }
        
        .dataTables_wrapper .dataTables_length, 
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .dataTables_wrapper .dataTables_length, 
            .dataTables_wrapper .dataTables_filter {
                width: 100%;
                text-align: left;
                margin-bottom: 0.5rem;
            }
        }
        
        /* Scrollbar personalizado */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 6px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Mobile Navigation Toggle -->
        <div class="lg:hidden fixed top-0 left-0 z-40 w-full bg-white shadow-sm">
            <div class="flex justify-between items-center px-4 py-3">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="mr-3 text-gray-500 focus:outline-none">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <h1 class="text-xl font-bold text-primary-600"><?php echo __('app.app_name'); ?></h1>
                </div>
                <div class="flex items-center space-x-3">
                    <!-- Language Switcher -->
                    <div class="flex bg-gray-100 rounded-lg">
                        <a href="?lang=es" class="px-2 py-1 <?php echo App\config\I18n::getLocale() === 'es' ? 'font-bold text-primary-600' : 'text-gray-600'; ?>">ES</a>
                        <a href="?lang=en" class="px-2 py-1 <?php echo App\config\I18n::getLocale() === 'en' ? 'font-bold text-primary-600' : 'text-gray-600'; ?>">EN</a>
                    </div>
                    
                    <!-- User menu (mobile) -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="focus:outline-none">
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Admin&background=0284c7&color=fff" alt="User">
                        </button>
                        <div x-show="open" @click.away="open = false" class="dropdown-content" style="display: none;">
                            <div class="py-1">
                                <a href="#" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <i class="fas fa-user text-gray-400 mr-2"></i> <?php echo __('app.profile'); ?>
                                </a>
                                <a href="#" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <i class="fas fa-cog text-gray-400 mr-2"></i> <?php echo __('app.settings'); ?>
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <a href="#" class="px-4 py-2 text-sm text-red-600 hover:bg-gray-100 flex items-center">
                                    <i class="fas fa-sign-out-alt text-red-400 mr-2"></i> <?php echo __('app.logout'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Desktop Navigation -->
        <aside 
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0"
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
        >
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between h-16 px-4 py-6 border-b bg-gradient-to-r from-primary-700 to-primary-500">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold text-white"><?php echo __('app.app_name'); ?></h1>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-white focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Navigation -->
                <div class="flex-1 overflow-y-auto py-4 px-2 space-y-1">
                    <a href="/" class="flex items-center px-4 py-3 text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200
                        <?php echo ($pageTitle === __('app.dashboard')) ? 'bg-primary-50 text-primary-600' : ''; ?>">
                        <i class="fas fa-home mr-3"></i>
                        <span class="font-medium"><?php echo __('app.dashboard'); ?></span>
                    </a>
                    <a href="/invoices" class="flex items-center px-4 py-3 text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200
                        <?php echo ($pageTitle === __('app.invoices')) ? 'bg-primary-50 text-primary-600' : ''; ?>">
                        <i class="fas fa-file-invoice mr-3"></i>
                        <span class="font-medium"><?php echo __('app.invoices'); ?></span>
                    </a>
                    <a href="/clients" class="flex items-center px-4 py-3 text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200
                        <?php echo ($pageTitle === __('app.clients')) ? 'bg-primary-50 text-primary-600' : ''; ?>">
                        <i class="fas fa-users mr-3"></i>
                        <span class="font-medium"><?php echo __('app.clients'); ?></span>
                    </a>
                    <a href="/accounting" class="flex items-center px-4 py-3 text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200
                        <?php echo ($pageTitle === __('app.accounting')) ? 'bg-primary-50 text-primary-600' : ''; ?>">
                        <i class="fas fa-calculator mr-3"></i>
                        <span class="font-medium"><?php echo __('app.accounting'); ?></span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-box-open mr-3"></i>
                        <span class="font-medium"><?php echo __('app.products'); ?></span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-chart-bar mr-3"></i>
                        <span class="font-medium"><?php echo __('app.reports'); ?></span>
                    </a>
                </div>
                
                <!-- User Section -->
                <div class="border-t border-gray-200 p-4">
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center w-full text-left px-2 py-2 text-gray-600 hover:text-primary-600 hover:bg-gray-100 rounded-lg focus:outline-none">
                            <img class="h-8 w-8 rounded-full mr-2" src="https://ui-avatars.com/api/?name=Admin&background=0284c7&color=fff" alt="User">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-700 truncate">Admin</p>
                                <p class="text-xs text-gray-500 truncate">admin@example.com</p>
                            </div>
                            <i class="fas fa-chevron-down ml-1 text-gray-400"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute bottom-full left-0 mb-3 w-full dropdown-content" style="display: none;">
                            <div class="py-1 rounded-lg shadow-lg bg-white">
                                <a href="#" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <i class="fas fa-user text-gray-400 mr-2"></i> <?php echo __('app.profile'); ?>
                                </a>
                                <a href="#" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <i class="fas fa-cog text-gray-400 mr-2"></i> <?php echo __('app.settings'); ?>
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <a href="#" class="px-4 py-2 text-sm text-red-600 hover:bg-gray-100 flex items-center">
                                    <i class="fas fa-sign-out-alt text-red-400 mr-2"></i> <?php echo __('app.logout'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Backdrop -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false" 
            class="fixed inset-0 z-40 bg-black bg-opacity-40 lg:hidden" 
            style="display: none;"
        ></div>

        <!-- Main Content -->
        <main class="lg:ml-64 min-h-screen pt-16 lg:pt-0">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <!-- Header -->
                <div class="md:flex md:items-center md:justify-between mb-6">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-xl sm:text-2xl font-bold leading-7 text-gray-800 sm:truncate"><?php echo $pageTitle ?? __('app.dashboard'); ?></h2>
                    </div>
                    <div class="hidden lg:flex items-center mt-4 md:mt-0">
                        <!-- Language Switcher - Desktop -->
                        <div class="flex bg-white rounded-lg shadow-sm mr-3">
                            <a href="?lang=es" class="px-3 py-2 <?php echo App\config\I18n::getLocale() === 'es' ? 'font-bold text-primary-600 border-b-2 border-primary-600' : 'text-gray-600'; ?>">ES</a>
                            <a href="?lang=en" class="px-3 py-2 <?php echo App\config\I18n::getLocale() === 'en' ? 'font-bold text-primary-600 border-b-2 border-primary-600' : 'text-gray-600'; ?>">EN</a>
                        </div>
                        <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i> <?php echo __('app.new'); ?>
                        </button>
                    </div>
                </div>

                <!-- Page Content -->
                <div class="py-2">
                    <?php echo $content ?? ''; ?>
                </div>
            </div>
            
            <!-- Footer -->
            <footer class="bg-white border-t mt-auto py-4 px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-500 mb-2 md:mb-0">
                        &copy; <?php echo date('Y'); ?> <?php echo __('app.app_name'); ?>. <?php echo __('app.all_rights_reserved'); ?>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <!-- Custom JavaScript -->
    <script src="<?php echo url('/js/app.js'); ?>"></script>
    
    <!-- Inicializar plugins en base al idioma -->
    <script>
        // Configurar idioma para DataTables
        const locale = '<?php echo App\config\I18n::getLocale(); ?>';
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
                order: [[0, 'desc']],
                dom: '<"flex flex-col md:flex-row justify-between"<"mb-2 md:mb-0"l><"mb-2 md:mb-0"f>>rt<"flex flex-col md:flex-row justify-between"<"mb-2 md:mb-0"i><"mb-2 md:mb-0"p>>',
            });
        });
    </script>
</body>
</html> 