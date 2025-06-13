<?php $this->extend('layouts/default') ?>
<?php $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4"><?= $title ?></h1>

    <a href="/user/new" class="btn btn-primary mb-3">Crear Usuario</a>
    <a href="/logout" class="btn btn-danger mb-3">Cerrar Sesión</a>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php for ($i = 0; $i < count($users); $i++): ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= $users[$i]->name ?></td>
                        <td><?= $users[$i]->email ?></td>
                        <td><?= $users[$i]->role ?></td>
                        <td><?= $users[$i]->is_active ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                            onclick="setDialog('<?= $users[$i]->id ?>')">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endfor; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">No hay usuarios registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<dialog>
    <p>¿Estás seguro que deseas eliminar este usuario?</p>
    <form action="" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="user_id" value="">
        <button type="submit" class="btn btn-danger btn-sm">Sí</button>
        <button class="btn btn-danger btn-sm" onclick="closeDialog(this, event)">No</button>
    </form>
</dialog>
<script>
    function setDialog(id) {
        document.querySelector('dialog').showModal();
        document.querySelector('dialog form').action = "/user/" + id;
        document.querySelector('dialog form input[name="user_id"]').value = id;
    }
    function closeDialog(element, event) {
        event.preventDefault()
        document.querySelector('dialog').close();
    }
</script>
<?php $this->endSection()?>
