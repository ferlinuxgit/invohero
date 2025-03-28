# Documentación de Seguridad

## Visión General

InvoHero implementa múltiples capas de seguridad para proteger la aplicación y los datos de los usuarios. Este documento describe las medidas de seguridad implementadas y las mejores prácticas a seguir.

## Autenticación

### JWT (JSON Web Tokens)

```php
// Configuración de JWT
'jwt' => [
    'secret' => env('JWT_SECRET'),
    'ttl' => 60 * 24, // 24 horas
    'refresh_ttl' => 60 * 24 * 7, // 7 días
    'algo' => 'HS256',
    'required_claims' => [
        'iss',
        'iat',
        'exp',
        'nbf',
        'sub',
        'jti',
    ],
    'persistent_claims' => [
        'role',
        'permissions',
    ],
    'lock_subject' => true,
    'leeway' => env('JWT_LEEWAY', 0),
    'blacklist_enabled' => true,
    'blacklist_grace_period' => env('JWT_BLACKLIST_GRACE_PERIOD', 0),
]
```

### Contraseñas

- Almacenamiento seguro con bcrypt
- Requisitos mínimos:
  - 8 caracteres
  - Al menos una mayúscula
  - Al menos una minúscula
  - Al menos un número
  - Al menos un carácter especial

```php
// Validación de contraseña
public function validatePassword($password)
{
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
}
```

### Autenticación de Dos Factores (2FA)

```php
// Implementación de 2FA
public function enable2FA($user)
{
    $secret = Google2FA::generateSecretKey();
    $user->two_factor_secret = $secret;
    $user->two_factor_enabled = true;
    $user->save();
    
    return Google2FA::getQRCodeUrl(
        config('app.name'),
        $user->email,
        $secret
    );
}
```

## Autorización

### Roles y Permisos

```php
// Definición de roles
const ROLES = [
    'admin' => 'Administrador',
    'user' => 'Usuario',
    'accountant' => 'Contable',
];

// Definición de permisos
const PERMISSIONS = [
    'view_invoices' => 'Ver facturas',
    'create_invoices' => 'Crear facturas',
    'edit_invoices' => 'Editar facturas',
    'delete_invoices' => 'Eliminar facturas',
    // ...
];

// Asignación de permisos a roles
const ROLE_PERMISSIONS = [
    'admin' => ['*'],
    'user' => [
        'view_invoices',
        'create_invoices',
        'edit_invoices',
    ],
    'accountant' => [
        'view_invoices',
        'create_invoices',
        'edit_invoices',
        'view_accounting',
        'manage_accounting',
    ],
];
```

### Middleware de Autorización

```php
class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        if (!$request->user()->hasPermission($permission)) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }
        
        return $next($request);
    }
}
```

## Protección contra Ataques

### XSS (Cross-Site Scripting)

```php
// Sanitización de datos
public function sanitize($data)
{
    if (is_array($data)) {
        return array_map([$this, 'sanitize'], $data);
    }
    
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// En vistas
<?php echo e($user->name); ?>
```

### CSRF (Cross-Site Request Forgery)

```php
// Token CSRF en formularios
<form method="POST" action="/invoices">
    @csrf
    <!-- campos del formulario -->
</form>

// Verificación de token
if (!$this->validateCsrfToken($request->input('_token'))) {
    throw new TokenMismatchException;
}
```

### SQL Injection

```php
// Uso de consultas preparadas
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);

// Uso de Eloquent
User::find($id);
User::where('email', $email)->first();
```

### Inyección de Comandos

```php
// Validación de entrada
public function validateCommand($command)
{
    return preg_match('/^[a-zA-Z0-9\s\-_]+$/', $command);
}

// Escapado de comandos
$command = escapeshellcmd($command);
```

## Seguridad de Datos

### Encriptación

```php
// Encriptación de datos sensibles
public function encrypt($data)
{
    return encrypt($data);
}

public function decrypt($data)
{
    return decrypt($data);
}
```

### Almacenamiento Seguro

```php
// Configuración de almacenamiento
'filesystems' => [
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'secure' => [
            'driver' => 'local',
            'root' => storage_path('app/secure'),
            'url' => env('APP_URL').'/secure',
            'visibility' => 'private',
        ],
    ],
]
```

## Protección de API

### Rate Limiting

```php
// Configuración de rate limiting
'api' => [
    'throttle' => [
        'enabled' => true,
        'attempts' => 60,
        'decay_minutes' => 1,
    ],
]
```

