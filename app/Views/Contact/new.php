<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="card shadow-sm border-0 mx-auto" style="width: 600px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Crear Nuevo Contacto</h4>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>
            <?php if (isset($validation)): ?>
                <div class="alert alert-danger">
                    <?= $validation->listErrors() ?>
                </div>
            <?php endif; ?>

            <form action="/contacts" method="post" novalidate>
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email') ?>">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono</label>
                    <input type="tel" name="phone" class="form-control" value="<?= old('phone') ?>">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Dirección</label>
                    <input type="text" name="address" class="form-control" value="<?= old('address') ?>">
                </div>
                <div class="mb-3">
                    <label for="tax_id" class="form-label">Cédula/RUC</label>
                    <input type="text" name="tax_id" class="form-control" value="<?= old('tax_id') ?>">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" <?= old('is_active', true) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">Activo</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_provider" id="is_provider" class="form-check-input" value="1" <?= old('is_provider') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_provider">Es Proveedor</label>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Guardar Contacto</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>