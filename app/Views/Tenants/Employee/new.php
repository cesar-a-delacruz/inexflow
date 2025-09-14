<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<?php

use App\Enums\ItemType;

if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
<?php endif; ?>

<form action="/tenants/<?= $segment ?>" method="POST" class="needs-validation" novalidate>
    <div class="row">
        <div class="col-12 col-md-6">
            <?= view_cell('FormInputCell', [
                'name' => 'name',
                'label' => 'Nombre',
                'placeholder' => "Aguacate",
                'required' => true,
            ]) ?>
            <?= view_cell('FormInputCell', [
                'name' => 'email',
                'type' => 'email',
                'label' => 'Correo electronico',
                'placeholder' => "example@email.com",
            ]) ?>

        </div>
        <div class="col-12 col-md-6">
            <?= view_cell('FormInputCell', [
                'name' => 'phone',
                'type' => 'phone',
                'label' => 'Telefono',
                'placeholder' => "6458-5269",
            ]) ?>
            <?= view_cell('FormInputCell', [
                'name' => 'address',
                'label' => 'Direccion',
                'placeholder' => "Panama, Bocas del Toro, Finca 6",
            ]) ?>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-success mx-auto" style="width: 35%;">Registrar</button>
        </div>
</form>
<?= $this->endSection() ?>