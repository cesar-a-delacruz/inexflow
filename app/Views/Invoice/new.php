<?= $this->extend('layouts/dashboard')?>

<?= $this->section('content')?>
 <div class="container mt-5 " >
    <div class="card shadow-sm border-0 mx-auto" style="width: 600px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><?= $title ?></h4>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>
            <?php if (!empty(validation_errors())): ?>
                <div class="alert alert-danger"><?= validation_list_errors() ?></div>
            <?php endif; ?>

            <form action="/invoices" method="POST" novalidate>
                <div class="mb-3">
                    <label for="due_date" class="form-label">Fecha de vencimiento</label>
                    <input type="date" name="due_date" class="form-control" value="<?= date('Y-m-d')?>">
                </div>
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Tipo de Factura</label>
                    <div class="form-check">
                        <input type="radio" name="type" class="form-check-imput" id="type1" value="income">
                        <label for="type1" class="form-check-label">Ingreso</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="type" class="form-check-imput" id="type2" value="expense">
                        <label for="type2" class="form-check-label">Gasto</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="invoice_date" class="form-label">Contacto</label>
                    <input type="text" class="contact form-control" readonly>
                    <input type="hidden" name="contact_id" class="form-control">
                    <button type="button" class="btn btn-secondary mt-3" onclick="openDialog(this, event, 'contacts')">Buscar Contacto</button>
                </div>
                <div class="mb-3">
                    <label for="payment_status" class="form-label">Estado</label>
                    <select name="payment_status" class="form-select">
                        <option value="">-- Seleccione el estado --</option>
                        <option value="paid">Pagada</option>
                        <option value="pending">Pendiente</option>
                        <option value="overdue">Atrasada</option>
                        <option value="cancelled">Cancelada</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Método de Pago</label>
                    <div class="form-check">
                        <input type="radio" name="payment_method" class="form-check-imput" id="payment_method1" value="cash">
                        <label for="payment_method1" class="form-check-label">Efectivo</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="payment_method" class="form-check-imput" id="payment_method3" value="card">
                        <label for="payment_method3" class="form-check-label">Tarjeta de Débito/Crédito</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="payment_method" class="form-check-imput" id="payment_method2" value="transfer">
                        <label for="payment_method2" class="form-check-label">Transferencia Bancaria</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="transactions" class="form-label">Transacciones</label>
                    <table class="table table-striped table-hover table-bordered caption-top">
                        <thead class="table-dark">
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acción</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary mt-3" onclick="openDialog(this, event, 'items')">Añadir Item</button>
                </div>
                <div class="mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input type="number" name="total" class="form-control" readonly>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<dialog class="items">
    <button class="btn btn-secondary btn-sm mb-3" onclick="this.parentElement.close()">X</button>
    <h5>Elige un Item (Haz click en la tabla)</h5>
    <table class="income table table-striped table-hover table-bordered caption-top"
    style="display: none">
        <caption>Ingreso</caption>
      <thead class="table-dark">
        <tr>
          <th></th>
          <th>Categoría</th>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>Cantidad</th>
          <th>Precio de Venta</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($items->income)): ?>
          <?php for ($i = 0; $i < count($items->income); $i++): ?>
            <tr data-index="<?= $i?>">
              <td><?= $i + 1 ?></td>
              <td class="category"><?= $items->income[$i]->category_name ?></td>
              <td class="description"><?= $items->income[$i]->name ?></td>
              <td><?= $items->income[$i]->displayType() ?></td>
              <td class="amount"><?= $items->income[$i]->displayProperty('current_stock') ?></td>
              <td class="money"><?= $items->income[$i]->displayMoney('selling_price') ?></td>
            </tr>
          <?php endfor; ?>
        <?php endif; ?>
      </tbody>
    </table>
    <table class="expense table table-striped table-hover table-bordered caption-top"
    style="display: none">
        <caption>Gasto</caption>
      <thead class="table-dark">
        <tr>
          <th></th>
          <th>Categoría</th>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>Cantidad</th>
          <th>Costo</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($items->expense)): ?>
          <?php for ($i = 0; $i < count($items->expense); $i++): ?>
            <tr data-index="<?= $i?>">
              <td><?= $i + 1 ?></td>
              <td class="category"><?= $items->expense[$i]->category_name ?></td>
              <td class="description"><?= $items->expense[$i]->name ?></td>
              <td><?= $items->expense[$i]->displayType() ?></td>
              <td class="amount"><?= $items->expense[$i]->displayProperty('current_stock') ?></td>
              <td class="money"><?= $items->expense[$i]->displayMoney('cost') ?></td>
            </tr>
          <?php endfor; ?>
        <?php endif; ?>
      </tbody>
    </table>
</dialog>
<dialog class="contacts">
    <button class="btn btn-secondary btn-sm mb-3" onclick="this.parentElement.close()">X</button>
    <h5>Elige un Contacto (Haz click en la tabla)</h5>
    <table class="income table table-striped table-hover table-bordered caption-top"
    style="display: none">
        <caption>Clientes</caption>
      <thead class="table-dark">
        <tr>
          <th></th>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th>Dirreción</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($contacts->customer)): ?>
          <?php for ($i = 0; $i < count($contacts->customer); $i++): ?>
            <tr data-id="<?= $contacts->customer[$i]->id ?>">
              <td><?= $i + 1 ?></td>
              <td class="name"><?= $contacts->customer[$i]->name ?></td>
              <td><?= $contacts->customer[$i]->email ?></td>
              <td><?= $contacts->customer[$i]->phone ?></td>
              <td class="address"><?= $contacts->customer[$i]->address ?></td>
            </tr>
          <?php endfor; ?>
        <?php endif; ?>
      </tbody>
    </table>
    <table class="expense table table-striped table-hover table-bordered caption-top"
    style="display: none">
        <caption>Proveedores</caption>
      <thead class="table-dark">
        <tr>
          <th></th>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th>Dirreción</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($contacts->provider)): ?>
          <?php for ($i = 0; $i < count($contacts->provider); $i++): ?>
            <tr data-id="<?= $contacts->provider[$i]->id ?>">
              <td><?= $i + 1 ?></td>
              <td class="name"><?= $contacts->provider[$i]->name ?></td>
              <td><?= $contacts->provider[$i]->email ?></td>
              <td><?= $contacts->provider[$i]->phone ?></td>
              <td class="address"><?= $contacts->provider[$i]->address ?></td>
            </tr>
          <?php endfor; ?>
        <?php endif; ?>
      </tbody>
    </table>
</dialog>

<script src="/assets/js/dialogs.js"></script>
<?= $this->endSection()?>