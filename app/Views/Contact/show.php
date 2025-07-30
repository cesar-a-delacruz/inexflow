<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="card shadow-sm border-0 mx-auto" style="width: 600px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detalles del Contacto</h4>
        </div>
        <div class="card-body">
            <?php if (!empty(validation_errors())): ?>
                <div class="alert alert-danger"><?= validation_list_errors() ?></div>
            <?php endif; ?>

            <form action="/contacts/<?= $contact->id ?>" method="POST" novalidate>
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre:</label>
                    <input type="text" id="name" name="name" value="<?= $contact->name ?>" class="form-control" disabled>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" value="<?= $contact->email ?>" class="form-control" disabled>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono:</label>
                    <input type="tel" id="phone" name="phone" value="<?= $contact->phone ?>" class="form-control" disabled>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Dirección:</label>
                    <input type="text" id="address" name="address" value="<?= $contact->address ?>" class="form-control" disabled>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Tipo</label>
                    <div class="mb-3 form-check">
                        <input type="radio" name="type"  class="form-check-input" value="customer" <?= $contact->type === 'customer' ? 'checked' : '' ?> disabled>
                        <label class="form-check-label">Cliente</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="radio" name="type" class="form-check-input" value="provider" <?= $contact->type === 'provider' ? 'checked' : '' ?> disabled>
                        <label class="form-check-label">Proveedor</label>
                    </div>
                </div>
                
                <div class="field buttons"></div>
            </form>
            <button class="edit btn btn-primary mt-3" onclick="activateInputs(`form div.mb-3 input:not(input[type='radio']), form div.mb-3 select`)">
                Editar
            </button>
        </div>
    </div>
</div>
<script src="/assets/js/inputs-activation.js"></script>
<?= $this->endSection() ?>