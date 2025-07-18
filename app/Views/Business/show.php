<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<form action="/business" method="POST" novalidate>
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="id" value="<?= $business->id ?>">
    <?php if (!empty(validation_errors())): ?>
        <div class="alert alert-danger"><?= validation_list_errors() ?></div>
    <?php endif; ?>
    
    <div class="mb-3">
        <label for="name" class="form-label">Nombre del Negocio:</label>
        <input type="text" id="name" name="name" value="<?= $business->name ?>" class="form-control" disabled>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Número de Teléfono:</label>
        <input type="tel" id="phone" name="phone" value="<?= $business->phone ?>" 
        class="form-control" placeholder="66666666" disabled>
    </div>
    <div class="field buttons"></div>
</form>

<button class="edit btn btn-primary" onclick="activateInputs('form div.mb-3 input')" >Editar</button>
<script src="/assets/js/inputs-activation.js"></script>
<?= $this->endSection() ?>