### CORS

```php
// Configuración de CORS
'cors' => [
    'paths' => ['api/*'],
    'allowed_origins' => ['https://app.invohero.com'],
    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],
    'allowed_headers' => ['Content-Type', 'Authorization'],
    'exposed_headers' => ['X-RateLimit-Limit'],
    'max_age' => 86400,
]
```

## Logs de Seguridad

### Registro de Eventos

```php
// Registro de eventos de seguridad
public function logSecurityEvent($event, $details)
{
    SecurityLog::create([
        'user_id' => auth()->id(),
        'event' => $event,
        'details' => $details,
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);
}
```

### Monitoreo

```php
// Monitoreo de intentos de inicio de sesión
public function monitorLoginAttempts($email, $success)
{
    LoginAttempt::create([
        'email' => $email,
        'success' => $success,
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);
}
```

## Mejores Prácticas

### 1. Manejo de Sesiones

```php
// Configuración de sesiones
'session' => [
    'driver' => 'redis',
    'lifetime' => 120,
    'expire_on_close' => false,
    'secure' => true,
    'http_only' => true,
    'same_site' => 'lax',
]
```

### 2. Headers de Seguridad

```php
// Middleware de seguridad
public function handle($request, Closure $next)
{
    $response = $next($request);
    
    $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
    $response->headers->set('X-XSS-Protection', '1; mode=block');
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
    $response->headers->set('Content-Security-Policy', "default-src 'self'");
    
    return $response;
}
```

### 3. Validación de Datos

```php
// Reglas de validación
$rules = [
    'email' => 'required|email|max:255',
    'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
    'name' => 'required|string|max:255',
    'phone' => 'required|regex:/^[0-9]{9}$/',
];
```

## Procedimientos de Emergencia

### 1. Compromiso de Cuenta

```php
// Bloqueo de cuenta
public function lockAccount($userId)
{
    $user = User::find($userId);
    $user->locked = true;
    $user->locked_at = now();
    $user->save();
    
    // Notificar al usuario
    $user->notify(new AccountLockedNotification());
    
    // Registrar evento
    $this->logSecurityEvent('account_locked', [
        'user_id' => $userId,
        'reason' => 'suspicious_activity'
    ]);
}
```

### 2. Respaldo de Datos

```php
// Procedimiento de respaldo
public function backupData()
{
    $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    $command = sprintf(
        'mysqldump -u%s -p%s %s > %s',
        config('database.connections.mysql.username'),
        config('database.connections.mysql.password'),
        config('database.connections.mysql.database'),
        storage_path('app/backups/' . $filename)
    );
    
    exec($command);
    
    // Comprimir backup
    $zip = new ZipArchive();
    $zip->open(storage_path('app/backups/' . $filename . '.zip'), ZipArchive::CREATE);
    $zip->addFile(storage_path('app/backups/' . $filename), $filename);
    $zip->close();
    
    // Eliminar archivo SQL original
    unlink(storage_path('app/backups/' . $filename));
}
```

## Auditoría de Seguridad

### 1. Escaneo de Vulnerabilidades

```bash
# Instalar dependencias de seguridad
composer require --dev sensiolabs/security-checker

# Ejecutar escaneo
./vendor/bin/security-checker security:check composer.lock
```

### 2. Análisis de Código

```bash
# Instalar PHPStan
composer require --dev phpstan/phpstan

# Ejecutar análisis
./vendor/bin/phpstan analyse src tests
```

### 3. Pruebas de Seguridad

```php
// Pruebas de seguridad
public function testSecurityHeaders()
{
    $response = $this->get('/');
    
    $response->assertHeader('X-Frame-Options');
    $response->assertHeader('X-XSS-Protection');
    $response->assertHeader('X-Content-Type-Options');
}
```

## Actualizaciones de Seguridad

### 1. Procedimiento de Actualización

```bash
# Actualizar dependencias
composer update

# Verificar vulnerabilidades
composer audit

# Actualizar base de datos
php artisan migrate
```

### 2. Monitoreo de Vulnerabilidades

```php
// Verificar actualizaciones de seguridad
public function checkSecurityUpdates()
{
    $packages = json_decode(file_get_contents('composer.lock'), true)['packages'];
    
    foreach ($packages as $package) {
        $vulnerabilities = $this->securityChecker->check($package['name'], $package['version']);
        
        if (!empty($vulnerabilities)) {
            $this->notifySecurityTeam($package['name'], $vulnerabilities);
        }
    }
}
``` 