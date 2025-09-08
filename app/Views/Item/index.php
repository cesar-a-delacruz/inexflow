<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="button-container">
  <a href="/items/new" class="btn btn-primary">Registrar Item</a>
  <a href="/categories" class="btn btn-success">Ver Categorías</a>
</div>
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
<div class="table-responsive">
  <table id="showtable" class="table table-striped table-hover table-bordered">
    <thead class="table-secondary">
      <tr>
        <th></th>
        <th>Categoría</th>
        <th>Nombre</th>
        <th>Tipo</th>
        <th>Costo</th>
        <th>Precio de Venta</th>
        <th>Cantidad</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($items)): ?>
        <?php foreach ($items as $i => $item): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= $item->displayCategoryType() . ' | ' . $item->category_name ?></td>
            <td><?= $item->name ?></td>
            <td><?= $item->displayType() ?></td>
            <td><?= $item->displayCost() ?></td>
            <td><?= $item->displaySellingPrice() ?></td>
            <td>
              <?php if ($item->type === 'product'): ?>
                <?= $item->displayProperty('stock') ?> <sub><?= $item->displayProperty('measure_unit') ?></sub>
              <?php else: ?>
                --
              <?php endif; ?>
            </td>
            <td>
              <div class="btn-group">
                <a class="btn btn-outline-primary" type="button" title="Editra Elemento" href="/items/<?= $item->id->toString() ?>">
                  <svg class="bi flex-shrink-0" role="img" aria-label="Editra Elemento" width="24" height="24">
                    <use href="/assets/svg/miscellaniaSprite.svg#fe-edit" />
                  </svg>
                </a>
                <button type="button" class="btn btn-danger" title="Eliminar Elemento" data-bs-toggle="modal"
                  data-bs-target="#exampleModal" data-bs-item-id="<?= $item->id->toString() ?>" data-bs-item-name="<?= $item->name ?>">
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
          <td colspan="9" class="text-center">No hay productos o servicios registrados.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Elemento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="modal-message h6"></p>
        <p class="text-danger">Al eliminar un elemento toda informacio relacionada a esta sera eliminada permanentemnte</p>
        <form action="" id="form-delete-element" method="POST">
          <input type="hidden" name="_method" value="DELETE">
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" form="form-delete-element" class="btn btn-danger d-flex align-items-center gap-2">
          Eliminar
          <svg class="bi flex-shrink-0" role="img" aria-label="Eliminar Elemento" width="20" height="20">
            <use xlink:href="#fe-trash" />
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
    exampleModal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget
      const itemId = button.getAttribute('data-bs-item-id')
      const itemName = button.getAttribute('data-bs-item-name')
      // If necessary, you could initiate an Ajax request here
      // and then do the updating in a callback.

      const modalTitle = exampleModal.querySelector('.modal-title')
      const modalMessage = exampleModal.querySelector('.modal-body .modal-message')

      modalMessage.textContent = `¿Estas seguro de que deseas eliminar ${itemName}?`
      modalDeleteForm.action = `/items/${itemId}`
    })
    exampleModal.addEventListener('hide.bs.modal', event => {
      modalDeleteForm.action = "";
    })
  }
</script>
<?= $this->endSection() ?>