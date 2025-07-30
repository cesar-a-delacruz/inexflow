<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4"><?= $title ?></h1>
    <a href="/categories/new" class="btn btn-primary mb-3">Añadir Categoria</a>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <table id="showtable" class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
                <?php for ($i = 0; $i < count($categories); $i++): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $categories[$i]->name ?></td>
                        <td><?= $categories[$i]->displayType() ?></td>
                        <td>
                            <div class="btn-group">
                            <button class="btn btn-success btn-sm" onclick="location.assign('/categories/<?= $categories[$i]->id ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </button>
                            <button class="btn btn-danger" onclick="openDialog('/categories/', '<?= $categories[$i]->id ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php endfor; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No hay categorias registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<dialog class="delete">
    <h5>¿Estas seguro de que deseas eliminar esta categoría?</h5>
    <form action="" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-danger btn-sm">Sí</button>
        <button class="btn btn-secondary btn-sm" onclick="closeDialog(this, event)">No</button>
    </form>
</dialog>
<script src="/assets/js/delete-dialog.js"></script>
<?= $this->endSection() ?>