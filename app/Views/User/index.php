<?php $this->extend('layouts/default') ?>
<?php $this->section('content') ?>
<div class="container mt-4">
    <h2 class="mb-4"><?= $title ?></h2>

    <a href="/user/new" class="btn btn-primary mb-3">Crear Usuario</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
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
                        <td>
                            <button class="btn btn-danger btn-sm"
                                    onclick="confirmarEliminacion(<?= $users[$i]->id ?>)">
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

<script>
    function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de eliminar este usuario?')) {
            window.location.href = "<?= site_url('user/delete/') ?>" + id;
        }
    }
</script>
<?php $this->endSection()?>
