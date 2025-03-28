# Guía de Despliegue

## Requisitos del Servidor

### Hardware Recomendado
- CPU: 2+ cores
- RAM: 4GB mínimo
- Disco: 20GB mínimo SSD
- Ancho de banda: 1TB/mes

### Software Requerido
- PHP 8.x
- MySQL 8.x
- Nginx/Apache
- Redis (opcional, para caché)
- Composer
- Node.js y npm

## Preparación del Servidor

### 1. Actualizar el Sistema

```bash
# Actualizar paquetes
sudo apt update
sudo apt upgrade -y

# Instalar dependencias básicas
sudo apt install -y curl git unzip
```

### 2. Instalar PHP y Extensiones

```bash
# Añadir repositorio PHP
sudo add-apt-repository ppa:ondrej/php
sudo apt update

# Instalar PHP y extensiones
sudo apt install -y php8.1-fpm php8.1-cli php8.1-mysql php8.1-zip \
    php8.1-gd php8.1-mbstring php8.1-curl php8.1-xml php8.1-bcmath \
    php8.1-json php8.1-redis php8.1-intl

# Verificar instalación
php -v
```

### 3. Instalar MySQL

```bash
# Instalar MySQL
sudo apt install -y mysql-server

# Configurar MySQL
sudo mysql_secure_installation

# Crear base de datos y usuario
sudo mysql -u root -p

CREATE DATABASE invohero CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'invohero'@'localhost' IDENTIFIED BY 'contraseña_segura';
GRANT ALL PRIVILEGES ON invohero.* TO 'invohero'@'localhost';
FLUSH PRIVILEGES;
```

### 4. Instalar Nginx

```bash
# Instalar Nginx
sudo apt install -y nginx

# Configurar Nginx
sudo nano /etc/nginx/sites-available/invohero
```

```nginx
server {
    listen 80;
    server_name invohero.com;
    root /var/www/invohero/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Configuración de SSL
    listen 443 ssl http2;
    ssl_certificate /etc/letsencrypt/live/invohero.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/invohero.com/privkey.pem;
    ssl_trusted_certificate /etc/letsencrypt/live/invohero.com/chain.pem;
}
```

### 5. Instalar SSL con Let's Encrypt

```bash
# Instalar Certbot
sudo apt install -y certbot python3-certbot-nginx

# Obtener certificado SSL
sudo certbot --nginx -d invohero.com
```

## Despliegue de la Aplicación

### 1. Clonar el Repositorio

```bash
# Crear directorio
sudo mkdir -p /var/www/invohero

# Clonar repositorio
sudo git clone https://github.com/tu-usuario/invohero.git /var/www/invohero

# Establecer permisos
sudo chown -R www-data:www-data /var/www/invohero
sudo chmod -R 755 /var/www/invohero
```

### 2. Instalar Dependencias

```bash
# Instalar dependencias de PHP
cd /var/www/invohero
composer install --no-dev --optimize-autoloader

# Instalar dependencias de Node.js
npm install
npm run build
```

### 3. Configurar Variables de Entorno

```bash
# Copiar archivo de ejemplo
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Editar archivo .env
nano .env
```

```env
APP_NAME=InvoHero
APP_ENV=production
APP_DEBUG=false
APP_URL=https://invohero.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invohero
DB_USERNAME=invohero
DB_PASSWORD=contraseña_segura

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@example.com
MAIL_PASSWORD=tu_contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Configurar Base de Datos

```bash
# Ejecutar migraciones
php artisan migrate

