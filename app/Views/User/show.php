<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<form action="/user" method="POST" novalidate>
    <input type="hidden" name="_method" value="PUT">
    <?php if (!empty(validation_errors())): ?>
        <div class="alert alert-danger"><?= validation_list_errors() ?></div>
    <?php endif; ?>
    
    <div class="mb-3">
        <label for="name" class="form-label">Nombre:</label>
        <input type="text" id="name" name="name" value="<?= $user->name ?>" class="form-control" disabled>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Correo:</label>
        <input type="email" id="email" name="email" value="<?= $user->email ?>" class="form-control" disabled>
    </div>
    <div class="field buttons"></div>
</form>

<button class="edit btn btn-primary" onclick="activateInputs('form div.mb-3 input')" >Editar</button>
<script src="/assets/js/inputs-activation.js"></script>
<?= $this->endSection() ?>