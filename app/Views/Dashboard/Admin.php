<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Card contenedora -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0">Panel de Administración</h2>
                        <span class="badge bg-light text-primary fs-6">Admin</span>
                    </div>
                </div>
                
                <div class="card-body">
                    
                    <div class="text-center mb-5">
                        <h3 class="fw-bold">Bienvenido, <?= esc($userName) ?></h3>
                        <p class="text-muted">Gestiona todos los aspectos de tu aplicación desde este panel</p>
                    </div>
                    
                    <!-- Botones de acción -->
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-3">
                            <a href="/admin/users" class="btn btn-primary w-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-people-fill fs-2 mb-2"></i>
                                Gestionar Usuarios
                            </a>
                        </div>
                        
                        <div class="col-md-6 col-lg-3">
                            <a href="/admin/reports" class="btn btn-success w-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-graph-up fs-2 mb-2"></i>
                                Ver Reportes
                            </a>
                        </div>
                        
                        <div class="col-md-6 col-lg-3">
                            <a href="/admin/settings" class="btn btn-warning w-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-gear-fill fs-2 mb-2"></i>
                                Configuración
                            </a>
                        </div>
                        
                        <div class="col-md-6 col-lg-3">
                            <a href="/logout" class="btn btn-danger w-100 py-3 d-flex flex-column align-items-center">
                                <i class="bi bi-box-arrow-right fs-2 mb-2"></i>
                                Cerrar Sesión
                            </a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>