# Cargar datos de ejemplo (opcional)
php artisan db:seed
```

### 5. Optimizar la Aplicación

```bash
# Limpiar caché
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimizar autoloader
composer dump-autoload --optimize
```

## Configuración de Supervisor

### 1. Instalar Supervisor

```bash
sudo apt install -y supervisor
```

### 2. Configurar Procesos

```bash
sudo nano /etc/supervisor/conf.d/invohero.conf
```

```ini
[program:invohero-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/invohero/artisan queue:work
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/invohero/storage/logs/worker.log
```

### 3. Reiniciar Supervisor

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start invohero-worker:*
```

## Monitoreo y Mantenimiento

### 1. Configurar Logs

```bash
# Configurar rotación de logs
sudo nano /etc/logrotate.d/invohero
```

```conf
/var/www/invohero/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
    postrotate
        /usr/bin/supervisorctl reload >/dev/null 2>&1 || true
    endscript
}
```

### 2. Configurar Backups

```bash
# Crear script de backup
sudo nano /usr/local/bin/backup-invohero.sh
```

```bash
#!/bin/bash

# Configuración
BACKUP_DIR="/var/backups/invohero"
DB_NAME="invohero"
DB_USER="invohero"
DB_PASS="contraseña_segura"
APP_DIR="/var/www/invohero"
DATE=$(date +%Y%m%d_%H%M%S)

# Crear directorio de backup
mkdir -p $BACKUP_DIR

# Backup de base de datos
mysqldump -u$DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_$DATE.sql

# Backup de archivos
tar -czf $BACKUP_DIR/files_$DATE.tar.gz $APP_DIR

# Eliminar backups antiguos (30 días)
find $BACKUP_DIR -type f -mtime +30 -delete
```

### 3. Configurar Monitoreo

```bash
# Instalar Monit
sudo apt install -y monit

# Configurar Monit
sudo nano /etc/monit/conf.d/invohero
```

```conf
check process invohero with pidfile /var/run/invohero.pid
    start program = "/etc/init.d/nginx start"
    stop program = "/etc/init.d/nginx stop"
    if failed host invohero.com port 80 protocol http then restart
    if 5 restarts within 5 cycles then timeout
```

## Actualización de la Aplicación

### 1. Procedimiento de Actualización

```bash
# Entrar al directorio
cd /var/www/invohero

# Hacer backup
/usr/local/bin/backup-invohero.sh

# Obtener últimos cambios
git pull origin main

# Instalar dependencias
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Actualizar base de datos
php artisan migrate

# Limpiar caché
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Reiniciar servicios
sudo supervisorctl restart invohero-worker:*
sudo service nginx reload
```

### 2. Rollback

```bash
# Restaurar backup
tar -xzf /var/backups/invohero/files_YYYYMMDD_HHMMSS.tar.gz -C /var/www/invohero
mysql -u$DB_USER -p$DB_PASS $DB_NAME < /var/backups/invohero/db_YYYYMMDD_HHMMSS.sql

# Reiniciar servicios
sudo supervisorctl restart invohero-worker:*
sudo service nginx reload
```

## Solución de Problemas

### 1. Verificar Logs

```bash
# Logs de Nginx
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/log/nginx/access.log

# Logs de PHP
sudo tail -f /var/log/php8.1-fpm.log

# Logs de la aplicación
tail -f /var/www/invohero/storage/logs/laravel.log
```

### 2. Verificar Permisos

```bash
# Establecer permisos correctos
sudo chown -R www-data:www-data /var/www/invohero
sudo chmod -R 755 /var/www/invohero
sudo chmod -R 775 /var/www/invohero/storage
sudo chmod -R 775 /var/www/invohero/bootstrap/cache
```

### 3. Verificar Servicios

```bash
# Estado de servicios
sudo systemctl status nginx
sudo systemctl status php8.1-fpm
sudo systemctl status mysql
sudo supervisorctl status
```

## Escalado

### 1. Configuración de Balanceador de Carga

```nginx
upstream invohero {
    least_conn;
    server 192.168.1.10:80;
    server 192.168.1.11:80;
    server 192.168.1.12:80;
}

server {
    listen 80;
    server_name invohero.com;

    location / {
        proxy_pass http://invohero;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

### 2. Configuración de Redis para Caché

```php
// config/cache.php
'redis' => [
    'client' => env('REDIS_CLIENT', 'phpredis'),
    'default' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_DB', '0'),
    ],
]
```

### 3. Configuración de CDN

```php
// config/filesystems.php
'disks' => [
    'public' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'url' => env('AWS_URL'),
        'endpoint' => env('AWS_ENDPOINT'),
        'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    ],
]
``` 