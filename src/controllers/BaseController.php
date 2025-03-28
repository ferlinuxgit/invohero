<?php
/**
 * Controlador base que maneja la lógica común y las rutas
 */
class BaseController {
    protected $db;
    protected $lang;
    protected $user;

    public function __construct() {
        // Inicializar conexión a base de datos
        $this->db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        // Obtener idioma de la sesión o usar el predeterminado
        $this->lang = $_SESSION['lang'] ?? 'es';

        // Obtener usuario de la sesión
        $this->user = $_SESSION['user'] ?? null;

        // Verificar autenticación
        if (!$this->user && !$this->isPublicRoute()) {
            header('Location: /login');
            exit;
        }
    }

    /**
     * Verifica si la ruta actual es pública
     */
    protected function isPublicRoute() {
        $publicRoutes = ['/login', '/register', '/forgot-password'];
        return in_array($_SERVER['REQUEST_URI'], $publicRoutes);
    }

    /**
     * Renderiza una vista
     */
    protected function render($view, $data = []) {
        // Extraer variables para la vista
        extract($data);

        // Incluir el layout principal
        include __DIR__ . '/../views/layouts/app.php';
    }

    /**
     * Maneja las rutas de la aplicación
     */
    public function handleRoute($route) {
        switch ($route) {
            case '/':
            case '/dashboard':
                $this->render('dashboard', [
                    'title' => $this->lang === 'es' ? 'Dashboard' : 'Dashboard',
                    'current_page' => 'dashboard'
                ]);
                break;

            case '/invoices':
                $invoices = $this->getInvoices();
                $clients = $this->getClients();
                $this->render('invoices/index', [
                    'title' => $this->lang === 'es' ? 'Facturas' : 'Invoices',
                    'current_page' => 'invoices',
                    'invoices' => $invoices,
                    'clients' => $clients
                ]);
                break;

            case '/clients':
                $clients = $this->getClients();
                $countries = $this->getCountries();
                $this->render('clients/index', [
                    'title' => $this->lang === 'es' ? 'Clientes' : 'Clients',
                    'current_page' => 'clients',
                    'clients' => $clients,
                    'countries' => $countries
                ]);
                break;

            case '/accounting':
                $transactions = $this->getTransactions();
                $categories = $this->getCategories();
                $this->render('accounting/index', [
                    'title' => $this->lang === 'es' ? 'Contabilidad' : 'Accounting',
                    'current_page' => 'accounting',
                    'transactions' => $transactions,
                    'categories' => $categories
                ]);
                break;

            default:
                $this->render('404', [
                    'title' => '404 - Not Found',
                    'current_page' => '404'
                ]);
        }
    }

    /**
     * Obtiene las facturas de la base de datos
     */
    protected function getInvoices() {
        $stmt = $this->db->query("
            SELECT i.*, c.name as client_name 
            FROM invoices i 
            LEFT JOIN clients c ON i.client_id = c.id 
            ORDER BY i.date DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene los clientes de la base de datos
     */
    protected function getClients() {
        $stmt = $this->db->query("
            SELECT * FROM clients 
            ORDER BY name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene los países de la base de datos
     */
    protected function getCountries() {
        $stmt = $this->db->query("
            SELECT * FROM countries 
            ORDER BY name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene las transacciones de la base de datos
     */
    protected function getTransactions() {
        $stmt = $this->db->query("
            SELECT t.*, c.name as category_name 
            FROM transactions t 
            LEFT JOIN categories c ON t.category_id = c.id 
            ORDER BY t.date DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene las categorías de la base de datos
     */
    protected function getCategories() {
        $stmt = $this->db->query("
            SELECT * FROM categories 
            ORDER BY name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 