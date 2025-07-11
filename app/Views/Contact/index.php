<?php $this->extend('layouts/dashboard') ?>
<?php $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4"><?= $title ?></h1>
    <a href="/contacts/new" class="btn btn-primary mb-3">Añadir Contacto</a>

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
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Activo</th>
                <th>Proveedor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($contacts)): ?>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?= esc($contact->name) ?></td>
                        <td><?= esc($contact->email) ?></td>
                        <td><?= esc($contact->phone) ?></td>
                        <td><?= $contact->is_active ? 'Sí' : 'No' ?></td>
                        <td><?= $contact->is_provider ? 'Sí' : 'No' ?></td>
                        <td>
                            <a href="/contacts/<?= esc($contact->id) ?>" class="btn btn-info btn-sm me-2">Ver</a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteDialog('<?= esc($contact->id) ?>')">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No hay contactos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<dialog class="delete-dialog">
    <button class="btn btn-secondary btn-sm mb-3" onclick="closeDeleteDialog(this, event)">X</button>
    <h5>¿Estás seguro de que quieres eliminar este contacto?</h5>
    <form id="deleteForm" action="" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
    </form>
</dialog>

<script>
    const deleteDialog = document.querySelector('dialog.delete-dialog');
    function openDeleteDialog(id) {
        deleteDialog.showModal();
        document.getElementById('deleteForm').action = "/contacts/" + id;
    }
    function closeDeleteDialog(element, event) {
        event.preventDefault();
        deleteDialog.close();
    }
</script>

<?php $this->endSection() ?>