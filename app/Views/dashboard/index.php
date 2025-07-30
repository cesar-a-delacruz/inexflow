<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>
<div class="container text-center">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Análisis Completo de Transacciones</h5>
                    <h6 class="card-subtitle"><?= $sales['period_description'] ?> <?= !empty($dateValues[$sales['group_by']]) ? 'Agrupado por ' . $dateValues[$sales['group_by']] : '' ?></h6>
                    <canvas id="sales-total-canvas"></canvas>
                    <canvas id="sales-count-canvas"></canvas>
                </div>
                <div class="card-footer text-body-secondary">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Modificar Parametros
                    </button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <form class="modal-content" action="#" method="GET">
                                <div class="modal-header">
                                    <h5 class="modal-title fs-5" id="exampleModalLabel">Filtrar Transacciones</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="group_by" name="group_by" aria-label="Agrupar por">
                                            <?php foreach ($dateValues as $dateKey => $dateValue): ?>
                                                <option <?= $sales['group_by'] === $dateKey ? "selected" : "" ?> value=<?= esc($dateKey) ?>><?= esc($dateValue) ?></option>
                                            <?php endforeach; ?>
                                        </select>


                                        <label for="group_by">Agrupar por</label>

                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="start_date" value="<?= isset($filters['start_date']) ? esc($filters['start_date']) : '' ?>" name="start_date">
                                        <label for="start_date">Fecha inicio</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="end_date" value="<?= isset($filters['end_date']) ? esc($filters['end_date']) : '' ?>" name=" end_date">
                                        <label for="end_date">Fecha fin</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col col-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Análisis Completo de los Metodos de Pago</h5>
                    <h6 class="card-subtitle"><?= $sales['period_description'] ?> <?= !empty($dateValues[$sales['group_by']]) ? 'Agrupado por ' . $dateValues[$sales['group_by']] : '' ?></h6>
                    <canvas id="payment-method-canvas"></canvas>
                </div>
                <div class="card-footer text-body-secondary">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Modificar Parametros
                    </button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <form class="modal-content" action="#" method="GET">
                                <div class="modal-header">
                                    <h5 class="modal-title fs-5" id="exampleModalLabel">Filtrar Transacciones</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="group_by" name="group_by" aria-label="Agrupar por">
                                            <?php foreach ($dateValues as $dateKey => $dateValue): ?>
                                                <option <?= $sales['group_by'] === $dateKey ? "selected" : "" ?> value=<?= esc($dateKey) ?>><?= esc($dateValue) ?></option>
                                            <?php endforeach; ?>
                                        </select>


                                        <label for="group_by">Agrupar por</label>

                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="start_date" value="<?= isset($filters['start_date']) ? esc($filters['start_date']) : '' ?>" name="start_date">
                                        <label for="start_date">Fecha inicio</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="end_date" value="<?= isset($filters['end_date']) ? esc($filters['end_date']) : '' ?>" name=" end_date">
                                        <label for="end_date">Fecha fin</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Análisis Completo de los Metodos de Pago</h5>
                    <h6 class="card-subtitle"><?= $sales['period_description'] ?> <?= !empty($dateValues[$sales['group_by']]) ? 'Agrupado por ' . $dateValues[$sales['group_by']] : '' ?></h6>
                    <canvas id="payment-status-canvas"></canvas>
                </div>
                <div class="card-footer text-body-secondary">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Modificar Parametros
                    </button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <form class="modal-content" action="#" method="GET">
                                <div class="modal-header">
                                    <h5 class="modal-title fs-5" id="exampleModalLabel">Filtrar Transacciones</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="group_by" name="group_by" aria-label="Agrupar por">
                                            <?php foreach ($dateValues as $dateKey => $dateValue): ?>
                                                <option <?= $sales['group_by'] === $dateKey ? "selected" : "" ?> value=<?= esc($dateKey) ?>><?= esc($dateValue) ?></option>
                                            <?php endforeach; ?>
                                        </select>


                                        <label for="group_by">Agrupar por</label>

                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="start_date" value="<?= isset($filters['start_date']) ? esc($filters['start_date']) : '' ?>" name="start_date">
                                        <label for="start_date">Fecha inicio</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="end_date" value="<?= isset($filters['end_date']) ? esc($filters['end_date']) : '' ?>" name=" end_date">
                                        <label for="end_date">Fecha fin</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col"></div>
        <div class="col"></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctxTotalSales = document.getElementById('sales-total-canvas');
    const ctxCountSales = document.getElementById('sales-count-canvas');
    const salesData = <?php echo json_encode($sales['data']); ?>;
    const salePeriods = salesData.map(item => {
        const date = new Date(item.period);
        return date.toLocaleDateString('es-ES', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
    });
    new Chart(ctxTotalSales, {
        type: 'line',
        data: {
            labels: salePeriods,
            datasets: [{
                type: 'line',
                label: 'Ventas Totales',
                data: salesData.map(e => parseFloat(e.total_sales)),
                borderColor: '#059669',
                backgroundColor: 'rgba(5, 150, 105, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#059669',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Ventas: $' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toFixed(2);
                        }
                    }
                }
            }
        }
    });
    new Chart(ctxCountSales, {
        type: 'bar',
        data: {
            labels: salePeriods,
            datasets: [{
                type: 'bar',
                label: 'Número de Transacciones',
                data: salesData.map(e => e.transactions_count),
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)', // Índigo
                    'rgba(168, 85, 247, 0.8)', // Violeta
                    'rgba(236, 72, 153, 0.8)', // Rosa
                    'rgba(245, 158, 11, 0.8)', // Ámbar
                    'rgba(34, 197, 94, 0.8)', // Verde
                    'rgba(59, 130, 246, 0.8)', // Azul
                    'rgba(239, 68, 68, 0.8)' // Rojo
                ],
                borderColor: [
                    '#6366f1',
                    '#a855f7',
                    '#ec4899',
                    '#f59e0b',
                    '#22c55e',
                    '#3b82f6',
                    '#ef4444'
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
                // Sombra en las barras
                shadowColor: 'rgba(0, 0, 0, 0.1)',
                shadowBlur: 6,
                shadowOffsetX: 0,
                shadowOffsetY: 3,
                // Animación personalizada
                hoverBackgroundColor: [
                    'rgba(99, 102, 241, 0.9)',
                    'rgba(168, 85, 247, 0.9)',
                    'rgba(236, 72, 153, 0.9)',
                    'rgba(245, 158, 11, 0.9)',
                    'rgba(34, 197, 94, 0.9)',
                    'rgba(59, 130, 246, 0.9)',
                    'rgba(239, 68, 68, 0.9)'
                ],
                hoverBorderWidth: 3

            }]
        },
        options: {
            interaction: {
                intersect: false,
                mode: 'index'
            },
        }

    });

    /*-------------------------*/

    const ctxPaymentMethod = document.getElementById('payment-method-canvas');
    const paymentMethodData = <?php echo json_encode($paymentMethodData['data']); ?>;

    new Chart(ctxPaymentMethod, {
        type: 'doughnut',
        data: {
            labels: paymentMethodData.map(item => item.method_label),
            datasets: [{
                label: 'Métodos de Pago',
                data: paymentMethodData.map(item => parseFloat(item.total_amount)),
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)', // Verde - Efectivo
                    'rgba(59, 130, 246, 0.8)', // Azul - Tarjeta
                    'rgba(168, 85, 247, 0.8)' // Violeta - Transferencia
                ],
                borderColor: [
                    '#22c55e',
                    '#3b82f6',
                    '#a855f7'
                ],
                borderWidth: 3,
                hoverBackgroundColor: [
                    'rgba(34, 197, 94, 0.9)',
                    'rgba(59, 130, 246, 0.9)',
                    'rgba(168, 85, 247, 0.9)'
                ],
                hoverBorderWidth: 4,
                hoverOffset: 15,
                // Espaciado entre segmentos
                spacing: 3,
                // Radio interno para efecto dona
                cutout: '60%'
            }]
        },
        options: {
            maintainAspectRatio: true,

            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        color: '#374151',
                        generateLabels: function(chart) {
                            const data = chart.data;
                            return data.labels.map((label, i) => {
                                const dataset = data.datasets[0];
                                const count = paymentMethodData[i].count;
                                const amount = dataset.data[i];
                                const percentage = ((amount / dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(1);

                                return {
                                    text: `${label} (${count} - ${percentage}%)`,
                                    fillStyle: dataset.backgroundColor[i],
                                    strokeStyle: dataset.borderColor[i],
                                    lineWidth: dataset.borderWidth,
                                    pointStyle: 'circle',
                                    hidden: false,
                                    index: i
                                };
                            });
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.95)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#22c55e',
                    borderWidth: 2,
                    cornerRadius: 12,
                    padding: 16,
                    displayColors: true,
                    titleFont: {
                        size: 14,
                        weight: '600'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            const dataIndex = context.dataIndex;
                            const item = paymentMethodData[dataIndex];
                            const percentage = ((context.parsed / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(1);

                            return [
                                `Monto: $${parseFloat(item.total_amount).toLocaleString('es-ES', {minimumFractionDigits: 2})}`,
                                `Transacciones: ${item.count}`,
                                `Porcentaje: ${percentage}%`
                            ];
                        }
                    }
                }
            },
            // Animación personalizada
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000,
                easing: 'easeOutQuart'
            },
            // Interactividad
            onHover: (event, activeElements) => {
                event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
            }
        }
    });

    /*-------------------------*/
    const ctxPaymentStatus = document.getElementById('payment-status-canvas');
    const paymentStatusData = <?php echo json_encode($paymentStatusData['data']); ?>;
    new Chart(ctxPaymentStatus, {
        type: 'doughnut',
        data: {
            labels: paymentStatusData.map(item => item.status_label),
            datasets: [{
                label: 'Estados de Pago',
                data: paymentStatusData.map(item => parseFloat(item.total_amount)),
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)', // Verde - Pagado
                    'rgba(245, 158, 11, 0.8)', // Ámbar - Pendiente
                    'rgba(239, 68, 68, 0.8)', // Rojo - Vencido
                    'rgba(107, 114, 128, 0.8)' // Gris - Cancelado
                ],
                borderColor: [
                    '#22c55e',
                    '#f59e0b',
                    '#ef4444',
                    '#6b7280'
                ],
                borderWidth: 3,
                hoverBackgroundColor: [
                    'rgba(34, 197, 94, 0.9)',
                    'rgba(245, 158, 11, 0.9)',
                    'rgba(239, 68, 68, 0.9)',
                    'rgba(107, 114, 128, 0.9)'
                ],
                hoverBorderWidth: 4,
                hoverOffset: 15,
                spacing: 3,
                cutout: '60%'
            }]
        },
        options: {
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        color: '#374151',
                        generateLabels: function(chart) {
                            const data = chart.data;
                            return data.labels.map((label, i) => {
                                const dataset = data.datasets[0];
                                const count = paymentStatusData[i].count;
                                const amount = dataset.data[i];
                                const percentage = ((amount / dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(1);

                                return {
                                    text: `${label} (${count} - ${percentage}%)`,
                                    fillStyle: dataset.backgroundColor[i],
                                    strokeStyle: dataset.borderColor[i],
                                    lineWidth: dataset.borderWidth,
                                    pointStyle: 'circle',
                                    hidden: false,
                                    index: i
                                };
                            });
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.95)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#22c55e',
                    borderWidth: 2,
                    cornerRadius: 12,
                    padding: 16,
                    displayColors: true,
                    titleFont: {
                        size: 14,
                        weight: '600'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            const dataIndex = context.dataIndex;
                            const item = paymentStatusData[dataIndex];
                            const percentage = ((context.parsed / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(1);

                            return [
                                `Monto: $${parseFloat(item.total_amount).toLocaleString('es-ES', {minimumFractionDigits: 2})}`,
                                `Transacciones: ${item.count}`,
                                `Porcentaje: ${percentage}%`
                            ];
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000,
                easing: 'easeOutQuart'
            },
            onHover: (event, activeElements) => {
                event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
            }
        }
    });
</script>
<?= $this->endSection() ?>