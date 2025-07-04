<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <h1 class="mb-4"><?= $title ?></h1>
  <a href="/transactions/new" class="btn btn-primary">Registrar Transacción</a>
  <a href="/categories" class="btn btn-success">Ver Categorías</a>
  <div class="table-responsive" >
    <table id="showtable" class="table table-striped table-hover table-bordered">
      <thead class="table-dark">
        <tr>
          <th></th>
          <th>Categoría</th>
          <th>Descripción</th>
          <th>Monto</th>
          <th>Método de Pago</th>
          <th>Fecha</th>
          <th>Notas</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($transactions)): ?>
          <?php for ($i = 0; $i < count($transactions); $i++): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td><?= $transactions[$i]->category_name ?></td>
              <td><?= $transactions[$i]->description ?></td>
              <td><?= '$'.number_format($transactions[$i]->amount, 2) ?></td>
              <td><?= $transactions[$i]->getMethodDisplayName() ?></td>
              <td><?= $transactions[$i]->transaction_date ?></td>
              <td><?= $transactions[$i]->notes ?></td>
              <td>
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-success btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                  </button>
                </div>
              </td>
            </tr>
          <?php endfor; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" class="text-center">No hay transacciones registradas.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>
