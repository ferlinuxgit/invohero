# Documentación de la API

## Visión General

La API de InvoHero está diseñada siguiendo los principios RESTful y utiliza JWT para la autenticación. Todos los endpoints devuelven respuestas en formato JSON.

## Autenticación

### Obtener Token

```http
POST /api/auth/login
Content-Type: application/json

{
    "email": "usuario@example.com",
    "password": "contraseña"
}
```

### Respuesta

```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "user": {
        "id": 1,
        "name": "Usuario",
        "email": "usuario@example.com",
        "role": "admin"
    }
}
```

### Uso del Token

```http
GET /api/invoices
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
```

## Endpoints

### Facturas

#### Listar Facturas

```http
GET /api/invoices
```

Parámetros de consulta:
- `page`: Número de página (default: 1)
- `per_page`: Elementos por página (default: 10)
- `status`: Filtrar por estado
- `client_id`: Filtrar por cliente
- `date_from`: Filtrar por fecha inicial
- `date_to`: Filtrar por fecha final

Respuesta:
```json
{
    "data": [
        {
            "id": 1,
            "number": "INV-001",
            "client": {
                "id": 1,
                "name": "Cliente Ejemplo"
            },
            "issue_date": "2024-03-28",
            "due_date": "2024-04-28",
            "total": 1000.00,
            "status": "paid"
        }
    ],
    "meta": {
        "current_page": 1,
        "per_page": 10,
        "total": 100
    }
}
```

#### Obtener Factura

```http
GET /api/invoices/{id}
```

Respuesta:
```json
{
    "id": 1,
    "number": "INV-001",
    "client": {
        "id": 1,
        "name": "Cliente Ejemplo",
        "email": "cliente@example.com"
    },
    "issue_date": "2024-03-28",
    "due_date": "2024-04-28",
    "items": [
        {
            "id": 1,
            "description": "Producto 1",
            "quantity": 2,
            "unit_price": 500.00,
            "amount": 1000.00
        }
    ],
    "subtotal": 1000.00,
    "tax_rate": 21.00,
    "tax_amount": 210.00,
    "total": 1210.00,
    "status": "paid",
    "notes": "Notas de la factura"
}
```

#### Crear Factura

```http
POST /api/invoices
Content-Type: application/json

{
    "client_id": 1,
    "issue_date": "2024-03-28",
    "due_date": "2024-04-28",
    "items": [
        {
            "description": "Producto 1",
            "quantity": 2,
            "unit_price": 500.00
        }
    ],
    "tax_rate": 21.00,
    "notes": "Notas de la factura"
}
```

#### Actualizar Factura

```http
PUT /api/invoices/{id}
Content-Type: application/json

{
    "client_id": 1,
    "issue_date": "2024-03-28",
    "due_date": "2024-04-28",
    "items": [
        {
            "id": 1,
            "description": "Producto 1",
            "quantity": 3,
            "unit_price": 500.00
        }
    ],
    "tax_rate": 21.00,
    "notes": "Notas actualizadas"
}
```

#### Eliminar Factura

```http
DELETE /api/invoices/{id}
```

### Clientes

#### Listar Clientes

```http
GET /api/clients
```

Parámetros de consulta:
- `page`: Número de página
- `per_page`: Elementos por página
- `search`: Búsqueda por nombre o email
- `status`: Filtrar por estado

Respuesta:
```json
{
    "data": [
        {
            "id": 1,
            "name": "Cliente Ejemplo",
            "email": "cliente@example.com",
            "phone": "123456789",
            "status": "active"
        }
    ],
    "meta": {
        "current_page": 1,
        "per_page": 10,
        "total": 50
    }
}
```

#### Obtener Cliente

```http
GET /api/clients/{id}
```

#### Crear Cliente

```http
POST /api/clients
Content-Type: application/json

{
    "name": "Nuevo Cliente",
    "email": "nuevo@example.com",
    "phone": "123456789",
    "address": "Dirección del cliente",
    "tax_id": "B12345678"
}
```

#### Actualizar Cliente

```http
PUT /api/clients/{id}
Content-Type: application/json

{
    "name": "Cliente Actualizado",
    "email": "actualizado@example.com",
    "phone": "987654321",
    "address": "Nueva dirección",
    "tax_id": "B87654321"
}
```

#### Eliminar Cliente

