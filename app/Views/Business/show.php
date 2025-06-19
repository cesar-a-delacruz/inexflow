<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<form action="/user/business" method="POST" novalidate>
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="business_id" value="<?= $business->id ?>">
    <?php if (!empty(validation_errors())): ?>
        <div class="alert alert-danger"><?= validation_list_errors() ?></div>
    <?php endif; ?>
    
    <div class="field">
        <label for="business_name" class="form-label">Nombre del Negocio:</label>
        <input type="text" id="business_name" name="business_name" value="<?= $business->business_name ?>" class="form-control" disabled>
    </div>
    <div class="field">
        <label for="owner_name" class="form-label">Nombre del Dueño:</label>
        <input type="text" id="owner_name" name="owner_name" value="<?= $business->owner_name ?>" class="form-control" disabled>
    </div>
    <div class="field">
        <label for="owner_email" class="form-label">Correo del Dueño:</label>
        <input type="email" id="owner_email" name="owner_email" value="<?= $business->owner_email ?>" class="form-control" disabled>
    </div>
    <div class="field">
        <label for="owner_phone" class="form-label">Número del Dueño:</label>
        <input type="tel" id="owner_phone" name="owner_phone" value="<?= $business->owner_phone ?>" 
        class="form-control" placeholder="66666666" disabled>
    </div>
    <div class="field buttons"></div>
</form>

<button class="edit btn btn-primary" onclick="activateInputs()" >Editar Datos</button>
<script>
    function activateInputs() {
        const inputs = document.querySelectorAll('div.field > input');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].placeholder = inputs[i].value; 
            inputs[i].value = ''; 
            inputs[i].disabled = false; 
        }

        const butSubmit = document.createElement('button');
        butSubmit.type = 'submit';
        butSubmit.className = 'btn btn-primary';
        butSubmit.innerHTML = 'Guardar Cambios';
        const butReload = document.createElement('button');
        butReload.className = 'btn btn-secondary';
        butReload.innerHTML = 'Cancelar';
        butReload.onclick = function(e) { 
            e.preventDefault();
            window.location.reload();
        }
        document.querySelector('form div.buttons').append(butSubmit, butReload);
        document.querySelector('button.edit').remove();
    }
</script>
<?= $this->endSection() ?>