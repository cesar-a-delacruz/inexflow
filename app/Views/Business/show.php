<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h1><?= $title ?></h1>
<form action="/business" method="POST" novalidate>
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="id" value="<?= $business->id ?>">
    <?php if (!empty(validation_errors())): ?>
        <div class="alert alert-danger"><?= validation_list_errors() ?></div>
    <?php endif; ?>
    
    <div class="field">
        <label for="name" class="form-label">Nombre del Negocio:</label>
        <input type="text" id="name" name="name" value="<?= $business->name ?>" class="form-control" disabled>
    </div>
    <div class="field">
        <label for="phone" class="form-label">Número de Teléfono:</label>
        <input type="tel" id="phone" name="phone" value="<?= $business->phone ?>" 
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