<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<form action="/user" method="POST" novalidate>
    <?php if (!empty(validation_errors())): ?>
        <div class="alert alert-danger"><?= validation_list_errors() ?></div>
    <?php endif; ?>

    <div class="field">
        <label for="name" class="form-label">Nombre:</label>
        <input type="text" id="name" name="name" class="form-control"
        value="<?= !validation_show_error('name') ? set_value('name') : null ?>">
    </div>
    <div class="field">
        <label for="phone" class="form-label">Número de Teléfono:</label>
        <input type="tel" id="phone" name="phone" class="form-control" placeholder="66666666"
        value="<?= !validation_show_error('phone') ? set_value('phone') : null ?>">
    </div>
    <button type="submit" class="btn btn-primary">Registrar</button>
</form>
<?= $this->endSection() ?>