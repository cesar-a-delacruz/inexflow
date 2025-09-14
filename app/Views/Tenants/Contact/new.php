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

            <form action="/contacts" method="POST" class="needs-validation" novalidate>
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
                <?php $emailValid = !!validation_show_error('email') ?>
                <div class="form-floating mb-3 ">
                    <input type="email" class="form-control <?= $emailValid ? 'is-invalid' : null ?>"
                        value="<?= !$nameValid ? set_value('name') : null ?>"
                        placeholder="example@email.com" id="email" name="email">
                    <label for="email">Correo Electronico</label>
                    <?php if ($emailValid): ?>
                        <div class="invalid-feedback">
                            <?= validation_show_error('email') ?>
                        </div>
                    <?php endif ?>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <?php $phoneValid = !!validation_show_error('phone') ?>
                <div class="form-floating mb-3 ">
                    <input type="tel" class="form-control <?= $phoneValid ? 'is-invalid' : null ?>"
                        value="<?= !$phoneValid ? set_value('phone') : null ?>"
                        placeholder="6714-5858" id="phone" name="phone">
                    <label for="phone">Número de Teléfono</label>
                    <?php if ($phoneValid): ?>
                        <div class="invalid-feedback">
                            <?= validation_show_error('phone') ?>
                        </div>
                    <?php endif ?>
                </div>
                <?php $addressValid = !!validation_show_error('address') ?>
                <div class="form-floating mb-3 ">
                    <input type="text" class="form-control <?= $addressValid ? 'is-invalid' : null ?>"
                        value="<?= !$addressValid ? set_value('address') : null ?>"
                        placeholder="Finca 4, casa verde" id="address" name="address">
                    <label for="address">Dirrección</label>
                    <?php if ($addressValid): ?>
                        <div class="invalid-feedback">
                            <?= validation_show_error('address') ?>
                        </div>
                    <?php endif ?>
                </div>

                <?php $typeValid = !!validation_show_error('type') ?>
                <div class="form-check">
                    <input type="radio" checked class="form-check-input" id="validationFormCheck2" value="customer" name="type" required>
                    <label class="form-check-label" for="validationFormCheck2">Cliente</label>
                </div>
                <div class="form-check mb-3">
                    <input type="radio" class="form-check-input" id="validationFormCheck3" value="provider" name="type" required>
                    <label class="form-check-label" for="validationFormCheck3">Preveedor</label>
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