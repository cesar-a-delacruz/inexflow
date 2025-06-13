<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<form action="/user/" method="POST">
    <div class="field">
        <label for="name" class="form-label">Nombre:</label>
        <input type="text" id="name" name="name" class="form-control">
    </div>
    <div class="field">
        <label for="email" class="form-label">Correo:</label>
        <input type="email" id="email" name="email" class="form-control">
    </div>
    <div class="field">
        <label for="password" class="form-label">Contraseña:</label>
        <input type="password" id="password" name="password" class="form-control">
    </div>
    <div class="field">
        <label for="role" class="form-label">Rol:</label>
        <select name="role" id="role" class="form-select">
            <option value="businessman" selected>Empresario</option>
            <option value="admin">Administrador</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Registrar</button>
</form>
<?= $this->endSection() ?>