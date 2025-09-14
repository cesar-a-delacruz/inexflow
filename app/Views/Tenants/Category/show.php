<?= $this->extend('layouts/dashboard')?>

<?= $this->section('content')?>
 <div class="container mt-5 " >
    <div class="card shadow-sm border-0 mx-auto" style="width: 600px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Nueva Categoría</h4>
        </div>
        <div class="card-body">
            <?php if (!empty(validation_errors())): ?>
                <div class="alert alert-danger"><?= validation_list_errors() ?></div>
            <?php endif; ?>

            <form action="/categories/<?= $category->id ?>" method="post" novalidate>
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="<?= $category->name?>">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Tipo</label>
                    <select name="type" class="form-select" disabled>
                        <?= '<option value="income"'.($category->type === 'income' ? 'selected' : '').'>Ingreso</option>'?>
                        <?= '<option value="expense"'.($category->type === 'expense' ? 'selected' : '').'>Gasto</option>'?>
                    </select>
                </div>
                <div class="grid text-center">
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    <a href="/categories" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection()?>