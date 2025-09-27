<div class="table-responsive">
    <table id="showtable" class="table table-striped table-hover table-bordered">
        <thead class="table-secondary">
            <tr>
                <th> </th>
                <?php foreach ($headModel as $label): ?>
                    <th><?= $label ?></th>
                <?php endforeach; ?>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($bodyModel)): ?>
                <?php foreach ($bodyModel as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <?php foreach ($row as $key => $label): ?>
                            <td><?= $label ?></td>
                        <?php endforeach; ?>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-outline-primary" type="button" title="Ver informacion de Elemento" href="<?= $segment . '/' .  $item->id ?>">
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
                                    data-bs-target="#exampleModal" data-bs-id="<?= $row->id ?>" data-bs-name="<?= $segmentName ?>">
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
                <form action="" data-segment=<?= $segment ?> id="form-delete-element" method="POST">
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

            const modalMessage = exampleModal.querySelector('.modal-body .modal-message')

            modalMessage.textContent = `¿Estas seguro de que deseas eliminar ${name}?`
            modalDeleteForm.action = `${segment}/${id}`
        })
        exampleModal.addEventListener('hide.bs.modal', (e) => (modalDeleteForm.action = ""))
    }
</script>