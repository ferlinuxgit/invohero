<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
    <title><?php echo $title; ?> - InvoHero</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false }">
    <!-- Barra lateral -->
    <div class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out"
         :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
        <div class="flex flex-col h-full">
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-4 border-b">
                <a href="/" class="flex items-center">
                    <i class="fas fa-file-invoice text-blue-600 text-2xl mr-2"></i>
                    <span class="text-xl font-bold text-gray-800">InvoHero</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>

            <!-- Menú principal -->
            <nav class="flex-1 px-2 py-4 space-y-1">
                <a href="/dashboard" class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-lg <?php echo $current_page === 'dashboard' ? 'bg-blue-50 text-blue-600' : ''; ?>">
                    <i class="fas fa-chart-line w-6"></i>
                    <span><?php echo $lang === 'es' ? 'Dashboard' : 'Dashboard'; ?></span>
                </a>
                <a href="/invoices" class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-lg <?php echo $current_page === 'invoices' ? 'bg-blue-50 text-blue-600' : ''; ?>">
                    <i class="fas fa-file-invoice w-6"></i>
                    <span><?php echo $lang === 'es' ? 'Facturas' : 'Invoices'; ?></span>
                </a>
                <a href="/clients" class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-lg <?php echo $current_page === 'clients' ? 'bg-blue-50 text-blue-600' : ''; ?>">
                    <i class="fas fa-users w-6"></i>
                    <span><?php echo $lang === 'es' ? 'Clientes' : 'Clients'; ?></span>
                </a>
                <a href="/products" class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-lg <?php echo $current_page === 'products' ? 'bg-blue-50 text-blue-600' : ''; ?>">
                    <i class="fas fa-box w-6"></i>
                    <span><?php echo $lang === 'es' ? 'Productos' : 'Products'; ?></span>
                </a>
                <a href="/accounting" class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-lg <?php echo $current_page === 'accounting' ? 'bg-blue-50 text-blue-600' : ''; ?>">
                    <i class="fas fa-calculator w-6"></i>
                    <span><?php echo $lang === 'es' ? 'Contabilidad' : 'Accounting'; ?></span>
                </a>
                <a href="/reports" class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-lg <?php echo $current_page === 'reports' ? 'bg-blue-50 text-blue-600' : ''; ?>">
                    <i class="fas fa-chart-bar w-6"></i>
                    <span><?php echo $lang === 'es' ? 'Informes' : 'Reports'; ?></span>
                </a>
            </nav>

            <!-- Selector de idioma -->
            <div class="p-4 border-t">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600"><?php echo $lang === 'es' ? 'Idioma' : 'Language'; ?></span>
                    <div class="flex space-x-2">
                        <a href="?lang=es" class="text-sm <?php echo $lang === 'es' ? 'text-blue-600 font-semibold' : 'text-gray-500 hover:text-gray-700'; ?>">ES</a>
                        <a href="?lang=en" class="text-sm <?php echo $lang === 'en' ? 'text-blue-600 font-semibold' : 'text-gray-500 hover:text-gray-700'; ?>">EN</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="lg:ml-64">
        <!-- Barra superior -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between h-16 px-4">
                <button @click="sidebarOpen = true" class="lg:hidden">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="flex items-center text-gray-700 hover:text-gray-900">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                        </button>
                    </div>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['name']); ?>&background=0D9488&color=fff" 
                                 alt="<?php echo htmlspecialchars($user['name']); ?>" 
                                 class="h-8 w-8 rounded-full">
                            <span class="hidden md:block"><?php echo htmlspecialchars($user['name']); ?></span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                        <div x-show="open" 
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user-circle mr-2"></i>
                                <?php echo $lang === 'es' ? 'Perfil' : 'Profile'; ?>
                            </a>
                            <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>
                                <?php echo $lang === 'es' ? 'Configuración' : 'Settings'; ?>
                            </a>
                            <form action="/logout" method="POST" class="block">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    <?php echo $lang === 'es' ? 'Cerrar Sesión' : 'Logout'; ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenido de la página -->
        <main class="p-6">
            <?php echo $content; ?>
        </main>
    </div>
</body>
</html> 