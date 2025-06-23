<?php $this->extend('layouts/dashboard') ?>
<?php $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4"><?= $title ?></h1>
    <a href="/categories/new" class="btn btn-primary mb-3">Añadir Categoria</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Número</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
                <?php for ($i = 0; $i < count($categories); $i++): ?>
                    <tr>
                        <td><?= $categories[$i]->category_number ?></td>
                        <td><?= $categories[$i]->name ?></td>
                        <td><?= $categories[$i]->getTypeDisplayName() ?></td>
                        <td>
                            <form action="/category/<?= $categories[$i]->business_id.$categories[$i]->category_number ?>" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endfor; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No hay categorias registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<dialog class="delete">
    <button class="btn btn-secondary btn-sm mb-3" onclick="closeDialog(this, event)">X</button>
    <h5>Para eliminar este usuario introduce la contraseña del mismo</h5>
    <form action="" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="DELETE">
        
        <label for="password" class="form-label">Contraseña</label>
        <input type="text" name="password" id="password" class="form-control mb-3">
        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
    </form>
</dialog>
<script>
    const dialog = document.querySelector('dialog.delete');
    function openDialog(id) {
        dialog.showModal();
        document.querySelector('dialog.delete form').action = "/user/" + id;
        document.querySelector('dialog.delete form input[name="id"]').value = id;
    }
    function closeDialog(element, event) {
        event.preventDefault()
        dialog.close();
    }
</script>

<?php if (!empty(validation_errors())): ?>
    <dialog class="error">
        <button class="btn btn-secondary btn-sm mb-3" onclick="document.querySelector('dialog.error').close()">X</button>
        <h5>Error en la operación</h5>
        <div class="alert alert-danger"><?= validation_list_errors() ?></div>
    </dialog>
    <script>document.querySelector('dialog.error').showModal()</script>
<?php endif; ?>
<?php $this->endSection()?>
