<?php $this->extend('layouts/default') ?>
<?php $this->section('content') ?>
<div class="container mt-4">
    <h2 class="mb-4">Lista de Usuarios</h2>

    <a href="/user/new" class="btn btn-primary mb-3">Crear Usuario</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users) && is_array($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['id']) ?></td>
                        <td><?= esc($user['nombre']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td><?= esc($user['username']) ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm"
                                    onclick="confirmarEliminacion(<?= $user['id'] ?>)">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
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
