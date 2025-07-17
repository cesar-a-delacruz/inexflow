<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="container">
    <h1>📊 Dashboard de Prueba</h1>

    <section>
        <h2>Ingresos vs Gastos por Categoría</h2>
        <div class="flex flex-row ">
            <div class="basis-1/3">
                <canvas id="categoryChart"></canvas>
            </div>
            <div class="basis-2/3">
                <hgroup>
                    <p><strong>Periodo</strong>: <?= $results[0]['period'] ?></p>
                    <p><strong>Total de ingresos</strong>: <?= $results[0]['totals']['total_incomes'] ?>$</p>
                    <p><strong>Total de Egresos</strong>: <?= $results[0]['totals']['total_expenses'] ?>$</p>
                    <p><strong>ingresos - egresos</strong>: <?= $results[0]['totals']['net_profit'] ?>$</p>
                    <p><strong>Margen (%)</strong>: <?= $results[0]['totals']['profit_margin'] ?></p>
                </hgroup>
                <details class="**:w-full">
                    <summary>mostrar output</summary>
                    <code class="">
                        <pre>
                        <?= print_r($results[0]) ?>
                    </pre>
                    </code>
                </details>
            </div>
        </div>
    </section>

    <section>
        <h2>Flujo de Caja Anual</h2>
        <div class="flex flex-row ">
            <div class="basis-1/2">
                <canvas id="cashFlowChart"></canvas>
            </div>
            <div class="basis-1/2">
                <hgroup>
                    <p><strong>Tipo de Periodo</strong>: <?= $results[1]['period_type'] ?></p>
                    <p><strong>Periodo</strong>: <?= $results[1]['period'] ?></p>
                    <p><strong>Balance inicial</strong>: <?= $results[1]['initial_balance'] ?>$</p>
                    <p><strong>balance final</strong>: <?= $results[1]['final_balance'] ?>$</p>
                    <p><strong>periodos totales</strong>: <?= $results[1]['total_periods'] ?></p>
                </hgroup>
                <details class="**:w-full">
                    <summary>mostrar output</summary>
                    <code class="">
                        <pre>
                        <?= print_r($results[1]) ?>
                    </pre>
                    </code>
                </details>
            </div>
        </div>
    </section>

    <section>
        <h2>Ingresos y Gastos Mensuales</h2>
        <div class="flex flex-row ">
            <div class="basis-1/2">
                <canvas id="monthlyChart"></canvas>
            </div>
            <div class="basis-1/2">
                <hgroup>
                    <p><strong>Promedio mensual de ingresos</strong>: <?= $results[3]['averages']['monthly_income'] ?>$</p>
                    <p><strong>Promedio mensual de gastos</strong>: <?= $results[3]['averages']['monthly_expenses'] ?>$</p>
                    <p><strong>Promedio de transacciones por mes</strong>: <?= $results[3]['averages']['monthly_records'] ?></p>
                    <p><strong>promedio diario, basado en días activos de ingresos</strong>: <?= $results[3]['averages']['daily_income'] ?>$</p>
                    <p><strong>promedio diario, basado en días activos de egresos</strong>: <?= $results[3]['averages']['daily_expenses'] ?>$</p>
                </hgroup>

                <hgroup>
                    <h4>tasa de cecimiento</h4>
                    <p><strong>Variacion de ingresos</strong>: <?= $results[3]['growth']['income_growth'] ?>%</p>
                    <p><strong>Variacion de gastos</strong>: <?= $results[3]['growth']['expense_growth'] ?>%</p>
                    <p><strong>Utilidad neta</strong>: <?= $results[3]['growth']['profit_growth'] ?>%</p>
                </hgroup>
                <details class="**:w-full">
                    <summary>mostrar output</summary>
                    <code class="">
                        <pre>
                        <?= print_r($results[3]) ?>
                    </pre>
                    </code>
                </details>
            </div>
        </div>
    </section>
    <script>
        // =============================
        // 1️⃣ Ingresos vs Gastos por Categoría
        // =============================
        const categoryData = <?php echo json_encode($results[2]['categories']); ?>;

        const categoryLabels = categoryData.map(c => c.category);
        const categoryAmounts = categoryData.map(c => c.amount);
        const categoryColors = categoryData.map(c => c.type === 'income' ? 'rgba(54, 162, 235, 0.7)' : 'rgba(255, 99, 132, 0.7)');

        new Chart(
            document.getElementById('categoryChart'), {
                type: 'pie',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        label: 'Monto',
                        data: categoryAmounts,
                        backgroundColor: categoryColors
                    }]
                }
            }
        );

        // =============================
        // 2️⃣ Flujo de Caja Anual
        // =============================
        const cashFlowData = <?php echo json_encode($results[1]['cash_flow']); ?>;

        const years = cashFlowData.map(p => p.period);
        const incomes = cashFlowData.map(p => p.incomes);
        const expenses = cashFlowData.map(p => p.expenses);
        const netFlow = cashFlowData.map(p => p.net_flow);

        new Chart(
            document.getElementById('cashFlowChart'), {
                type: 'line',
                data: {
                    labels: years,
                    datasets: [{
                            label: 'Ingresos',
                            data: incomes,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: false
                        },
                        {
                            label: 'Gastos',
                            data: expenses,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: false
                        },
                        {
                            label: 'Flujo Neto',
                            data: netFlow,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    stacked: false
                }
            }
        );

        // =============================
        // 3️⃣ Ingresos y Gastos Mensuales
        // =============================
        const monthlyData = <?php echo json_encode($results[3]['monthly_data']); ?>;

        const months = monthlyData.map(m => m.month);
        const monthlyIncomes = monthlyData.map(m => m.incomes);
        const monthlyExpenses = monthlyData.map(m => m.expenses);

        new Chart(
            document.getElementById('monthlyChart'), {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                            label: 'Ingresos',
                            data: monthlyIncomes,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)'
                        },
                        {
                            label: 'Gastos',
                            data: monthlyExpenses,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );
    </script>

    <div style="height: 100dvh;"></div>
    <div><canvas id='myChart'></canvas></div>
    <div><canvas id='myChart2'></canvas></div>

    <?php for ($i = 0; $i < count($results); $i++): ?>
        <code style="width: 100%;">
            <pre style="width: 100%;">
                <?= print_r($results[$i]) ?>
            </pre>
        </code>
        <hr>
    <?php endfor; ?>
    <script>
        const ctx = document.getElementById('myChart');
        const ctx2 = document.getElementById('myChart2');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes 1',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1
                }, {
                    label: '# of Votes 2',
                    data: [2, 9, 13, 15, 12, 13],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(ctx2, {
            type: 'line',
            data: {
                datasets: [{
                    data: [{
                        x: '2016-12-25',
                        y: 20
                    }, {
                        x: "2655441",
                        y: 5
                    }, {
                        x: '2016-12-26',
                        y: 10
                    }]
                }]
            }
        })
    </script>


</body>

</html>