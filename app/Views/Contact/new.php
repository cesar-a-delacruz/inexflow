<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="card shadow-sm border-0 mx-auto" style="width: 600px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Nuevo Contacto</h4>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>
            <?php if (!empty(validation_errors())): ?>
                <div class="alert alert-danger"><?= validation_list_errors() ?></div>
            <?php endif; ?>

            <form action="/contacts" method="POST" novalidate>
                 <div class="mb-3">
                    <label for="name" class="form-label">Nombre:</label>
                    <input type="text" id="name" name="name"  class="form-control">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="text" id="email" name="email"  class="form-control">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono:</label>
                    <input type="tel" id="phone" name="phone" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Dirección:</label>
                    <input type="text" id="address" name="address" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Tipo</label>
                    <div class="mb-3 form-check">
                        <input type="radio" name="type"  class="form-check-input" value="customer">
                        <label class="form-check-label">Cliente</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="radio" name="type" class="form-check-input" value="provider">
                        <label class="form-check-label">Proveedor</label>
                    </div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>