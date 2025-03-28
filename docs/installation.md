# Guía de Instalación

## Requisitos Previos

Antes de comenzar la instalación, asegúrate de tener instalado:

- PHP 8.x o superior
- MySQL 8.x o superior
- Composer
- Node.js y npm
- Servidor web (Apache/Nginx)

## Pasos de Instalación

### 1. Clonar el Repositorio

```bash
git clone https://github.com/tu-usuario/invohero.git
cd invohero
```

### 2. Instalar Dependencias de PHP

```bash
composer install
```

### 3. Instalar Dependencias de Node.js

```bash
npm install
```

### 4. Configurar Variables de Entorno

1. Copia el archivo de ejemplo:
```bash
cp .env.example .env
```

2. Edita el archivo `.env` con tus configuraciones:
```env
APP_NAME=InvoHero
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invohero
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Generar Clave de Aplicación

```bash
php artisan key:generate
```

### 6. Configurar la Base de Datos

1. Crea una base de datos MySQL:
```sql
CREATE DATABASE invohero CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Ejecuta las migraciones:
```bash
php artisan migrate
```

3. (Opcional) Carga datos de ejemplo:
```bash
php artisan db:seed
```

### 7. Configurar Permisos

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 8. Compilar Assets

```bash
npm run dev
```

Para producción:
```bash
npm run build
```

### 9. Configurar el Servidor Web

#### Apache

1. Crea un archivo de configuración virtual host:
```apache
<VirtualHost *:80>
    ServerName invohero.local
    DocumentRoot /ruta/a/invohero/public
    
    <Directory /ruta/a/invohero/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/invohero-error.log
    CustomLog ${APACHE_LOG_DIR}/invohero-access.log combined
</VirtualHost>
```

2. Habilita el sitio:
```bash
sudo a2ensite invohero.conf
sudo service apache2 restart
```

#### Nginx

1. Crea un archivo de configuración:
```nginx
server {
    listen 80;
    server_name invohero.local;
    root /ruta/a/invohero/public;
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
}
```

2. Crea un enlace simbólico:
```bash
sudo ln -s /etc/nginx/sites-available/invohero /etc/nginx/sites-enabled/
sudo nginx -t
sudo service nginx restart
```

### 10. Verificar la Instalación

1. Accede a la aplicación en tu navegador:
```
http://invohero.local
```

2. Inicia sesión con las credenciales por defecto:
- Email: admin@example.com
- Contraseña: password

## Solución de Problemas

### Problemas Comunes

1. **Error de permisos**
   - Verifica los permisos de las carpetas storage y bootstrap/cache
   - Asegúrate de que el usuario del servidor web tiene acceso

2. **Error de base de datos**
   - Verifica las credenciales en el archivo .env
   - Asegúrate de que la base de datos existe y es accesible

3. **Error de assets**
   - Ejecuta `npm run dev` o `npm run build`
   - Verifica que todas las dependencias están instaladas

4. **Error de caché**
   - Limpia la caché: `php artisan cache:clear`
   - Limpia la configuración: `php artisan config:clear`

### Logs

Los logs de la aplicación se encuentran en:
- `storage/logs/laravel.log`
- Logs del servidor web (Apache/Nginx)

## Actualización

Para actualizar la aplicación a la última versión:

```bash
git pull origin main
composer install
php artisan migrate
npm install
npm run build
php artisan cache:clear
php artisan config:clear
```

## Desinstalación

Para desinstalar la aplicación:

1. Elimina la base de datos:
```sql
DROP DATABASE invohero;
```

2. Elimina los archivos:
```bash
rm -rf /ruta/a/invohero
```

3. Elimina la configuración del servidor web 