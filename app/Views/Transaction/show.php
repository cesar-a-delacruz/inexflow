<?= $this->extend('layouts/dashboard')?>

<?= $this->section('content')?>
 <div class="container mt-5 " >
    <div class="card shadow-sm border-0 mx-auto" style="width: 600px;">
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
            <?php if (!empty(validation_errors())): ?>
                <div class="alert alert-danger"><?= validation_list_errors() ?></div>
            <?php endif; ?>

            <form action="/transactions" method="POST" novalidate>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripcion</label>
                    <input type="text" name="description" class="form-control" value="<?= $transaction->description ?>">
                </div>
                <div class="mb-3">
                    <label for="category_number" class="form-label">Categoría</label>
                    <select name="category_number" class="form-select">
                        <option value="">-- Seleccione una categoría --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->category_number ?>"
                            <?= $category->category_number === $transaction->category_number ? 'selected' : null ?>>
                                <?= $category->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Monto</label>
                    <input type="number" name="amount" class="form-control" value="<?= number_format($transaction->amount, 2) ?>">
                </div>
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Método de Pago</label>
                    <select name="payment_method" class="form-select">
                        <?php foreach ($transaction->getMethods() as $key => $value): ?>
                            <option value="<?= $key ?>" <?= $key === $transaction->payment_method ? 'selected' : null ?>>
                                <?= $value ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">  
                    <div class="form-floating">
                        <textarea class="form-control" name="notes"><?= $transaction->notes ?></textarea>
                        <label for="notes">Notas</label>
                    </div>
                </div>
                <div class="grid text-center">
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    <a href="/transactions" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection()?>