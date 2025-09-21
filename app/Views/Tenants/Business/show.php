<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-6">
        <form action="/business" method="POST" class="needs-validation" novalidate>
            <input type="hidden" name="_method" value="PUT">
            <?php if (!empty(validation_errors())): ?>
                <div class="alert alert-danger"><?= validation_list_errors() ?></div>
            <?php endif; ?>
            <?php $nameValid = !!validation_show_error('name') ?>
            <div class="form-floating mb-3">
                <input type="text" class="form-control <?= $nameValid ? 'is-invalid' : null ?>"
                    value="<?= $business->name ?>" disabled require
                    placeholder="Tecnologica" id="name" name="name">
                <label for="name">Nombre del Negocio</label>
                <?php if ($nameValid): ?>
                    <div class="invalid-feedback">
                        <?= validation_show_error('name') ?>
                    </div>
                <?php endif ?>
            </div>
            <?php $phoneValid = !!validation_show_error('phone') ?>
            <div class="form-floating mb-3 ">
                <input type="tel" class="form-control <?= $phoneValid ? 'is-invalid' : null ?>"
                    value="<?= $business->phone ?>" disabled require
                    placeholder="6714-5858" id="phone" name="phone">
                <label for="phone">Número de Teléfono</label>
                <?php if ($phoneValid): ?>
                    <div class="invalid-feedback">
                        <?= validation_show_error('phone') ?>
                    </div>
                <?php endif ?>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="field buttons"></div>
        </form>
    </div>
</div>
<button class="edit btn btn-primary" onclick="activateInputs('form div.mb-3 input')">Editar</button>
<script src="/assets/js/inputs-activation.js"></script>
<?= $this->endSection() ?>