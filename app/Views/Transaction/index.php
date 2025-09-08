<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>
<a href="/transactions/new" class="btn btn-primary mb-3">Crear Transacción</a>

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
        <th>Número</th>
        <th>Emisión</th>
        <th>Estado del Pago</th>
        <th>Método de Pago</th>
        <th>Contacto</th>
        <th>Tipo de Contacto</th>
        <th>Monto</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($transactions)): ?>
        <?php foreach ($transactions as $transaction): ?>
          <tr>
            <td><?= $transaction->number ?></td>
            <td><?= $transaction->created_at->toLocalizedString('MMM d, yyyy') ?></td>
            <td><?= $transaction->displayPaymentStatus() ?></td>
            <td><?= $transaction->displayPaymentMethod() ?></td>
            <td><?= $transaction->displayContactName() ?></td>
            <td><?= $transaction->displayContactType() ?></td>
            <td><?= number_to_currency($transaction->total, 'PAB', 'es_PA', 2); ?></td>
            <td>
              <div class="btn-group" role="group">
                <a class="btn btn-outline-primary" type="button" title="Editra Elemento" href="/transactions/<?= $transaction->id->toString() ?>">
                  <svg class="bi flex-shrink-0" role="img" aria-label="Editra Elemento" width="24" height="24">
                    <use href="/assets/svg/miscellaniaSprite.svg#fe-edit" />
                  </svg>
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="8" class="text-center">No hay transacciones registradas.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>