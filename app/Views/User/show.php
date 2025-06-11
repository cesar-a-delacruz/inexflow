<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<div class="top">
    <h1><?= $title ?></h1>
    <a href="/user/<?= $user->id ?>/edit" class="btn btn-primary">Editar Perfil</a>
</div>

<form action="/user/<?= $user->id ?>" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="user_id" value="<?= $user->id ?>" disabled>

    <div class="field">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="<?= $user->name?>" disabled>
    </div>
    <div class="field">
        <label for="email">Correo:</label>
        <input type="email" id="email" name="email" value="<?= $user->email?>"disabled>
    </div>
    <div class="field">
        <label for="business">Negocio:</label>
        <input type="text" id="business" name="business" value="<?= $user->business ?>"disabled>
    </div>
    <button type="submit">Guardar Cambios</button>
</form>
<?= $this->endSection() ?>