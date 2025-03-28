# Documentación de la Base de Datos

## Estructura de la Base de Datos

### Tablas Principales

#### users
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user', 'accountant') NOT NULL DEFAULT 'user',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);
```

#### clients
```sql
CREATE TABLE clients (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NULL,
    address TEXT NULL,
    tax_id VARCHAR(50) NULL,
    notes TEXT NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);
```

#### invoices
```sql
CREATE TABLE invoices (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    number VARCHAR(50) NOT NULL UNIQUE,
    client_id BIGINT UNSIGNED NOT NULL,
    issue_date DATE NOT NULL,
    due_date DATE NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    tax_rate DECIMAL(5,2) NOT NULL,
    tax_amount DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('draft', 'sent', 'paid', 'overdue', 'cancelled') NOT NULL DEFAULT 'draft',
    notes TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);
```

#### invoice_items
```sql
CREATE TABLE invoice_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    invoice_id BIGINT UNSIGNED NOT NULL,
    description VARCHAR(255) NOT NULL,
    quantity DECIMAL(10,2) NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id)
);
```

#### products
```sql
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    sku VARCHAR(50) NULL UNIQUE,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    category_id BIGINT UNSIGNED NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (category_id) REFERENCES product_categories(id)
);
```

#### product_categories
```sql
CREATE TABLE product_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);
```

#### transactions
```sql
CREATE TABLE transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type ENUM('income', 'expense') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description TEXT NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    invoice_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (category_id) REFERENCES transaction_categories(id),
    FOREIGN KEY (invoice_id) REFERENCES invoices(id)
);
```

#### transaction_categories
```sql
CREATE TABLE transaction_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type ENUM('income', 'expense') NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);
```

## Relaciones

### Relaciones de Usuarios
- Un usuario puede crear múltiples facturas
- Un usuario puede gestionar múltiples clientes
- Un usuario puede realizar múltiples transacciones

### Relaciones de Clientes
- Un cliente puede tener múltiples facturas
- Cada factura pertenece a un cliente

### Relaciones de Facturas
- Una factura pertenece a un cliente
- Una factura puede tener múltiples items
- Una factura puede estar asociada a una transacción

### Relaciones de Productos
- Un producto pertenece a una categoría
- Un producto puede aparecer en múltiples items de factura

### Relaciones de Transacciones
- Una transacción pertenece a una categoría
- Una transacción puede estar asociada a una factura

## Índices

### Índices de Búsqueda
```sql
CREATE INDEX idx_clients_name ON clients(name);
CREATE INDEX idx_invoices_number ON invoices(number);
CREATE INDEX idx_products_name ON products(name);
CREATE INDEX idx_transactions_date ON transactions(date);
```

### Índices de Relación
```sql
CREATE INDEX idx_invoices_client ON invoices(client_id);
CREATE INDEX idx_invoice_items_invoice ON invoice_items(invoice_id);
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_transactions_category ON transactions(category_id);
CREATE INDEX idx_transactions_invoice ON transactions(invoice_id);
```

## Triggers

### Actualización de Stock
```sql
DELIMITER //
CREATE TRIGGER after_invoice_item_insert
AFTER INSERT ON invoice_items
FOR EACH ROW
BEGIN
    UPDATE products
    SET stock = stock - NEW.quantity
    WHERE id = NEW.product_id;
END //
DELIMITER ;
```

### Actualización de Estado de Factura
```sql
DELIMITER //
CREATE TRIGGER after_transaction_insert
AFTER INSERT ON transactions
FOR EACH ROW
BEGIN
    IF NEW.invoice_id IS NOT NULL THEN
        UPDATE invoices
        SET status = 'paid'
        WHERE id = NEW.invoice_id;
    END IF;
END //
DELIMITER ;
```

## Procedimientos Almacenados

### Calcular Totales de Factura
```sql
DELIMITER //
CREATE PROCEDURE calculate_invoice_totals(IN invoice_id BIGINT)
BEGIN
    DECLARE subtotal DECIMAL(10,2);
    DECLARE tax_rate DECIMAL(5,2);
    DECLARE tax_amount DECIMAL(10,2);
    DECLARE total DECIMAL(10,2);

    SELECT SUM(amount) INTO subtotal
    FROM invoice_items
    WHERE invoice_id = invoice_id;

    SELECT tax_rate INTO tax_rate
    FROM invoices
    WHERE id = invoice_id;

    SET tax_amount = subtotal * (tax_rate / 100);
    SET total = subtotal + tax_amount;

    UPDATE invoices
    SET subtotal = subtotal,
        tax_amount = tax_amount,
        total = total
    WHERE id = invoice_id;
END //
DELIMITER ;
```

## Mantenimiento

### Tareas de Mantenimiento Recomendadas

1. **Backup Diario**
```sql
mysqldump -u usuario -p invohero > backup_$(date +%Y%m%d).sql
```

2. **Optimización de Tablas**
```sql
OPTIMIZE TABLE invoices, clients, products, transactions;
```

3. **Análisis de Tablas**
```sql
ANALYZE TABLE invoices, clients, products, transactions;
```

### Monitoreo

1. **Verificar Tamaño de Tablas**
```sql
SELECT 
    table_name AS 'Tabla',
    round(((data_length + index_length) / 1024 / 1024), 2) AS 'Tamaño (MB)'
FROM information_schema.TABLES
WHERE table_schema = 'invohero'
ORDER BY (data_length + index_length) DESC;
```

2. **Verificar Índices**
```sql
SELECT 
    table_name,
    index_name,
    column_name
FROM information_schema.STATISTICS
WHERE table_schema = 'invohero'
ORDER BY table_name, index_name;
``` 