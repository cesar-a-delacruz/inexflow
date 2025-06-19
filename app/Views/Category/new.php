<?= $this->extend('layouts/dashboard')?>

<?= $this->section('content')?>
 <div class="container mt-5 " >
    <div class="card shadow-sm border-0 mx-auto" style="width: 600px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Crear Nueva Categoría</h4>
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

            <form action="/categories" method="post" novalidate>
                <div class="mb-3">
                    <label for="category_number" class="form-label">Número de Categoría</label>
                    <input type="number" name="category_number" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="business_id" class="form-label">Negocio</label>
                    <select name="business_id" class="form-select" required>
                        <option value="">-- Seleccione un negocio --</option>
                        <?php foreach ($businesses as $business): ?>
                            <option value="<?= $business->id ?>"><?= $business->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" >
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Tipo</label>
                    <select name="type" class="form-select" required>
                        <option value="income">Ingreso</option>
                        <option value="expense">Gasto</option>
                    </select>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection()?>