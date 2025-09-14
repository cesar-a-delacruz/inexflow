<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
<?php endif; ?>

<form action="/tenants/<?= $segment . '/' . $contact->id ?>" method="POST" class="needs-validation" novalidate>
    <input type="hidden" name="_method" value="PUT">
    <div class="row">
        <div class="col-12 col-md-6">
            <?= view_cell('FormInputCell', [
                'name' => 'name',
                'label' => 'Nombre',
                'placeholder' => "Aguacate",
                'required' => true,
                'default' => $contact->name,
            ]) ?>
            <?= view_cell('FormInputCell', [
                'name' => 'email',
                'type' => 'email',
                'label' => 'Correo electronico',
                'placeholder' => "example@email.com",
                'default' => $contact->email,
            ]) ?>

        </div>
        <div class="col-12 col-md-6">
            <?= view_cell('FormInputCell', [
                'name' => 'phone',
                'type' => 'phone',
                'label' => 'Telefono',
                'placeholder' => "6458-5269",
                'default' => $contact->phone,
            ]) ?>
            <?= view_cell('FormInputCell', [
                'name' => 'address',
                'label' => 'Direccion',
                'placeholder' => "Panama, Bocas del Toro, Finca 6",
                'default' => $contact->address,
            ]) ?>
        </div>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-success mx-auto" style="width: 35%;">Guardar Info</button>
    </div>
</form>
<?= $this->endSection() ?>