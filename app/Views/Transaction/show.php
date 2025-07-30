<?= $this->extend('layouts/dashboard')?>

<?= $this->section('content')?>
 <div class="container mt-5 " >
    <div class="card shadow-sm border-0 mx-auto" style="width: 600px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><?= $title ?></h4>
        </div>
        <div class="card-body">
            <?php if (!empty(validation_errors())): ?>
                <div class="alert alert-danger"><?= validation_list_errors() ?></div>
            <?php endif; ?>

            <form action="/transactions/<?= $transaction->id ?>" method="POST" novalidate>
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-3">
                    <label for="due_date" class="form-label">Fecha de vencimiento</label>
                    <input type="date" name="due_date" class="form-control" value="<?= substr($transaction->due_date, 0, 10) ?>"
                    <?= $transaction->payment_status === 'paid' ? 'disabled' : '' ?>>
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label">Contacto</label>
                    <input type="text" class="contact form-control" 
                    value="<?= gettype($contact) !== gettype('') ? $contact->name.' | '.$contact->address : $contact ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="payment_status" class="form-label">Estado</label>
                    <select name="payment_status" class="form-select" <?= $transaction->payment_status === 'paid' ? 'disabled' : '' ?>>
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
                    <label for="records" class="form-label">Registros</label>
                    <table class="table table-striped table-hover table-bordered caption-top">
                        <thead class="table-dark">
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $record):?>
                                <tr>
                                    <td><?= $record->category ?></td>
                                    <td><?= $record->description ?></td>
                                    <td><?= $record->displayAmount() ?></td>
                                    <td class="subtotal"><?= $record->displaySubtotal() ?></td>
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
                    <?php if ($transaction->payment_status !== 'paid'): ?>
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    <?php endif; ?>
                    <a href="/transactions" class="btn btn-secondary">Regresar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // selecionar radios y option del select
    const statusOptions = document.querySelectorAll('select[name="payment_status"] option');
    statusOptions.forEach(option => {
        option.selected = option.value === '<?= $transaction->payment_status ?>' ? true : false;
    });
    const methodRadios = document.querySelectorAll('input[name="payment_method"]');
    methodRadios.forEach(radio => {
        radio.checked = radio.value === '<?= $transaction->payment_method ?>' ? true : false;
        radio.disabled = <?= $transaction->payment_status === 'paid' ? 'true' : 'false' ?>;
    });
    
    // calcular valor del total
    const totalInput = document.querySelector('input[name="total"]');
    const subtotals = document.querySelectorAll('form table tbody td.subtotal');
    let total = 0;
    subtotals.forEach(subtotal => {
        total = total + parseFloat(subtotal.innerHTML.replace('$', '') || 0)
    })
    totalInput.value = total.toFixed(2);
</script>
<?= $this->endSection()?>