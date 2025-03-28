# InvoHero - Sistema de Facturación y Contabilidad

Sistema moderno de facturación y contabilidad desarrollado con PHP, JavaScript, MySQL y Tailwind CSS.

## Requisitos

- PHP 8.2 o superior
- MySQL 8.0 o superior
- Composer
- Node.js y npm (opcional, para desarrollo)
- Extensión intl de PHP (para soporte multiidioma)

## Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/tu-usuario/invohero.git
cd invohero
```

2. Instalar dependencias de PHP:
```bash
composer install
```

3. Configurar el entorno:
```bash
cp .env.example .env
```

4. Configurar las variables de entorno en el archivo `.env`:
```env
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost
APP_BASE_PATH=

DB_HOST=localhost
DB_DATABASE=invohero
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_usuario
MAIL_PASSWORD=tu_contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@invohero.com
MAIL_FROM_NAME=InvoHero
```

5. Crear la base de datos:
```bash
mysql -u root -p
CREATE DATABASE invohero;
```

6. Importar la estructura de la base de datos:
```bash
mysql -u root -p invohero < src/database/schema.sql
```

7. Configurar el servidor web:
- Asegúrate de que el directorio raíz apunte al directorio principal de la aplicación
- Para un servidor Plesk, configura el directorio raíz al directorio principal donde se encuentra el archivo `index.php`

## Estructura del Proyecto

```
invohero/
├── src/
│   ├── config/         # Archivos de configuración
│   ├── lang/           # Archivos de idioma
│   │   ├── es/        # Español
│   │   └── en/        # Inglés
│   ├── controllers/    # Controladores
│   ├── models/        # Modelos
│   ├── views/         # Vistas
│   ├── public/        # Archivos públicos
│   │   ├── css/      # Estilos CSS
│   │   ├── js/       # JavaScript
│   │   └── img/      # Imágenes
│   └── database/     # Scripts de base de datos
├── tests/            # Tests unitarios
├── vendor/           # Dependencias de Composer
├── .env              # Variables de entorno
├── .env.example      # Ejemplo de variables de entorno
├── composer.json     # Configuración de Composer
├── index.php         # Archivo principal para servidores Plesk
└── README.md         # Este archivo
```

## Características

- Dashboard moderno con gráficos interactivos
- Gestión de facturas y clientes
- Sistema de contabilidad básico
- Interfaz responsiva con Tailwind CSS
- Tablas interactivas con DataTables
- Notificaciones con SweetAlert2
- Gráficos con Chart.js
- Interactividad con Alpine.js
- Soporte multiidioma (español e inglés)
- Código en inglés con comentarios en español
- Formateo automático de fechas y monedas según el idioma

## Soporte Multiidioma

La aplicación está preparada para soportar múltiples idiomas:

- Para cambiar el idioma, use los botones de idioma en la esquina superior derecha
- También puede cambiar el idioma a través de la URL agregando `?lang=es` o `?lang=en`
- Para agregar nuevos idiomas:
  1. Cree una nueva carpeta en `src/lang/` con el código del idioma
  2. Copie los archivos de traducción de otro idioma y tradúzcalos
  3. Actualice la clase `I18n` si es necesario

## Desarrollo

Para contribuir al proyecto:

1. Crear una rama para tu feature:
```bash
git checkout -b feature/nueva-caracteristica
```

2. Realizar tus cambios y commit:
```bash
git add .
git commit -m "Añadir nueva característica"
```

3. Push a tu rama:
```bash
git push origin feature/nueva-caracteristica
```

4. Crear un Pull Request

## Convenciones de Código

- Nombres de clases, métodos, variables y funciones en inglés
- Comentarios en español
- Camel case para variables y métodos: `invoiceNumber`, `getInvoice()`
- Pascal case para nombres de clases: `InvoiceController`
- Utilizar las funciones de traducción `__()` para todos los textos visibles al usuario

## Licencia

Este proyecto está licenciado bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles. 