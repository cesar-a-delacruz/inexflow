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
                    <label for="invoice_date" class="form-label">Fecha</label>
                    <input type="date" name="invoice_date" class="form-control" value="<?= date('Y-m-d')?>">
                </div>
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
                    <button type="button" class="btn btn-secondary mt-3" onclick="openDialog(this, event)">Añadir Item</button>
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
              <td><?= $items->income[$i]->getTypeDisplayName() ?></td>
              <td class="amount"><?= $items->income[$i]->current_stock ? $items->income[$i]->current_stock : 'No Aplica' ?></td>
              <td class="money"><?= '$'.number_format($items->income[$i]->selling_price, 2) ?></td>
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
              <td><?= $items->expense[$i]->getTypeDisplayName() ?></td>
              <td class="amount"><?= $items->expense[$i]->current_stock ? $items->expense[$i]->current_stock : 'No Aplica' ?></td>
              <td class="money"><?= '$'.number_format($items->expense[$i]->cost, 2) ?></td>
            </tr>
          <?php endfor; ?>
        <?php endif; ?>
      </tbody>
    </table>
</dialog>
<script>
    const dialog = document.querySelector('dialog.items');
    function openDialog(element, event) {
        event.preventDefault()
        const heading = document.querySelector('dialog h5');
        const invoiceType = document.querySelector('input[name="type"]:checked');
        heading.innerHTML = invoiceType ? 'Elige un Item (Haz click en una fila)' : 'Selecciona el Tipo de Factura primero';
        dialog.showModal(); 
    }
    function closeDialog(element, event) {
        event.preventDefault()
        dialog.close();
    }
    // mostrar tabla de items segun tipo de factura
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const tables = document.querySelectorAll('dialog table');
    typeRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            tables.forEach(table => {
                table.style.display = radio.value === table.classList[0]
                ? 'table' : 'none';
            })
            radio.disabled = true;
        })
    });
    // crear fila en tabla de transacciones
    const formTable = document.querySelector('form table').children[1];
    tables.forEach(table => {
        for (const row of table.children[2].children) {
            row.addEventListener('click', (event) => {
                const newRowIndex = formTable.children.length;
                const rowAmount = row.children[4].innerHTML;
                const invoiceType = document.querySelector('input[name="type"]:checked').value;

                let inputs = [];
                for (let i = 0; i < 2; i++) {
                    const input = document.createElement('input');
                    input.type = 'number';
                    input.step = '1';
                    inputs.push(input);
                }
                inputs[0].name = `transactions[${newRowIndex}][amount]`;
                inputs[0].className = 'amount form-control';
                if (row.children[3].innerHTML === 'Servicio') {
                    inputs[0].disabled = true;
                    inputs[1].value = parseFloat(row.children[5].innerHTML.replace('$', '')).toFixed(2);
                    const totalInput = document.querySelector('input[name="total"]');
                    totalInput.value = (parseFloat(totalInput.value) + parseFloat(inputs[1].value || 0)).toFixed(2);
                } else {
                    inputs[0].min = '1';
                    if (invoiceType === 'income') inputs[0].max = rowAmount;
                    inputs[0].addEventListener('change', () => {
                        const parent = inputs[0].parentElement.parentElement;
                        
                        const moneyCell = document.querySelector(`dialog table.${invoiceType} tbody tr[data-index="${parent.dataset.index}"] td.money`); 
                        const money = parseFloat(moneyCell.innerHTML.replace('$', '')).toFixed(2);
                        inputs[1].value = (parseInt(inputs[0].value) * money).toFixed(2);
                        inputs[1].dispatchEvent(new Event("change"));
    
                    });
                }
                inputs[1].name = `transactions[${newRowIndex}][subtotal]`;
                inputs[1].className = 'subtotal form-control';
                inputs[1].readOnly = true;
                inputs[1].addEventListener('change', () => calculateTotal());


                const relevantData = [
                    row.children[1], row.children[2], ...inputs
                ];

                const newRow = document.createElement('tr');
                newRow.dataset.index = row.dataset.index;
                for (const data of relevantData) {
                    if (data.tagName === 'TD') {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `transactions[${newRowIndex}][${data.className}]`;
                        input.value = data.innerHTML;
                        const dataClone = data.cloneNode(true);
                        dataClone.append(input);
                        newRow.append(dataClone);
                    } else {
                        const cell = document.createElement('td');
                        cell.append(data);
                        newRow.append(cell);
                    }
                }
                // eliminar fila
                const removeCell = document.createElement('td');
                const removeButton = document.createElement('button');
                removeButton.className = 'remove btn btn-danger';
                removeButton.innerHTML += `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                      <polyline points="3 6 5 6 21 6"></polyline>
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                      <line x1="10" y1="11" x2="10" y2="17"></line>
                      <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>`;
                removeButton.addEventListener('click', () => {
                    const parent = removeButton.parentElement.parentElement;
                    const hiddenRow = document.querySelector(`dialog table.${invoiceType} tbody tr[data-index="${parent.dataset.index}"]`); 
                    hiddenRow.style.display = 'table-row';
                    parent.remove();
                    calculateTotal();
                });
                removeCell.append(removeButton);
                newRow.append(removeCell);
                formTable.append(newRow);
                row.style.display = 'none';
            })
        }
    });
    // calcular valor del subtotal
    function calculateTotal() {
        const totalInput = document.querySelector('input[name="total"]');
        const subtotals = document.querySelectorAll('form table tbody input.subtotal');
        let total = 0;
        subtotals.forEach(subtotal => {
            total = total + parseFloat(subtotal.value || 0)
        })
        totalInput.value = total.toFixed(2);
    }
</script>
<?= $this->endSection()?>