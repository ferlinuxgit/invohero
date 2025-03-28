# Estructura del Proyecto

## Descripción General

La estructura del proyecto sigue el patrón MVC (Modelo-Vista-Controlador) y está organizada de manera modular para facilitar el mantenimiento y la escalabilidad.

```
invohero/
├── src/
│   ├── config/           # Configuraciones de la aplicación
│   ├── controllers/      # Controladores de la aplicación
│   ├── models/          # Modelos de la base de datos
│   ├── views/           # Vistas y plantillas
│   ├── lang/            # Archivos de internacionalización
│   ├── helpers/         # Funciones auxiliares
│   └── services/        # Servicios y lógica de negocio
├── public/              # Archivos públicos
│   ├── css/            # Estilos CSS
│   ├── js/             # Scripts JavaScript
│   ├── img/            # Imágenes
│   └── index.php       # Punto de entrada
├── docs/               # Documentación
├── tests/              # Pruebas unitarias y de integración
└── vendor/             # Dependencias de Composer
```

## Descripción Detallada de Directorios

### `/src`

#### `/config`
- `app.php`: Configuración general de la aplicación
- `database.php`: Configuración de la base de datos
- `i18n.php`: Configuración de internacionalización
- `routes.php`: Definición de rutas
- `security.php`: Configuraciones de seguridad

#### `/controllers`
- `AuthController.php`: Gestión de autenticación
- `DashboardController.php`: Controlador del panel principal
- `InvoiceController.php`: Gestión de facturas
- `ClientController.php`: Gestión de clientes
- `AccountingController.php`: Gestión contable

#### `/models`
- `User.php`: Modelo de usuarios
- `Invoice.php`: Modelo de facturas
- `Client.php`: Modelo de clientes
- `Transaction.php`: Modelo de transacciones
- `Product.php`: Modelo de productos

#### `/views`
- `/layouts`: Plantillas principales
  - `main.php`: Plantilla base
  - `auth.php`: Plantilla de autenticación
- `/dashboard`: Vistas del panel de control
- `/invoices`: Vistas de facturas
- `/clients`: Vistas de clientes
- `/accounting`: Vistas contables
- `/partials`: Componentes reutilizables

#### `/lang`
- `/es`: Traducciones en español
  - `app.php`: Traducciones generales
  - `validation.php`: Mensajes de validación
- `/en`: Traducciones en inglés
  - `app.php`: Traducciones generales
  - `validation.php`: Mensajes de validación

#### `/helpers`
- `AuthHelper.php`: Funciones de autenticación
- `FormatHelper.php`: Funciones de formateo
- `ValidationHelper.php`: Funciones de validación
- `DateHelper.php`: Funciones de manejo de fechas

#### `/services`
- `InvoiceService.php`: Lógica de negocio de facturas
- `ClientService.php`: Lógica de negocio de clientes
- `AccountingService.php`: Lógica de negocio contable
- `ExportService.php`: Servicios de exportación

### `/public`

#### `/css`
- `app.css`: Estilos principales
- `tailwind.css`: Estilos de Tailwind
- `custom.css`: Estilos personalizados

#### `/js`
- `app.js`: JavaScript principal
- `dashboard.js`: Scripts del panel de control
- `invoices.js`: Scripts de facturas
- `clients.js`: Scripts de clientes

#### `/img`
- `/icons`: Iconos de la aplicación
- `/logos`: Logos y marcas
- `/uploads`: Archivos subidos por usuarios

### `/tests`

#### `/unit`
- Pruebas unitarias de modelos
- Pruebas unitarias de servicios
- Pruebas unitarias de helpers

#### `/integration`
- Pruebas de integración de controladores
- Pruebas de integración de API
- Pruebas de integración de base de datos

## Convenciones de Nombrado

### Archivos
- Controladores: `PascalCase` + `Controller.php`
- Modelos: `PascalCase.php`
- Vistas: `snake_case.php`
- Helpers: `PascalCase` + `Helper.php`
- Servicios: `PascalCase` + `Service.php`

### Clases
- Controladores: `PascalCase` + `Controller`
- Modelos: `PascalCase`
- Helpers: `PascalCase` + `Helper`
- Servicios: `PascalCase` + `Service`

### Métodos
- Controladores: `camelCase` + acción (index, create, store, etc.)
- Modelos: `camelCase` (get, set, find, etc.)
- Helpers: `camelCase`
- Servicios: `camelCase`

### Variables
- Propiedades de clase: `camelCase`
- Variables locales: `camelCase`
- Constantes: `UPPER_SNAKE_CASE`

## Flujo de Datos

1. **Request HTTP**
   - Entra por `public/index.php`
   - Es procesado por el router
   - Se dirige al controlador correspondiente

2. **Controlador**
   - Recibe la request
   - Valida los datos
   - Llama a los servicios necesarios
   - Prepara los datos para la vista

3. **Servicio**
   - Contiene la lógica de negocio
   - Interactúa con los modelos
   - Procesa los datos

4. **Modelo**
   - Interactúa con la base de datos
   - Define las relaciones
   - Maneja la validación de datos

5. **Vista**
   - Recibe los datos del controlador
   - Renderiza la plantilla
   - Genera la respuesta HTML

6. **Response HTTP**
   - Envía la respuesta al cliente
   - Incluye headers y cookies necesarios 