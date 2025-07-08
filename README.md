# INEXflow C1

Esta es una aplicación web para la administración financiera de negocios en la provincia de Bocas del Toro, Panamá.

## Significado del nombre

- IN = income (ingresos en inglés)
- EX = expense (gastos en inglés)
- flow = cashflow (flujo de caja en inglés)
- C1 = (número de la provincia)

## Dependencias

### ramsey/uuid

Biblioteca para generar y manipular Objetos de tipo UUID

```bash
composer require ramsey/uuid
```

## comandos de spark

### Instalar las dependencias

```bash
composer install
```

### Migrar base de datos

```bash
php spark migrate
```

### Crear Modelo

```bash
php spark make:model AppUserModel
```

### Crear una migration

```bash
php spark make:migration CreateTablenombretabla
```

## 1 Tablas

### 1.1 businesses

Tabla principal de negocios (TENANTS)

```sql
CREATE TABLE businesses
(
    id            BINARY(16) PRIMARY KEY                                                            NOT NULL, -- UUID
    business_name VARCHAR(255)                                                                      NOT NULL,
    owner_name    VARCHAR(255)                                                                      NOT NULL,
    owner_email   VARCHAR(255)                                                                      NOT NULL,
    owner_phone   VARCHAR(50)                                                                       NULL,
    status        ENUM ('active', 'inactive') DEFAULT 'active'                                      NOT NULL,
    registered_by BINARY(16)                                                                        NOT NULL, -- UUID
    created_at    DATETIME                    DEFAULT CURRENT_TIMESTAMP                             NOT NULL,
    updated_at    DATETIME                    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    deleted_at    DATETIME                                                                          NULL,
    INDEX idx_status (status),                                                                                -- Busqueda por estatus mas rapida;
    INDEX idx_owner_email (owner_email),                                                                      -- Busqueda por email mas rapida;
    FOREIGN KEY (registered_by) REFERENCES users (id) ON DELETE CASCADE
);
```

### 1.2 users

Usuarios del sistema

```sql
CREATE TABLE users
(
    id            BINARY(16) PRIMARY KEY                                                              NOT NULL, -- UUID
    business_id   BINARY(16)                                                                          NULL,     -- UUID
    name          VARCHAR(255)                                                                        NOT NULL,
    email         VARCHAR(255)                                                                        NOT NULL,
    password_hash CHAR(60)                                                                            NOT NULL, -- bcrypt hash
    role          ENUM ('admin', 'businessman') DEFAULT 'businessman'                                 NOT NULL,
    is_active     BOOLEAN                       DEFAULT TRUE                                          NOT NULL, -- Para desactivar sin eliminar
    created_at    DATETIME                      DEFAULT CURRENT_TIMESTAMP                             NOT NULL,
    updated_at    DATETIME                      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    deleted_at    DATETIME                                                                            NULL
    UNIQUE KEY uk_business_email (business_id, email);
    FOREIGN KEY (business_id) REFERENCES businesses (id) ON DELETE CASCADE;
);
```

### 1.3 categories

Categorías simples por negocio

```sql
CREATE TABLE categories
(
    business_id     BINARY(16)                                                     NOT NULL,
    category_number SMALLINT UNSIGNED                                              NOT NULL,
    name            VARCHAR(255)                                                   NOT NULL,
    type            ENUM ('income', 'expense')                                     NOT NULL,
    is_active       BOOLEAN  DEFAULT TRUE                                          NOT NULL,
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP                             NOT NULL,
    updated_at      DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    deleted_at      DATETIME                                                       NULL,
    PRIMARY KEY (business_id, category_number),
    UNIQUE KEY uk_business_category_name (business_id, name), -- Para evitar duplicar categorio por negocio
    INDEX idx_business_type (business_id, type),              -- Busqueda por tipo mas rapida
    FOREIGN KEY (business_id) REFERENCES businesses (id) ON DELETE CASCADE
);
```

### 1.4 transactions

Tabla unificada para todos los movimientos de dinero

```sql
CREATE TABLE transactions
(
    business_id        BINARY(16)                                                                              NOT NULL,
    transaction_number INT UNSIGNED                                                                            NOT NULL,
    category_number    SMALLINT UNSIGNED                                                                       NOT NULL,
    amount             DECIMAL(10, 2)                                                                          NOT NULL,
    description        VARCHAR(255)                                                                            NOT NULL,
    transaction_date   DATE                                                                                    NOT NULL,
    payment_method     ENUM ('cash', 'card', 'transfer') DEFAULT 'cash'                                        NOT NULL,
    notes              TEXT,
    created_at         DATETIME                          DEFAULT CURRENT_TIMESTAMP                             NOT NULL,
    updated_at         DATETIME                          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    deleted_at         DATETIME                                                                                NULL,
    PRIMARY KEY (business_id, transaction_number),
    INDEX idx_business_date (business_id, transaction_date),    -- Para reportes por fecha
    INDEX idx_business_category (business_id, category_number), -- Para reportes por categoria
    FOREIGN KEY (business_id) REFERENCES businesses (id) ON DELETE CASCADE,
    FOREIGN KEY (business_id, category_number) REFERENCES categories (business_id, category_number) ON DELETE CASCADE
);
```

