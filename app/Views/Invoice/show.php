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

            <form action="/invoices/<?= $invoice->id ?>" method="POST" novalidate>
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-3">
                    <label for="invoice_date" class="form-label">Fecha</label>
                    <input type="date" name="invoice_date" class="form-control" value="<?= substr($invoice->invoice_date, 0, 10) ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="due_date" class="form-label">Fecha de vencimiento</label>
                    <input type="date" name="due_date" class="form-control" value="<?= substr($invoice->due_date, 0, 10) ?>">
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
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $transaction):?>
                                <tr>
                                    <td><?= $transaction->category ?></td>
                                    <td><?= $transaction->description ?></td>
                                    <td><?= $transaction->amount ?></td>
                                    <td class="subtotal"><?= $transaction->subtotal ?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <div class="mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input type="number" name="total" class="form-control" readonly>
                </div>
                <div class="grid text-center">
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    <a href="/invoices" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
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
    // selecionar radios y options
    const statusOptions = document.querySelectorAll('select[name="payment_status"] option   ');
    statusOptions.forEach(option => {
        option.selected = option.value === '<?= $invoice->payment_status ?>' ? true : false;
    });
    const methodRadios = document.querySelectorAll('input[name="payment_method"]');
    methodRadios.forEach(radio => {
        radio.checked = radio.value === '<?= $invoice->payment_method ?>' ? true : false;
    });
    // calcular valor del total
    const totalInput = document.querySelector('input[name="total"]');
    const subtotals = document.querySelectorAll('form table tbody td.subtotal');
    let total = 0;
    subtotals.forEach(subtotal => {
        total = total + parseFloat(subtotal.innerHTML || 0)
    })
    totalInput.value = total.toFixed(2);
</script>
<?= $this->endSection()?>