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

<form action="<?= $segment . '/' . $item->id ?>" method="POST" class="needs-validation" novalidate>
    <input type="hidden" name="_method" value="PUT">
    <div class="row">
        <div class="col-12 col-md-6">
            <?= view_cell('FormInputCell', [
                'name' => 'name',
                'label' => 'Nombre',
                'placeholder' => "Aguacate",
                'required' => true,
                'default' => $item->name,
            ]) ?>
            <?= view_cell('FormInputCell', [
                'name' => 'cost',
                'type' => 'number',
                'label' => 'Costo',
                'placeholder' => "0.50",
                'min' => '0.01',
                'step' => '0.01',
                'required' => true,
                'default' => $item->cost,
            ]) ?>
            <?php if ($type === ItemType::Product): ?>
                <?= view_cell('FormInputCell', [
                    'name' => 'selling_price',
                    'type' => 'number',
                    'label' => 'Precio de Venta',
                    'placeholder' => "075",
                    'min' => '0',
                    'step' => '0.01',
                    'default' => $item->selling_price,
                ]) ?>
            <?php endif; ?>
        </div>
        <div class="col-12 col-md-6">
            <?= view_cell('FormInputCell', [
                'name' => 'stock',
                'type' => 'number',
                'label' => 'Cantidad',
                'placeholder' => "20",
                'min' => '1',
                'step' => '1',
                'default' => $item->stock,
            ]) ?>
            <?= view_cell('FormInputCell', [
                'name' => 'min_stock',
                'type' => 'number',
                'label' => 'Cantidad Mínima (para alertar)',
                'placeholder' => "20",
                'min' => '1',
                'step' => '1',
                'default' => $item->min_stock,
            ]) ?>
            <?= view_cell('FormSelectCell', [
                'name' => 'measure_unit_id',
                'label' => 'Unidad de Medida',
                'options' => $measure_units,
                'default' => $item->measure_unit_id,
            ]) ?>
        </div>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-success mx-auto" style="width: 35%;">Guardar Info</button>
    </div>
</form>
<?= $this->endSection() ?>