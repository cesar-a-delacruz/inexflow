# metodo getIncomeStatement()

## Output

# metodo getCashFlow()

```php
        print_r($model->getIncomeStatement("9311744c-3746-3502-84c9-d06e8b5ea2d6"));

Array
(
    [period] => Todos los registros
    [incomes] => Array
        (
            [0] => Array
                (
                    [category] => Ventas
                    [amount] => 270
                    [count] => 3
                )

        )

    [expenses] => Array
        (
            [0] => Array
                (
                    [category] => Costo de Fabricación
                    [amount] => 105.5
                    [count] => 2
                )

            [1] => Array
                (
                    [category] => Gastos
                    [amount] => 130
                    [count] => 2
                )

            [2] => Array
                (
                    [category] => Gastos Operativos
                    [amount] => 140
                    [count] => 1
                )

        )

    [totals] => Array
        (
            [total_incomes] => 270
            [total_expenses] => 375.5
            [net_profit] => -105.5
            [profit_margin] => -39.074074074074
        )

)
```

## OutPut

```php
        print_r($model->getCashFlow("9311744c-3746-3502-84c9-d06e8b5ea2d6", ["group_by" => "day"]));
Array
(
    [period_type] => day
    [initial_balance] => 0
    [final_balance] => -85.5
    [total_periods] => 3
    [cash_flow] => Array
        (
            [0] => Array
                (
                    [period] => 2023-11-09
                    [incomes] => 0
                    [expenses] => 85.5
                    [net_flow] => -85.5
                    [running_balance] => -85.5
                    [record_count] => 1
                )

            [1] => Array
                (
                    [period] => 2024-12-31
                    [incomes] => 140
                    [expenses] => 140
                    [net_flow] => 0
                    [running_balance] => -85.5
                    [record_count] => 2
                )

            [2] => Array
                (
                    [period] => 2025-02-28
                    [incomes] => 120
                    [expenses] => 120
                    [net_flow] => 0
                    [running_balance] => -85.5
                    [record_count] => 2
                )

        )

)
```

## 📌 **¿Qué es un flujo de caja? (Cash Flow)**

Un **flujo de caja** es un **reporte financiero** que muestra **cómo entra y sale dinero** de un negocio en un período de tiempo.
Te ayuda a responder preguntas como:

* **¿Cuánto dinero ingresó?** (*How much money came in?*)
* **¿Cuánto se gastó?** (*How much money went out?*)
* **¿Cuál es el saldo final?** (*What’s the final balance?*)

---

## 📌 **Partes del arreglo que muestras**

Voy a desglosar cada **clave** del `Array`:

---

### 🔹 **\[period\_type] => day**

* **Significa:** el flujo está **agrupado por día** (`group_by = 'day'`).
* Si cambiaras `group_by` a `'week'` o `'month'`, los períodos serían semanas o meses.

**👉 Término:** `period_type` → tipo de período de agrupación.

---

### 🔹 **\[initial\_balance] => 0**

* Es el **saldo inicial** (*initial balance*).
* Es decir, con cuánto dinero empezó el flujo de caja.
* En tu caso: `0`.

---

### 🔹 **\[final\_balance] => -85.5**

* Es el **saldo final** (*final balance*), después de **sumar todos los ingresos y restar todos los gastos**.
* Aquí es `-85.5` → significa que tu negocio terminó con un saldo **negativo**, es decir, **deuda o pérdida acumulada**.

---

### 🔹 **\[total\_periods] => 3**

* Son la **cantidad de períodos distintos** que hay en este flujo.
* Como `period_type = day`, tienes 3 días con movimiento.

---

## 📌 **\[cash\_flow] => Array**

Este es el **detalle por período**. Cada ítem es un **bloque de un día**.

---

### Veamos cada uno 👇

---

## 🔹 **Ejemplo período 1**

```php
[0] => Array
(
    [period] => 2023-11-09
    [incomes] => 0
    [expenses] => 85.5
    [net_flow] => -85.5
    [running_balance] => -85.5
    [record_count] => 1
)
```

| Clave                  | Explicación                                                                      |
| ---------------------- | -------------------------------------------------------------------------------- |
| **period**             | Día específico (`2023-11-09`).                                                   |
| **incomes**            | Total de ingresos (**\$0**) ese día.                                             |
| **expenses**           | Total de gastos (**\$85.5**) ese día.                                            |
| **net\_flow**          | Flujo neto (**incomes - expenses**) = **0 - 85.5 = -85.5**.                      |
| **running\_balance**   | Saldo acumulado hasta ese momento = saldo anterior (`0`) + `net_flow` → `-85.5`. |
| **record\_count** | Cantidad de registros ese día = `1`.                                         |

---

## 🔹 **Ejemplo período 2**

