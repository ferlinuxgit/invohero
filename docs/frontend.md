# Documentación del Frontend

## Visión General

El frontend de InvoHero está construido utilizando una combinación de tecnologías modernas:

- Tailwind CSS para estilos
- Alpine.js para interactividad
- Chart.js para gráficos
- DataTables para tablas interactivas
- SweetAlert2 para notificaciones

## Estructura de Archivos

```
public/
├── css/
│   ├── app.css
│   ├── tailwind.css
│   └── custom.css
├── js/
│   ├── app.js
│   ├── dashboard.js
│   ├── invoices.js
│   └── clients.js
└── img/
    ├── icons/
    ├── logos/
    └── uploads/
```

## Componentes Principales

### Layout Principal

```php
<!-- src/views/layouts/main.php -->
<!DOCTYPE html>
<html lang="<?php echo App\config\I18n::getLocale(); ?>">
<head>
    <!-- Meta tags -->
    <!-- CSS -->
    <!-- JavaScript -->
</head>
<body>
    <!-- Sidebar -->
    <!-- Header -->
    <!-- Main Content -->
    <!-- Footer -->
</body>
</html>
```

### Sidebar

```php
<!-- src/views/partials/sidebar.php -->
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg">
    <!-- Logo -->
    <!-- Navigation -->
    <!-- User Section -->
</aside>
```

### Header

```php
<!-- src/views/partials/header.php -->
<header class="bg-white shadow-sm">
    <!-- Mobile Navigation -->
    <!-- Language Switcher -->
    <!-- User Menu -->
</header>
```

## Estilos con Tailwind CSS

### Configuración

```javascript
// tailwind.config.js
module.exports = {
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    // ...
                }
            }
        }
    }
}
```

### Clases Personalizadas

```css
/* custom.css */
@layer components {
    .btn-primary {
        @apply bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700;
    }
    
    .card {
        @apply bg-white rounded-lg shadow-sm p-6;
    }
    
    .form-input {
        @apply w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500;
    }
}
```

## Interactividad con Alpine.js

### Componentes

```html
<!-- Ejemplo de un componente de factura -->
<div x-data="invoiceForm()">
    <form @submit.prevent="submit">
        <input type="text" x-model="form.number">
        <button type="submit">Guardar</button>
    </form>
</div>
```

### Scripts

```javascript
// js/app.js
function invoiceForm() {
    return {
        form: {
            number: '',
            client: '',
            date: '',
            items: []
        },
        submit() {
            // Lógica de envío
        }
    }
}
```

## Gráficos con Chart.js

### Configuración

```javascript
// js/dashboard.js
const chartConfig = {
    type: 'line',
    data: {
        labels: ['Ene', 'Feb', 'Mar'],
        datasets: [{
            label: 'Ingresos',
            data: [12, 19, 3],
            borderColor: '#0ea5e9'
        }]
    }
};
```

### Uso

```html
<canvas id="incomeChart"></canvas>

<script>
    const ctx = document.getElementById('incomeChart');
    new Chart(ctx, chartConfig);
</script>
```

## Tablas con DataTables

### Inicialización

```javascript
// js/app.js
$(document).ready(function() {
    $('.datatable').DataTable({
        language: {
            url: dtLanguageUrl
        },
        responsive: true,
        pageLength: 10
    });
});
```

### Uso en HTML

```html
<table class="datatable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <!-- Datos -->
    </tbody>
</table>
```

## Notificaciones con SweetAlert2

### Configuración Global

```javascript
// js/app.js
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
```

### Uso

```javascript
// Notificación de éxito
Toast.fire({
    icon: 'success',
    title: 'Operación completada'
});

// Confirmación
Swal.fire({
    title: '¿Estás seguro?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true
});
```

## Formularios

### Validación

```html
<form class="space-y-4" x-data="formValidation()">
    <div>
        <label class="block text-sm font-medium text-gray-700">
            Nombre
        </label>
        <input 
            type="text" 
            class="form-input"
            x-model="form.name"
            :class="{'border-red-500': errors.name}"
        >
        <p class="text-red-500 text-sm" x-show="errors.name" x-text="errors.name"></p>
    </div>
</form>
```

### Envío Asíncrono

```javascript
// js/app.js
async function submitForm(formData) {
    try {
        const response = await fetch('/api/invoices', {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            Toast.fire({
                icon: 'success',
                title: 'Factura creada'
            });
        }
    } catch (error) {
        Toast.fire({
            icon: 'error',
            title: 'Error al crear la factura'
        });
    }
}
```

## Componentes Reutilizables

### Botones

```html
<!-- src/views/partials/buttons.php -->
<button class="btn-primary">
    <i class="fas fa-save"></i>
    Guardar
</button>
```

### Tarjetas

```html
<!-- src/views/partials/cards.php -->
<div class="card">
    <h3 class="text-lg font-medium">Título</h3>
    <div class="mt-4">
        <!-- Contenido -->
    </div>
</div>
```

### Modales

```html
<!-- src/views/partials/modals.php -->
<div x-data="{ open: false }" class="modal">
    <div class="modal-content">
        <!-- Contenido -->
    </div>
</div>
```

## Responsive Design

### Breakpoints

```css
/* custom.css */
@layer utilities {
    .container {
        @apply px-4 sm:px-6 lg:px-8 mx-auto max-w-7xl;
    }
}
```

### Media Queries

```html
<!-- Ejemplo de menú responsive -->
<div class="lg:hidden">
    <!-- Menú móvil -->
</div>
<div class="hidden lg:block">
    <!-- Menú desktop -->
</div>
```

## Optimización

### Lazy Loading

```html
<!-- Cargar imágenes de forma diferida -->
<img loading="lazy" src="image.jpg" alt="Descripción">
```

### Caché de Assets

```php
<!-- En el layout principal -->
<link rel="stylesheet" href="<?php echo asset('css/app.css', true); ?>">
<script src="<?php echo asset('js/app.js', true); ?>"></script>
```

## Mejores Prácticas

### 1. Organización de CSS
- Usar clases de utilidad de Tailwind
- Crear componentes reutilizables
- Mantener la especificidad baja

### 2. JavaScript
- Usar módulos ES6
- Implementar manejo de errores
- Optimizar el rendimiento

### 3. Accesibilidad
- Usar atributos ARIA
- Mantener contraste adecuado
- Proporcionar textos alternativos

### 4. Rendimiento
- Minimizar archivos CSS/JS
- Optimizar imágenes
- Implementar lazy loading

## Solución de Problemas

### 1. Conflictos de Estilos
```css
/* Usar !important solo cuando sea necesario */
.important-class {
    @apply bg-red-500 !important;
}
```

### 2. Problemas de JavaScript
```javascript
// Verificar que Alpine.js está cargado
document.addEventListener('alpine:init', () => {
    // Inicialización
});
```

### 3. Problemas de Responsive
```html
<!-- Usar clases de debug -->
<div class="debug-screens">
    <div class="sm:hidden">Móvil</div>
    <div class="hidden sm:block md:hidden">Tablet</div>
    <div class="hidden md:block">Desktop</div>
</div>
``` 