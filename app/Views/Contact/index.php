<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>
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
                <th></th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($contacts)): ?>
                <?php for ($i = 0; $i < count($contacts); $i++): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $contacts[$i]->name ?></td>
                        <td><?= $contacts[$i]->email ?></td>
                        <td><?= $contacts[$i]->phone ?></td>
                        <td><?= $contacts[$i]->getTypeDisplayName() ?></td>
                        <td>
                            <button class="btn btn-success btn-sm" onclick="location.assign('/contacts/<?= $contacts[$i]->id ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </button>
                            <form action="/contacts/<?= $contacts[$i]->id ?>" method="POST" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger" type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este contacto?');">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endfor; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No hay contactos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>