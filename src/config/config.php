<?php

return [
    'app' => [
        'name' => 'InvoHero',
        'env' => $_ENV['APP_ENV'] ?? 'development',
        'debug' => $_ENV['APP_DEBUG'] ?? true,
        'url' => $_ENV['APP_URL'] ?? 'http://localhost',
        'base_path' => $_ENV['APP_BASE_PATH'] ?? '',
    ],
    'database' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'database' => $_ENV['DB_DATABASE'] ?? 'invohero',
        'username' => $_ENV['DB_USERNAME'] ?? 'root',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
    ],
    'mail' => [
        'host' => $_ENV['MAIL_HOST'] ?? 'smtp.mailtrap.io',
        'port' => $_ENV['MAIL_PORT'] ?? 2525,
        'username' => $_ENV['MAIL_USERNAME'] ?? '',
        'password' => $_ENV['MAIL_PASSWORD'] ?? '',
        'encryption' => $_ENV['MAIL_ENCRYPTION'] ?? 'tls',
        'from_address' => $_ENV['MAIL_FROM_ADDRESS'] ?? 'noreply@invohero.com',
        'from_name' => $_ENV['MAIL_FROM_NAME'] ?? 'InvoHero',
    ],
]; 