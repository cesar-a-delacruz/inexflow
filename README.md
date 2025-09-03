# INEXflow

Esta es una aplicación web para la administración financiera de negocios en la provincia de Bocas del Toro, Panamá.

## Significado del nombre

- IN = income (ingresos en inglés)
- EX = expense (gastos en inglés)
- flow = cashflow (flujo de caja en inglés)

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

## 1 LOS INGRESOS/GASTOS BÁSICOS

### 1.1 INGRESOS BÁSICOS

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

### 1.2 GASTOS BÁSICOS

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

## 2 REPORTES BÁSICOS

### 2.1 Reporte de Estado de Resultados Simple

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

### 2.2 Reporte de Flujo de Caja Simple

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

### 2.3 Resumen por Categorías

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
