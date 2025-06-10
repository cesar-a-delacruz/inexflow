<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<form action="">
    <div class="field">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="<?= $user->name?>">
    </div>
    <div class="field">
        <label for="email">Correo:</label>
        <input type="email" id="email" name="email" value="<?= $user->email?>">
    </div>
    <button type="submit">Guardar Cambios</button>
</form>
<?= $this->endSection() ?>