```http
DELETE /api/clients/{id}
```

### Contabilidad

#### Obtener Balance

```http
GET /api/accounting/balance
```

Parámetros de consulta:
- `start_date`: Fecha inicial
- `end_date`: Fecha final

Respuesta:
```json
{
    "income": {
        "total": 5000.00,
        "by_category": [
            {
                "category": "Ventas",
                "amount": 4000.00
            },
            {
                "category": "Servicios",
                "amount": 1000.00
            }
        ]
    },
    "expenses": {
        "total": 3000.00,
        "by_category": [
            {
                "category": "Gastos Operativos",
                "amount": 2000.00
            },
            {
                "category": "Marketing",
                "amount": 1000.00
            }
        ]
    },
    "balance": 2000.00
}
```

#### Registrar Transacción

```http
POST /api/accounting/transactions
Content-Type: application/json

{
    "type": "income",
    "amount": 1000.00,
    "description": "Venta de producto",
    "category_id": 1,
    "date": "2024-03-28",
    "invoice_id": 1
}
```

### Productos

#### Listar Productos

```http
GET /api/products
```

Parámetros de consulta:
- `page`: Número de página
- `per_page`: Elementos por página
- `search`: Búsqueda por nombre o SKU
- `category_id`: Filtrar por categoría
- `status`: Filtrar por estado

#### Crear Producto

```http
POST /api/products
Content-Type: application/json

{
    "name": "Nuevo Producto",
    "description": "Descripción del producto",
    "sku": "PROD-001",
    "price": 100.00,
    "stock": 10,
    "category_id": 1
}
```

## Manejo de Errores

### Códigos de Estado HTTP

- `200`: Éxito
- `201`: Creado
- `400`: Error de validación
- `401`: No autorizado
- `403`: Prohibido
- `404`: No encontrado
- `422`: Error de validación
- `500`: Error interno del servidor

### Formato de Error

```json
{
    "error": {
        "code": "VALIDATION_ERROR",
        "message": "Los datos proporcionados no son válidos",
        "details": {
            "email": ["El campo email es obligatorio"],
            "password": ["La contraseña debe tener al menos 8 caracteres"]
        }
    }
}
```

## Rate Limiting

La API implementa rate limiting para prevenir abusos:

- 60 peticiones por minuto por IP
- 1000 peticiones por hora por usuario

### Headers de Rate Limiting

```http
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
X-RateLimit-Reset: 1616789012
```

## Versión

La API está versionada en la URL:

```
/api/v1/invoices
/api/v1/clients
```

## Seguridad

### CORS

La API permite peticiones CORS desde dominios autorizados:

```php
'cors' => [
    'allowed_origins' => ['https://app.invohero.com'],
    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],
    'allowed_headers' => ['Content-Type', 'Authorization'],
    'exposed_headers' => ['X-RateLimit-Limit'],
    'max_age' => 86400,
]
```

### Sanitización

- Todos los inputs son sanitizados
- Se implementa protección contra XSS
- Se validan todos los datos de entrada

## Ejemplos de Uso

### PHP

```php
$client = new \GuzzleHttp\Client();

$response = $client->post('https://api.invohero.com/api/auth/login', [
    'json' => [
        'email' => 'usuario@example.com',
        'password' => 'contraseña'
    ]
]);

$token = json_decode($response->getBody())->token;

$invoices = $client->get('https://api.invohero.com/api/invoices', [
    'headers' => [
        'Authorization' => "Bearer {$token}"
    ]
]);
```

### JavaScript

```javascript
async function login(email, password) {
    const response = await fetch('https://api.invohero.com/api/auth/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email, password })
    });
    
    const data = await response.json();
    localStorage.setItem('token', data.token);
    return data;
}

async function getInvoices() {
    const token = localStorage.getItem('token');
    const response = await fetch('https://api.invohero.com/api/invoices', {
        headers: {
            'Authorization': `Bearer ${token}`
        }
    });
    
    return await response.json();
}
```

### Python

```python
import requests

def login(email, password):
    response = requests.post(
        'https://api.invohero.com/api/auth/login',
        json={'email': email, 'password': password}
    )
    return response.json()

def get_invoices(token):
    response = requests.get(
        'https://api.invohero.com/api/invoices',
        headers={'Authorization': f'Bearer {token}'}
    )
    return response.json()
``` 