## 2 LOS INGRESOS/GASTOS BÁSICOS

### 2.1 INGRESOS BÁSICOS

- **Registro simple**: Solo monto, descripción y fecha
- **Sin detalle de productos**: No importa qué se vendió específicamente
- **Sin control de inventario**: Solo el dinero que ingresó
- **Sin clientes**: No se registra quién compró

**Ejemplos de ingresos básicos:**

```text
- Fecha: 2025-06-08
- Descripción: "Ventas del día - tienda"
- Categoría: "Ventas de productos"
- Monto: $125.50
- Método: Efectivo
```

```text
- Fecha: 2025-06-07
- Descripción: "Servicio de plomería - Casa familia Pérez"
- Categoría: "Servicios profesionales"
- Monto: $80.00
- Método: Transferencia
```

### 2.2 GASTOS BÁSICOS

- **Registro simple**: Solo monto, descripción y fecha
- **Categorías básicas**: Compras, servicios, gastos operativos
- **Sin proveedores**: No importa a quién se le pagó específicamente
- **Sin cuentas por pagar**: Todo se registra cuando se paga

**Ejemplos de gastos básicos:**

```text
- Fecha: 2025-06-08
- Descripción: "Compra de mercadería para reventa"
- Categoría: "Compras de productos"
- Monto: $75.00
- Método: Efectivo
```

```text
- Fecha: 2025-06-05
- Descripción: "Pago de luz del local"
- Categoría: "Servicios públicos"
- Monto: $45.00
- Método: Transferencia
```

## 3 REPORTES BÁSICOS

### 3.1 Reporte de Estado de Resultados Simple

**Muestra período seleccionado (día, semana, mes):**

```text
RESUMEN FINANCIERO - JUNIO 2025
=====================================

INGRESOS:
- Ventas de productos:        $1,250.00
- Servicios profesionales:    $  480.00
- Otros ingresos:            $   75.00
                            -----------
TOTAL INGRESOS:              $1,805.00

GASTOS:
- Compras de productos:      $  650.00
- Gastos operativos:         $  180.00
- Servicios públicos:        $  125.00
- Otros gastos:              $   95.00
                            -----------
TOTAL GASTOS:                $1,050.00

=====================================
UTILIDAD NETA:               $  755.00
```

### 3.2 Reporte de Flujo de Caja Simple

**Entradas y salidas de dinero por día:**

```text
FLUJO DE CAJA - ÚLTIMA SEMANA
=============================

Lunes 03/06:
  Ingresos: $120.00
  Gastos:   $ 45.00
  Neto:     $ 75.00

Martes 04/06:
  Ingresos: $180.00
  Gastos:   $ 30.00
  Neto:     $150.00

... (otros días)

SALDO INICIAL:  $500.00
SALDO FINAL:    $755.00
```

### 3.3 Resumen por Categorías

**Análisis simple de gastos por tipo:**

```text
GASTOS POR CATEGORÍA - JUNIO 2025
=================================

Compras de productos:    $650.00 (62%)
Gastos operativos:       $180.00 (17%)
Servicios públicos:      $125.00 (12%)
Otros gastos:            $ 95.00 (9%)
                        -----------
TOTAL:                  $1,050.00
```

# Actualizaciones

## Agregar tablas

