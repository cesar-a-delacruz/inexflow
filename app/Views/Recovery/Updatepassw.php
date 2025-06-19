<?= $this->extend('layouts/default')?>

<?= $this->section('content') ?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
   <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('message') ?>
                </div>
            <?php endif; ?>
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h5>Restablecer Contraseña</h5>
                </div>
                <div class="card-body">
                  
                    <form action="<?= base_url('recovery/reset') ?>" method="post" >
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="new_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="confirm_password" required>
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