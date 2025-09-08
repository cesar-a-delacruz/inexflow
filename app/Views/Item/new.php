<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-5 ">
    <div class="card shadow-sm border-0 mx-auto" style="width: 800px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><?= $title ?></h4>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <form action="/items" method="POST" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col">
                        <?= view_cell('FormInputCell', [
                            'name' => 'name',
                            'label' => 'Nombre',
                            'placeholder' => "Aguacate",
                            'required' => true,
                        ]) ?>
                        <?= view_cell('FormSelectCell', [
                            'name' => 'type',
                            'label' => 'Tipo de Elemento',
                            'options' => [
                                'product' => 'Producto',
                                'service' => 'Servicio',
                            ],
                            'default' => 'product',
                            'onchange' => "activateStock(this, event)"
                        ]) ?>
                        <?php
                        $categoriesOp = [];
                        foreach ($categories as $category) {
                            $categoriesOp[$category->id] = $category->displayType() . " | " . $category->name;
                        }
                        ?>
                        <?= view_cell('FormSelectCell', [
                            'name' => 'category_id',
                            'label' => 'Categoria',
                            'options' => $categoriesOp,
                        ]) ?>
                        <?= view_cell('FormInputCell', [
                            'name' => 'cost',
                            'type' => 'number',
                            'label' => 'Costo',
                            'placeholder' => "0.50",
                            'min' => '0.01',
                            'step' => '0.01',
                            'required' => true,
                        ]) ?>

                    </div>
                    <div class="col">
                        <?= view_cell('FormInputCell', [
                            'name' => 'selling_price',
                            'type' => 'number',
                            'label' => 'Precio de Venta',
                            'placeholder' => "075",
                            'min' => '0',
                            'step' => '0.01',
                        ]) ?>
                        <?= view_cell('FormInputCell', [
                            'name' => 'stock',
                            'type' => 'number',
                            'label' => 'Cantidad',
                            'placeholder' => "20",
                            'min' => '1',
                            'step' => '1',
                        ]) ?>
                        <?= view_cell('FormInputCell', [
                            'name' => 'min_stock',
                            'type' => 'number',
                            'label' => 'Cantidad Mínima (para alertar)',
                            'placeholder' => "20",
                            'min' => '1',
                            'step' => '1',
                        ]) ?>
                        <?= view_cell('FormInputCell', [
                            'name' => 'measure_unit',
                            'label' => 'Unidad de Medida',
                            'list' => [
                                'unidad',
                                'lb',
                                'kg',
                                'lt',
                                'mt'
                            ],
                        ]) ?>

                    </div>


                    <div class="d-grid">
                        <button type="submit" class="btn btn-success mx-auto" style="width: 35%;">Registrar</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<script>
    const inputStock = document.getElementById("input-stock");
    const inputMinStock = document.getElementById("input-min_stock");
    const inputMeasureUnit = document.getElementById("input-measure_unit");
    const $typeSelect = document.getElementById("select-type");
    const inputs = [inputStock, inputMinStock, inputMeasureUnit];

    function activateStock(element, event) {
        let isProduct = true;
        if (event instanceof Event) {
            isProduct = event.target.value === "product";
        } else if (typeof event === 'string') {
            isProduct = event === "product";
        }
        for (const input of inputs) {
            if (!input) continue;
            input.disabled = !isProduct;
            input.value = null;
            if (input.name === 'measure_unit') input.value = 'unidad';
        }

    }
    if ($typeSelect)
        activateStock(null, $typeSelect.value);

    function activatePrice(element, event) {
        const selectedOption = event.target.selectedOptions[0].text;
        const itemType = selectedOption.substring(0, selectedOption.lastIndexOf("|")).trim();
        const inputSellingPrice = document.querySelector("input[name='selling_price' ]");

        inputSellingPrice.disabled = itemType === "Ingreso" ? false : true;
        inputSellingPrice.placeholder = itemType === "Ingreso" ? 0.75 : "";
    }
</script>
<?= $this->endSection() ?>