```sql
-- Clientes del consumer y providers
contacts 👌
- id (PK)
- business_id (FK → businesses.id)
- is_providers 
- name VARCHAR(255) NOT NULL -- nombre del cliente o nombre del contacto
- email VARCHAR(255)
- phone VARCHAR(50)
- address TEXT
- tax_id VARCHAR(50) -- cédula/RUC del cliente
- is_active BOOLEAN DEFAULT TRUE
- is_provider BOOLEAN DEFAULT FALSE
- created_at TIMESTAMP
- updated_at TIMESTAMP

-- Productos/servicios del negocio
products 👌
- id (PK)
- business_id (FK → businesses.id)
- category_id (FK → categories.id) NULL -- categoría de producto
- name VARCHAR(255) NOT NULL
- description TEXT
- sku VARCHAR(100) -- código del producto
- cost_price DECIMAL(10,2) DEFAULT 0.00 -- precio de costo
- selling_price DECIMAL(10,2) NOT NULL -- precio de venta
- is_service BOOLEAN DEFAULT FALSE -- TRUE si es servicio
- track_inventory BOOLEAN DEFAULT TRUE -- si controla stock
- current_stock INT DEFAULT 0
- min_stock_level INT DEFAULT 0 -- para alertas
- unit_of_measure VARCHAR(20) DEFAULT 'unit' -- unidad, kg, lb, etc.
- is_active BOOLEAN DEFAULT TRUE
- created_at TIMESTAMP
- updated_at TIMESTAMP

-- Movimientos de inventario
inventory_movements 👌
- id (PK)
- business_id (FK → businesses.id)
- product_id (FK → products.id)
- movement_type ENUM('in', 'out', 'adjustment')
- quantity INT NOT NULL
- unit_cost DECIMAL(10,2) -- costo unitario
- reference_type ENUM('sale', 'purchase', 'adjustment')
- reference_id INT -- ID de la factura, compra, etc.
- notes TEXT
- created_by (FK → app_users.id)
- created_at TIMESTAMP

-- Facturas/recibos emitidos
invoices 👌
- id (PK)
- business_id (FK → businesses.id)
- customer_id (FK → customers.id) NULL -- NULL para venta sin cliente
- invoice_number VARCHAR(50) NOT NULL -- correlativo por negocio
- invoice_date DATE NOT NULL
- due_date DATE -- fecha de vencimiento para crédito
- subtotal DECIMAL(10,2) NOT NULL
- tax_amount DECIMAL(10,2) DEFAULT 0.00
- discount_amount DECIMAL(10,2) DEFAULT 0.00
- total_amount DECIMAL(10,2) NOT NULL
- payment_status ENUM('paid', 'pending', 'overdue', 'cancelled') DEFAULT 'paid'
- payment_method ENUM('cash', 'card', 'transfer', 'credit', 'mixed')
- notes TEXT
- created_by (FK → app_users.id)
- created_at TIMESTAMP
- updated_at TIMESTAMP

-- Detalle de productos en facturas
invoice_items 👌
- id (PK)
- business_id (FK → businesses.id)
- invoice_id (FK → invoices.id)
- product_id (FK → products.id)
- quantity DECIMAL(8,2) NOT NULL
- unit_price DECIMAL(10,2) NOT NULL
- line_total DECIMAL(10,2) NOT NULL
- created_at TIMESTAMP

-- Cuentas por cobrar (facturas pendientes de pago)
accounts_receivable 👌
- id (PK)
- business_id (FK → businesses.id)
- contact_id (FK → contacts.id)
- invoice_id (FK → invoices.id)
- original_amount DECIMAL(10,2) NOT NULL
- paid_amount DECIMAL(10,2) DEFAULT 0.00
- balance_due DECIMAL(10,2) NOT NULL
- due_date DATE NOT NULL
- status ENUM('current', 'overdue', 'paid') DEFAULT 'current'
- created_at TIMESTAMP
- updated_at TIMESTAMP

-- Cuentas por pagar (deudas con proveedores)
accounts_payable 👌
- id (PK)
- business_id (FK → businesses.id)
- contact_id (FK → contacts.id)
- transaction_id (FK → transactions.id) NULL -- relación con gasto
- invoice_number VARCHAR(100)
- description VARCHAR(255) NOT NULL
- original_amount DECIMAL(10,2) NOT NULL
- paid_amount DECIMAL(10,2) DEFAULT 0.00
- balance_due DECIMAL(10,2) NOT NULL
- due_date DATE NOT NULL
- status ENUM('pending', 'overdue', 'paid') DEFAULT 'pending'
- created_at TIMESTAMP
- updated_at TIMESTAMP

-- Pagos recibidos de clientes
payment_receipts 👌
- id (PK)
- business_id (FK → businesses.id)
- contact_id (FK → contacts.id)
- account_receivable_id (FK → accounts_receivable.id) NULL
- amount DECIMAL(10,2) NOT NULL
- payment_method ENUM('cash', 'card', 'transfer', 'check')
- payment_date DATE NOT NULL
- reference VARCHAR(100) -- número de cheque, transferencia
- notes TEXT
- created_by (FK → app_users.id)
- created_at TIMESTAMP

-- Pagos realizados a proveedores
payment_vouchers
- id (PK)
- business_id (FK → businesses.id)
- contact_id (FK → contacts.id)
- account_payable_id (FK → accounts_payable.id) NULL
- amount DECIMAL(10,2) NOT NULL
- payment_method ENUM('cash', 'card', 'transfer', 'check')
- payment_date DATE NOT NULL
- reference VARCHAR(100)
- notes TEXT
- created_by (FK → app_users.id)
- created_at TIMESTAMP
```

## Actualizar tablas viejas

```sql
-- Agregar nuevo tipo para productos
ALTER TABLE categories 
MODIFY type ENUM('income', 'expense', 'product');

-- Ejemplos de nuevas categorías:
-- Productos: "Bebidas", "Comida", "Ropa", "Electrónicos"
-- Servicios: "Reparaciones", "Consultorías", "Mantenimiento"
``` 

```sql
-- Agregar relación opcional con facturas
ALTER TABLE transactions 
ADD COLUMN invoice_id (FK → invoices.id) NULL;
-- Para conectar ingresos de Fase 1 con facturas de Fase 2
```