```php
[1] => Array
(
    [period] => 2024-12-31
    [incomes] => 140
    [expenses] => 140
    [net_flow] => 0
    [running_balance] => -85.5
    [record_count] => 2
)
```

| Clave                  | Explicación                                                     |
| ---------------------- | --------------------------------------------------------------- |
| **period**             | `2024-12-31`                                                    |
| **incomes**            | \$140 ingresaron.                                               |
| **expenses**           | \$140 se gastaron.                                              |
| **net\_flow**          | 140 - 140 = 0                                                   |
| **running\_balance**   | Sigue igual porque `net_flow` = 0 → acumulado sigue en `-85.5`. |
| **record\_count** | 2 registros ese día.                                        |

---

## 🔹 **Ejemplo período 3**

```php
[2] => Array
(
    [period] => 2025-02-28
    [incomes] => 120
    [expenses] => 120
    [net_flow] => 0
    [running_balance] => -85.5
    [record_count] => 2
)
```

| Clave                  | Explicación            |
| ---------------------- | ---------------------- |
| **period**             | `2025-02-28`           |
| **incomes**            | \$120 ingresaron.      |
| **expenses**           | \$120 se gastaron.     |
| **net\_flow**          | 120 - 120 = 0          |
| **running\_balance**   | Sigue igual → `-85.5`. |
| **record\_count** | 2 registros.       |

---

## 📌 **¿Cómo se calcula `running_balance`?**

🔑 **Running balance** significa:

* *Saldo acumulado* (también se llama **cumulative balance**).
* Se calcula sumando cada `net_flow` al saldo acumulado anterior.

Ejemplo:

```
initial_balance = 0
period 1: net_flow = -85.5 → running_balance = 0 + (-85.5) = -85.5
period 2: net_flow = 0 → running_balance = -85.5 + 0 = -85.5
period 3: net_flow = 0 → running_balance = -85.5 + 0 = -85.5
```

---

## 📌 **¿Qué hace el método `getCashFlow`?**

**Función clave:**

* **Agrupa registros** por fecha (`day`, `week`, `month`).
* **Suma ingresos y gastos** por período.
* **Cuenta cuántas registros hay.**
* **Calcula:** flujo neto y saldo acumulado (`running_balance`).

# metodo getBusinessMetrics()

## output

```php
        print_r($model->getBusinessMetrics("9311744c-3746-3502-84c9-d06e8b5ea2d6"));
Array
(
    [monthly_data] => Array
        (
            [0] => Array
                (
                    [month] => 2023-11
                    [incomes] => 0
                    [expenses] => 85.5
                    [records] => 1
                    [active_days] => 1
                )

            [1] => Array
                (
                    [month] => 2024-12
                    [incomes] => 0
                    [expenses] => 140
                    [records] => 1
                    [active_days] => 1
                )

            [2] => Array
                (
                    [month] => 2025-02
                    [incomes] => 120
                    [expenses] => 0
                    [records] => 1
                    [active_days] => 1
                )

            [3] => Array
                (
                    [month] => 2025-07
                    [incomes] => 10
                    [expenses] => 20
                    [records] => 2
                    [active_days] => 1
                )

        )

    [averages] => Array
        (
            [monthly_income] => 32.5
            [monthly_expenses] => 61.375
            [monthly_records] => 1.25
            [daily_income] => 32.5
            [daily_expenses] => 61.375
        )

    [growth] => Array
        (
            [income_growth] => 0
            [expense_growth] => -76.608187134503
            [profit_growth] => 0
        )

)

```

## 📌 **¿Qué es `getBusinessMetrics`?**

Este método construye **Métricas de rendimiento** (*Performance Metrics*) del negocio, agrupadas **por mes**.

Sirve para responder:

* ¿Cuánto ingreso (*income*) y gasto (*expense*) hay cada mes?
* ¿Cuántas registros ocurren cada mes?
* ¿En cuántos días del mes hubo actividad?
* ¿Cuál es el **promedio mensual**?
* ¿Cuál es la **tendencia de crecimiento** (*growth rate*)?

---

## 📌 **1️⃣ Consulta principal (Query)**

```php
$builder->select('
    categories.type,
    DATE_FORMAT(records.record_date, "%Y-%m") as month,
    SUM(records.amount) as total_amount,
    COUNT(records.id) as record_count,
    COUNT(DISTINCT DATE(records.record_date)) as active_days
')
->join(
    'categories',
    'categories.business_id = records.business_id 
     AND categories.category_number = records.category_number'
)
->groupBy('categories.type, month')
->orderBy('month', 'ASC');
```

**¿Qué hace?**

