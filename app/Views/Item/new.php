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
                        <?php $nameValid = !!validation_show_error('name') ?>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control <?= $nameValid ? 'is-invalid' : null ?>" require
                                value="<?= !$nameValid ? set_value('name') : null ?>"
                                id="name" name="name" placeholder="Aguacate">
                            <label for="name">Nombre</label>
                            <?php if ($nameValid): ?>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('name') ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <?php $typeValid = !!validation_show_error('type') ?>
                        <div class="form-floating mb-3">
                            <select class="form-select <?= $typeValid ? 'is-invalid' : null ?>" id="type" name="type" onchange="activateStock(this, event)" aria-label="Tipo de elemento">
                                <option selected value="product">Producto</option>
                                <option value="service">Servicio</option>
                            </select>
                            <label for="type">Tipo de Elemento</label>
                            <?php if ($typeValid): ?>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('type') ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <?php $categoryIdValid = !!validation_show_error('category_id') ?>
                        <div class="form-floating mb-3">
                            <select class="form-select <?= $categoryIdValid ? 'is-invalid' : null ?>" id="category_id" name="category_id" aria-label="Categoria">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->id ?>">
                                        <?= $category->displayType() . " | " . $category->name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label for="category_id">Categoria</label>
                            <?php if ($categoryIdValid): ?>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('category_id') ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <?php $costValid = !!validation_show_error('cost') ?>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control <?= $costValid ? 'is-invalid' : null ?>" require
                                value="<?= !$costValid ? set_value('cost') : null ?>"
                                id="cost" name="cost" step="0.01" min="0" placeholder="0.50">
                            <label for="cost">Costo</label>
                            <?php if ($costValid): ?>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('cost') ?>
                                </div>
                            <?php endif ?>
                        </div>

                    </div>
                    <div class="col">
                        <?php $sellingPriceValid = !!validation_show_error('selling_price') ?>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control <?= $sellingPriceValid ? 'is-invalid' : null ?>" require
                                value="<?= !$sellingPriceValid ? set_value('selling_price') : null ?>"
                                id="selling_price" name="selling_price" step="0.01" min="0" placeholder="0.75">
                            <label for="selling_price">Precio de Venta</label>
                            <?php if ($sellingPriceValid): ?>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('selling_price') ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <?php $stockValid = !!validation_show_error('stock') ?>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control <?= $stockValid ? 'is-invalid' : null ?>" require
                                value="<?= !$stockValid ? set_value('stock') : 1 ?>"
                                id="stock" name="stock" step="1" min="1" placeholder="20">
                            <label for="stock">Cantidad</label>
                            <?php if ($stockValid): ?>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('stock') ?>
                                </div>
                            <?php endif ?>
                        </div>

                        <?php $minStockValid = !!validation_show_error('min_stock') ?>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control <?= $minStockValid ? 'is-invalid' : null ?>" require
                                value="<?= !$minStockValid ? set_value('min_stock') : 1 ?>"
                                id="min_stock" name="min_stock" step="1" min="1" placeholder="20">
                            <label for="min_stock">Cantidad Mínima (para alertar)</label>
                            <?php if ($minStockValid): ?>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('min_stock') ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <?php $measureUnitValid = !!validation_show_error('measure_unit') ?>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control <?= $measureUnitValid ? 'is-invalid' : null ?>" require
                                value="<?= !$measureUnitValid ? set_value('measure_unit') : null ?>"
                                id="measure_unit" list='measure_unit_list' name="measure_unit" step="1" min="1" placeholder="lb">
                            <label for="measure_unit">Unidad de Medida</label>
                            <?php if ($measureUnitValid): ?>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('measure_unit') ?>
                                </div>
                            <?php endif ?>
                            <datalist id="measure_unit_list">
                                <option value="unidad">
                                <option value="lb">
                                <option value="kg">
                                <option value="lt">
                                <option value="mt">
                            </datalist>
                        </div>
                    </div>
                </div>


                <div class="d-grid">
                    <button type="submit" class="btn btn-success mx-auto" style="width: 35%;">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const inputStock = document.querySelector("input[name='stock']");
    const inputMinStock = document.querySelector("input[name='min_stock']");
    const inputMeasureUnit = document.querySelector("input[name='measure_unit']");
    const inputs = [inputStock, inputMinStock, inputMeasureUnit];

    function activateStock(element, event) {
        isProduct = event.target.value === "product";
        for (const input of inputs) {
            if (!input) continue;
            input.disabled = !isProduct;
            input.value = null;
            if (input.name === 'measure_unit') input.value = 'unidad';
        }

    }

    function activatePrice(element, event) {
        const selectedOption = event.target.selectedOptions[0].text;
        const itemType = selectedOption.substring(0, selectedOption.lastIndexOf("|")).trim();
        const inputSellingPrice = document.querySelector("input[name='selling_price' ]");

        inputSellingPrice.disabled = itemType === "Ingreso" ? false : true;
        inputSellingPrice.placeholder = itemType === "Ingreso" ? 0.75 : "";
    }
</script>
<?= $this->endSection() ?>