<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4"><?= $title ?></h1>
    <a href="/users/new" class="btn btn-primary mb-3">Crear Usuario</a>

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
                        <td><?= $i + 1 ?></td>
                        <td><?= $users[$i]->name ?></td>
                        <td><?= $users[$i]->email ?></td>
                        <td><?= $users[$i]->displayRole() ?></td>
                        <td>
                            <form action="/user/<?= $users[$i]->id ?>/activate" method="POST">
                                <input type="hidden" name="_method" value="PUT">
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <?= $users[$i]->displayIsActive() ?>
                                </button>
                            </form>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm"
                            onclick="openDialog('/users/','<?= $users[$i]->id ?>')">
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
                    <td colspan="6" class="text-center">No hay usuarios registrados.</td>
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
<script src="/assets/js/delete-dialog.js"></script>
<?= $this->endSection()?>
