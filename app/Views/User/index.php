<?php $this->extend('layouts/dashboard') ?>
<?php $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4"><?= $title ?></h1>
    <a href="/users/new" class="btn btn-primary mb-3">Crear Usuario</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th></th>
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
                        <td><?= $users[$i]->getRoleDisplayName() ?></td>
                        <td>
                            <form action="/user/<?= $users[$i]->id ?>/activate" method="POST">
                                <input type="hidden" name="_method" value="PUT">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <?= $users[$i]->getIsActiveDisplayName() ?>
                                </button>
                            </form>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                            onclick="openDialog('<?= $users[$i]->id ?>')">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endfor; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<dialog>
    <button class="btn btn-secondary btn-sm mb-3" onclick="closeDialog(this, event)">X</button>
    <h5>Para eliminar este usuario introduce la contraseña del mismo</h5>
    <form action="" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        
        <label for="password" class="form-label">Contraseña</label>
        <input type="text" name="password" id="password" class="form-control mb-3">
        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
    </form>
</dialog>
<script>
    const dialog = document.querySelector('dialog');
    function openDialog(id) {
        dialog.showModal();
        document.querySelector('dialog form').action = "/user/" + id;
    }
    function closeDialog(element, event) {
        event.preventDefault()
        dialog.close();
    }
</script>
<?php $this->endSection()?>
