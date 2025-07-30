<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<div class="row">
    <div class="col-6">
        <form action="/user" method="POST" novalidate>
            <input type="hidden" name="_method" value="PUT">
            <?php if (!empty(validation_errors())): ?>
                <div class="alert alert-danger"><?= validation_list_errors() ?></div>
            <?php endif; ?>
            <?php $nameValid = !!validation_show_error('name') ?>
            <div class="form-floating mb-3">
                <input type="text" class="form-control <?= $nameValid ? 'is-invalid' : null ?>"
                    value="<?= $user->name ?>" disabled require
                    placeholder="Geovvany Caballero" id="name" name="name">
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
                    value="<?= $user->email ?>" disabled require
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
            <div class="field buttons"></div>
        </form>
    </div>
</div>

<button class="edit btn btn-primary" onclick="activateInputs('form div.mb-3 input')">Editar</button>
<script src="/assets/js/inputs-activation.js"></script>
<?= $this->endSection() ?>