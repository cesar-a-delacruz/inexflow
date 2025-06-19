<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<form action="/user" method="POST" novalidate>
    <?php if (!empty(validation_errors())): ?>
        <div class="alert alert-danger"><?= validation_list_errors() ?></div>
    <?php endif; ?>

    <div class="field">
        <label for="business_name" class="form-label">Nombre del Negocio:</label>
        <input type="text" id="business_name" name="business_name" class="form-control"
        value="<?= !validation_show_error('business_name') ? set_value('business_name') : null ?>">
    </div>
    <div class="field">
        <label for="owner_name" class="form-label">Nombre del Dueño:</label>
        <input type="text" id="owner_name" name="owner_name" value="<?= $user->name ?>" class="form-control"
        value="<?= !validation_show_error('owner_name') ? set_value('owner_name') : null ?>">
    </div>
    <div class="field">
        <label for="owner_email" class="form-label">Correo del Dueño:</label>
        <input type="email" id="owner_email" name="owner_email" value="<?= $user->email ?>" class="form-control"
        value="<?= !validation_show_error('owner_email') ? set_value('owner_email') : null ?>">
    </div>
    <div class="field">
        <label for="owner_phone" class="form-label">Número del Dueño:</label>
        <input type="tel" id="owner_phone" name="owner_phone" class="form-control" placeholder="66666666"
        value="<?= !validation_show_error('owner_phone') ? set_value('owner_phone') : null ?>">
    </div>
    <button type="submit" class="btn btn-primary">Registrar</button>
</form>
<?= $this->endSection() ?>