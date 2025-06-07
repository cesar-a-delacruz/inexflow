# INEXflow C1
Esta es una aplicación web para la administración financiera de negocios en la provincia de Bocas del Toro, Panamá.

## Significado del nombre

- IN = income (ingresos en inglés)
- EX = expense (gastos en inglés)
- flow = cashflow (flujo de caja en inglés)
- C1 = (número de la provincia)

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