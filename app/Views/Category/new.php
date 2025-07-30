<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-5 ">
    <div class="card shadow-sm border-0 mx-auto" style="width: 500px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Nueva Categoría</h4>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <form action="/categories" method="post" class="needs-validation" novalidate>
                <?php $nameValid = !!validation_show_error('name') ?>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control <?= $nameValid ? 'is-invalid' : null ?>" require
                        value="<?= !$nameValid ? set_value('name') : null ?>"
                        id="name" name="name" placeholder="Gastos Operativos">
                    <label for="name">Nombre</label>
                    <?php if ($nameValid): ?>
                        <div class="invalid-feedback">
                            <?= validation_show_error('name') ?>
                        </div>
                    <?php endif ?>
                </div>

                <?php $typeValid = !!validation_show_error('type') ?>
                <div class="form-floating mb-3">
                    <select class="form-select <?= $typeValid ? 'is-invalid' : null ?>" id="type" name="type" aria-label="Tipo de Categoria">
                        <option selected value="income">Ingreso</option>
                        <option value="expense">Gasto</option>
                    </select>
                    <label for="type">Tipo de Categoria</label>
                    <?php if ($typeValid): ?>
                        <div class="invalid-feedback">
                            <?= validation_show_error('type') ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>