* **`categories.type`** → Distingue si es `income` o `expense`.
* **`DATE_FORMAT(..., "%Y-%m")`** → Agrupa por mes (`YYYY-MM`).
* **`SUM(records.amount)`** → Suma los montos por tipo y mes.
* **`COUNT(records.id)`** → Cuenta cuántas registros hubo.
* **`COUNT(DISTINCT DATE(...))`** → Cuenta cuántos días del mes tuvieron actividad (*active days*).

---

## 📌 **2️⃣ Agrupa y ordena**

* `GROUP BY categories.type, month` → Agrupa cada mes por tipo `income` o `expense`.
* `ORDER BY month ASC` → Ordena cronológicamente.

---

## 📌 **3️⃣ Construcción del array final**

```php
foreach ($results as $row) {
    $month = $row['month'];

    if (!isset($months[$month])) {
        $months[$month] = [
            'month' => $month,
            'incomes' => 0,
            'expenses' => 0,
            'records' => 0,
            'active_days' => 0
        ];
    }

    if ($row['type'] === 'income') {
        $months[$month]['incomes'] = (float) $row['total_amount'];
    } elseif ($row['type'] === 'expense') {
        $months[$month]['expenses'] = (float) $row['total_amount'];
    }

    $months[$month]['records'] += (int) $row['record_count'];
    $months[$month]['active_days'] = max(
        $months[$month]['active_days'],
        (int) $row['active_days']
    );
}
```

**¿Qué hace?**

✅ Agrupa filas por mes.
✅ Para cada mes:

* Guarda ingresos o gastos.
* Suma cuántas registros hubo.
* Guarda cuántos días del mes estuvieron activos (**`active_days`**).

**💡 Clave:** como cada fila tiene `type` (`income` o `expense`), vas separando los totales.

---

## 📌 **4️⃣ Promedios**

```php
$metrics = [
    'monthly_data' => $monthlyData,
    'averages' => [
        'monthly_income' => total_income / meses,
        'monthly_expenses' => total_expenses / meses,
        'monthly_records' => total_registros / meses,
        'daily_income' => total_income / total_días_activos,
        'daily_expenses' => total_expenses / total_días_activos
    ],
    'growth' => $this->calculateGrowthRate($monthlyData)
];
```

✅ **monthly\_income** → Promedio mensual de ingresos.
✅ **monthly\_expenses** → Promedio mensual de gastos.
✅ **monthly\_records** → Promedio de registros por mes.
✅ **daily\_income** y **daily\_expenses** → promedio **diario**, basado en días activos.

---

## 📌 **5️⃣ Growth**

```php
'growth' => $this->calculateGrowthRate($monthlyData)
```

**Growth rate** = tasa de crecimiento 📈

Normalmente compara:

$$
\text{Growth} = \frac{\text{Valor Final} - \text{Valor Inicial}}{\text{Valor Inicial}} \times 100
$$

Por ejemplo:

* Si en el primer mes ingresaste 10, y en el último mes ingresaste 20:

  $$
  \text{Growth} = \frac{20 - 10}{10} \times 100 = 100\%
  $$

En tu `Array`:

```php
[growth] => Array
(
    [income_growth] => 0
    [expense_growth] => -76.60
    [profit_growth] => 0
)
```

👉 **income\_growth = 0** → tus ingresos no crecieron (o se mantuvieron igual).

👉 **expense\_growth = -76%** → tus gastos bajaron un 76%.

👉 **profit\_growth = 0** → utilidad neta estable (o sin datos para calcular).

---

## 📌 **Ejemplo: `monthly_data`**

```php
[0] => Array
(
    [month] => 2023-11
    [incomes] => 0
    [expenses] => 85.5
    [records] => 1
    [active_days] => 1
)
```

| Clave            | Significado                               |
| ---------------- | ----------------------------------------- |
| **month**        | Mes (`2023-11`).                          |
| **incomes**      | Total ingresos del mes.                   |
| **expenses**     | Total gastos del mes.                     |
| **records** | Cantidad de registros.                |
| **active\_days** | Días distintos del mes con registros. |

---

## 📌 **Resumen de términos clave**

| Español                 | Inglés              | Significado                       |
| ----------------------- | ------------------- | --------------------------------- |
| Métricas de rendimiento | Performance Metrics | Indicadores clave del negocio.    |
| Días activos            | Active Days         | Días con actividad.               |
| Crecimiento             | Growth Rate         | Cambio porcentual entre períodos. |
| Promedio mensual        | Monthly Average     | Media por mes.                    |
| Promedio diario         | Daily Average       | Media por día.                    |
| registros               | records             | Operaciones individuales.         |

---

## 📌 **¿Para qué sirve?**

✅ Para hacer **análisis de tendencias**.
✅ Para identificar **temporadas altas o bajas**.
✅ Para calcular **KPIs** (*Key Performance Indicators*).
