<?= $this->extend('layouts/default')?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <h1 class="mb-4 card-header text-center bg-primary text-white"><?= $title ?></h1>

                <?php if (!empty(validation_errors())): ?>
                    <div class="alert alert-danger"><?= validation_list_errors() ?></div>
                <?php endif; ?>
                
                <div class="card-body">
                    <form action="/password" method="POST" >
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="new_password">
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="confirm_password">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
<?= $this->endSection()?>