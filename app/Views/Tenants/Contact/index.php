<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
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

<div class="d-flex align-items-center gap-2">
    <a href="<?= $segment ?>/new" class="btn btn-outline-primary d-flex gap-1 align-items-center float-none">
        Agregar <?= $segmentName ?>
        <svg class="bi flex-shrink-0" role="img" width="20" height="20">
            <use href="/assets/svg/miscellaniaSprite.svg#fe-plus" />
        </svg>
    </a>
</div>

<div class="table-responsive">
    <table id="showtable" class="table table-striped table-hover table-bordered">
        <thead class="table-secondary">
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Direccion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $i => $item): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $item->name ?></td>
                        <td><?= $item->email ?></td>
                        <td><?= $item->phone ?></td>
                        <td><?= $item->address ?></td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-outline-primary" type="button" title="Ver informacion de Elemento" href="<?= $segment . '/' . $item->id ?>">
                                    <svg class="bi flex-shrink-0" role="img" aria-label="Ver informacion de Elemento" width="24" height="24">
                                        <use href="/assets/svg/miscellaniaSprite.svg#fe-info" />
                                    </svg>
                                </a>
                                <a class="btn btn-primary" type="button" title="Editra Elemento" href="<?= $segment . '/' . $item->id ?>/edit">
                                    <svg class="bi flex-shrink-0" role="img" aria-label="Editra Elemento" width="24" height="24">
                                        <use href="/assets/svg/miscellaniaSprite.svg#fe-edit" />
                                    </svg>
                                </a>
                                <button type="button" class="btn btn-danger" title="Eliminar Elemento" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-bs-id="<?= $item->id ?>" data-bs-name="<?= $item->name ?>">
                                    <svg class="bi flex-shrink-0" role="img" aria-label="Eliminar Elemento" width="24" height="24">
                                        <use href="/assets/svg/miscellaniaSprite.svg#fe-trash" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">No hay elementos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar <?= $segmentName ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="modal-message h6"></p>
                <p class="text-danger">Al eliminar un <?= $segmentName ?> toda informacio relacionada a esta sera eliminada permanentemnte</p>
                <form action="" data-segment="<?= $segment ?>" id="form-delete-element" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="form-delete-element" class="btn btn-danger d-flex align-items-center gap-2">
                    Eliminar
                    <svg class="bi flex-shrink-0" role="img" aria-label="Eliminar Elemento" width="20" height="20">
                        <use href="/assets/svg/miscellaniaSprite.svg#fe-trash" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    const exampleModal = document.getElementById('exampleModal')
    if (exampleModal) {
        /**@type HTMLFormElment */
        const modalDeleteForm = exampleModal.querySelector(".modal-body form")
        const segment = modalDeleteForm.getAttribute('data-segment')
        exampleModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget
            const id = button.getAttribute('data-bs-id')
            const name = button.getAttribute('data-bs-name')

            const modalTitle = exampleModal.querySelector('.modal-title')
            const modalMessage = exampleModal.querySelector('.modal-body .modal-message')

            modalMessage.textContent = `¿Estas seguro de que deseas eliminar ${name}?`
            modalDeleteForm.action = `${segment}/${id}`
        })
        exampleModal.addEventListener('hide.bs.modal', event => {
            modalDeleteForm.action = "";
        })
    }
</script>
<?= $this->endSection() ?>