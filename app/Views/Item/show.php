<?= $this->extend('layouts/dashboard')?>

<?= $this->section('content')?>
 <div class="container mt-5 " >
    <div class="card shadow-sm border-0 mx-auto" style="width: 600px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><?= $title ?></h4>
        </div>
        <div class="card-body">
            <?php if (!empty(validation_errors())): ?>
                <div class="alert alert-danger"><?= validation_list_errors() ?></div>
            <?php endif; ?>

            <form action="/items/<?= $item->id ?>" method="POST" novalidate>
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="<?= $item->name?>">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Tipo</label>
                    <select name="type" class="form-select" disabled>
                        <option value="">-- Seleccione el tipo --</option>
                        <?= '<option value="product"'.($item->type === 'product' ? 'selected' : '').'>Producto</option>'?>
                        <?= '<option value="service"'.($item->type === 'service' ? 'selected' : '').'>Servicio</option>'?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Categoría</label>
                    <select name="category_id" class="form-select" disabled>
                        <option value="">-- Seleccione una categoría --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>"
                            <?= $item->category_id === $category->id ? 'selected': null ?>>
                                <?= $category->displayType()." | ".$category->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="cost" class="form-label">Costo</label>
                    <input type="number" name="cost" class="form-control" step="0.01" min="0" 
                    placeholder="0.50"  value="<?= $item->cost?>">
                </div>
                <div class="mb-3">
                    <label for="selling_price" class="form-label">Precio de Venta</label>
                    <input type="number" name="selling_price" class="form-control" step="0.01" min="0" 
                    <?= $item->selling_price ? "value=\"$item->selling_price\"": 'disabled' ?>>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Cantidad</label>
                    <input type="number" name="stock" class="form-control" step="1" min="1"
                    <?= $item->stock ? "value=\"$item->stock\"": 'disabled' ?>>
                </div>
                <div class="mb-3">
                    <label for="min_stock" class="form-label">Cantidad Mínima (para alertar)</label>
                    <input type="number" name="min_stock" class="form-control"step="1" min="1"
                    <?= $item->min_stock ? "value=\"$item->min_stock\"": 'disabled' ?>>
                </div>
                <div class="mb-3">
                    <label for="measure_unit" class="form-label">Unidad de Medida</label>
                    <input type="text" name="measure_unit" class="form-control" placeholder="unidad, kg, lb, etc"
                    <?= $item->measure_unit ? "value=\"$item->measure_unit\"": 'disabled' ?>>
                </div>

                <div class="grid text-center">
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    <a href="/items" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection()?>