<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <h1 class="mb-4"><?= $title ?></h1>
  <a href="/items/new" class="btn btn-primary">Registrar Item</a>
  <a href="/categories" class="btn btn-success">Ver Categorías</a>
  <div class="table-responsive" >
    <table id="showtable" class="table table-striped table-hover table-bordered">
      <thead class="table-dark">
        <tr>
          <th></th>
          <th>Categoría</th>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>Costo</th>
          <th>Precio de Venta</th>
          <th>Cantidad</th>
          <th>Unidad de Medida</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($items)): ?>
          <?php for ($i = 0; $i < count($items); $i++): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td><?= $items[$i]->category_name ?></td>
              <td><?= $items[$i]->name ?></td>
              <td><?= $items[$i]->getTypeDisplayName() ?></td>
              <td><?= '$'.number_format($items[$i]->cost, 2) ?></td>
              <td><?= $items[$i]->selling_price ? '$'.number_format($items[$i]->selling_price, 2) : 'No Aplica' ?></td>
              <td><?= $items[$i]->current_stock ? $items[$i]->current_stock : 'No Aplica' ?></td>
              <td><?= $items[$i]->measure_unit ? $items[$i]->measure_unit : 'No Aplica' ?></td>
              <td>
                <div class="btn-group" role="group">
                  <a href="/transaction/<?= $i+1 ?>" class="btn btn-success btn-sm">
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
            <td colspan="9" class="text-center">No hay productos o servicios registrados.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>
