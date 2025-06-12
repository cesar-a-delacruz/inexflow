<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<form action="/user/<?= $user->id ?>" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="user_id" value="<?= $user->id ?>">
    
    <div class="field">
        <label for="name" class="form-label">Nombre:</label>
        <input type="text" id="name" name="name" value="<?= $user->name?>" class="form-control" disabled >
    </div>
    <div class="field">
        <label for="email" class="form-label">Correo:</label>
        <input type="email" id="email" name="email" value="<?= $user->email?>" class="form-control" disabled >
    </div>
    <div class="field">
        <label for="business" class="form-label">Negocio:</label>
        <input type="text" id="business" name="business" value="<?= $user->business ?>" class="form-control" disabled >
    </div>
</form>

<button class="edit btn btn-primary" onclick="activateInputs()" >Editar Perfil</button>

<?php if ($user->business == 'NULO'): ?>
    <a href="/user/<?= $user->id ?>/business/new" class="btn btn-secondary">Crear Negocio</a>
<?php else: ?>
    <a href="/user/<?= $user->id ?>/business" class="btn btn-secondary">Ver Negocio</a>
<?php endif; ?>

<script>
    function activateInputs() {
        const inputs = document.querySelectorAll('div.field > input');
        for (let i = 0; i < inputs.length - 1; i++) {
            inputs[i].disabled = false; 
        }

        const butSubmit = document.createElement('button');
        butSubmit.type = 'submit';
        butSubmit.className = 'btn btn-primary';
        butSubmit.innerHTML = 'Guardar Cambios';
        document.querySelector('form').append(butSubmit);
        document.querySelector('button.edit').remove();
    }
</script>
<?= $this->endSection() ?>