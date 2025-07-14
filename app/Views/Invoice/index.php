<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <h1 class="mb-4"><?= $title ?></h1>
  <a href="/invoices/new" class="btn btn-primary">Crear Factura</a>
  <div class="table-responsive" >
    <table id="showtable" class="table table-striped table-hover table-bordered">
      <thead class="table-dark">
        <tr>
          <th>Número</th>
          <th>Emisión</th>
          <th>Vencimiento</th>
          <th>Estado del Pago</th>
          <th>Método de Pago</th>
          <th>Contacto</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($invoices)): ?>
          <?php for ($i = 0; $i < count($invoices); $i++): ?>
            <tr>
              <td><?= $invoices[$i]->invoice_number ?></td>
              <td><?= $invoices[$i]->invoice_date ?></td>
              <td><?= substr($invoices[$i]->due_date, 0, 10) ?></td>
              <td><?= $invoices[$i]->getStatusDisplayName() ?></td>
              <td><?= $invoices[$i]->getMethodDisplayName() ?></td>
              <td><?= $invoices[$i]->contact_id ?></td>
              <td>
                <div class="btn-group" role="group">
                  <a href="/invoices/<?= $invoices[$i]->id ?>" class="btn btn-success btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                  </a>
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
