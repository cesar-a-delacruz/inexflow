<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="card shadow-sm border-0 mx-auto" style="width: 600px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detalles del Contacto</h4>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>
            <?php if (isset($validation)): ?>
                <div class="alert alert-danger">
                    <?= $validation->listErrors() ?>
                </div>
            <?php endif; ?>

            <form action="/contacts/<?= esc($contact->id) ?>" method="POST" novalidate>
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" value="<?= esc($contact->id) ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre:</label>
                    <input type="text" id="name" name="name" value="<?= old('name', $contact->name) ?>" class="form-control" disabled>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" value="<?= old('email', $contact->email) ?>" class="form-control" disabled>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono:</label>
                    <input type="tel" id="phone" name="phone" value="<?= old('phone', $contact->phone) ?>" class="form-control" disabled>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Dirección:</label>
                    <input type="text" id="address" name="address" value="<?= old('address', $contact->address) ?>" class="form-control" disabled>
                </div>
                <div class="mb-3">
                    <label for="tax_id" class="form-label">Cédula/RUC:</label>
                    <input type="text" id="tax_id" name="tax_id" value="<?= old('tax_id', $contact->tax_id) ?>" class="form-control" disabled>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" <?= old('is_active', $contact->is_active) ? 'checked' : '' ?> disabled>
                    <label class="form-check-label" for="is_active">Activo</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_provider" id="is_provider" class="form-check-input" value="1" <?= old('is_provider', $contact->is_provider) ? 'checked' : '' ?> disabled>
                    <label class="form-check-label" for="is_provider">Es Proveedor</label>
                </div>
                
                <div class="field buttons"></div>
            </form>
            <button class="edit btn btn-primary mt-3" onclick="activateInputs()">Editar Contacto</button>
        </div>
    </div>
</div>

<script>
    function activateInputs() {
        const inputs = document.querySelectorAll('form div.mb-3 input, form div.mb-3 select');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].disabled = false;
        }

        const butSubmit = document.createElement('button');
        butSubmit.type = 'submit';
        butSubmit.className = 'btn btn-success me-2';
        butSubmit.innerHTML = 'Guardar Cambios';

        const butReload = document.createElement('a'); // Changed to 'a' tag for cancellation
        butReload.className = 'btn btn-secondary';
        butReload.innerHTML = 'Cancelar';
        butReload.href = window.location.href; // Reloads the page to revert changes

        document.querySelector('form div.buttons').append(butSubmit, butReload);
        document.querySelector('button.edit').remove();
    }
</script>
<?= $this->endSection() ?>