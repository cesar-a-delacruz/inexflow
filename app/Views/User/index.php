<?= $this->extend('layouts/default') ?>
<?= $this->section('title') ?>Perfil del Usuario<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="top">
    <h1>Perfil del Usuario</h1>
    <button>Editar Perfil</button>
</div>
<div class="card">
    <div class="field">
        <p class="key">Nombre</p>
        <p class="value"></p>
    </div>
    <div class="field">
        <p class="key">Correo</p>
        <p class="value"></p>
    </div>
    <div class="field">
        <p class="key">Estado</p>
        <p class="value"></p>
    </div>
    <div class="field">
        <p class="key">Rol</p>
        <p class="value"></p>
    </div>
</div>
<?= $this->endSection() ?>