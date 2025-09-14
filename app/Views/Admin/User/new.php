<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<form action="/users/new" method="POST" novalidate>
   <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>
    <?php if (!empty(validation_errors())): ?>
        <div class="alert alert-danger"><?= validation_list_errors() ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <label for="name" class="form-label">Nombre:</label>
        <input type="text" id="name" name="name" class="form-control" 
        value="<?= !validation_show_error('name') ? set_value('name') : null ?>">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Correo:</label>
        <input type="email" id="email" name="email" class="form-control"
        value="<?= !validation_show_error('email') ? set_value('email') : null ?>">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Contraseña:</label>
        <input type="password" id="password" name="password" class="form-control"
        value="<?= !validation_show_error('password') ? set_value('password') : null ?>">
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirme la contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password" class="form-control"
        value="<?= !validation_show_error('confirm_password') ? set_value('confirm_password') : null ?>">
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Rol:</label>
        <select name="role" id="role" class="form-select">
            <option value="businessman" selected>Empresario</option>
            <option value="admin">Administrador</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Registrar</button>
</form>
<?= $this->endSection() ?>