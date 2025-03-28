# InvoHero

Sistema de gestión de facturas y contabilidad desarrollado en PHP.

## Requisitos

- PHP 8.1 o superior
- MySQL 5.7 o superior
- Composer
- Node.js y npm (para desarrollo)

## Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/invohero/invohero.git
cd invohero
```

2. Instalar dependencias de PHP:
```bash
composer install
```

3. Copiar el archivo de entorno:
```bash
cp .env.example .env
```

4. Configurar las variables de entorno en el archivo `.env`

5. Crear la base de datos:
```bash
mysql -u root -p < src/database/schema.sql
```

6. Configurar el servidor web (Apache/Nginx) para que apunte al directorio `src/public`

## Estructura del Proyecto

```
invohero/
├── src/
│   ├── config/         # Archivos de configuración
│   ├── controllers/    # Controladores
│   ├── models/        # Modelos
│   ├── views/         # Vistas
│   ├── lang/          # Archivos de traducción
│   ├── storage/       # Almacenamiento (caché, logs, uploads)
│   └── public/        # Punto de entrada público
├── tests/             # Pruebas unitarias
├── vendor/            # Dependencias de Composer
├── .env              # Variables de entorno
├── .env.example      # Plantilla de variables de entorno
├── composer.json     # Configuración de Composer
└── README.md         # Este archivo
```

## Desarrollo

1. Activar el modo de desarrollo en `.env`:
```
APP_ENV=development
APP_DEBUG=true
```

2. Ejecutar pruebas:
```bash
composer test
```

3. Verificar código:
```bash
composer check
```

## Producción

1. Activar el modo de producción en `.env`:
```
APP_ENV=production
APP_DEBUG=false
```

2. Optimizar el autoloader:
```bash
composer dump-autoload --optimize
```

3. Configurar el servidor web para usar HTTPS

## Seguridad

- No compartir el archivo `.env`
- Mantener las dependencias actualizadas
- Seguir las mejores prácticas de seguridad de PHP
- Usar HTTPS en producción

## Licencia

Este proyecto está licenciado bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles. 