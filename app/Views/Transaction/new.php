<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mt-5 ">
  <div class="card shadow-sm border-0 mx-auto" style="width: 600px;">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0"><?= $title ?></h4>
    </div>
    <div class="card-body">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <svg class="bi flex-shrink-0 me-2" height='16px'
            width="16px" role="img" aria-label="Success:">
            <use xlink:href="#check-circle-fill" />
          </svg>
          <?= session()->getFlashdata('success') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
      <?php endif; ?>
      <?php if (!empty(validation_errors())): ?>
        <div class="alert alert-danger"><?= validation_list_errors() ?></div>
      <?php endif; ?>

      <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol viewBox=" 0 0 24 24" id="fe-check">
          <!-- Icon from Feather Icon by Megumi Hano - https://github.com/feathericon/feathericon/blob/master/LICENSE -->
          <path fill="currentColor" fill-rule="evenodd" d="m6 10l-2 2l6 6L20 8l-2-2l-8 8z"></path>
        </symbol>
        <symbol viewBox="0 0 24 24" id="fe-close"><!-- Icon from Feather Icon by Megumi Hano - https://github.com/feathericon/feathericon/blob/master/LICENSE -->
          <path fill="currentColor" fill-rule="evenodd" d="M10.657 12.071L5 6.414L6.414 5l5.657 5.657L17.728 5l1.414 1.414l-5.657 5.657l5.657 5.657l-1.414 1.414l-5.657-5.657l-5.657 5.657L5 17.728z"></path>
        </symbol>
      </svg>
      <form action="/transactions" method="POST" class="needs-validation" novalidate>

        <?= view_cell('FormInputCell', [
          'name' => 'due_date',
          'label' => 'Fecha de vencimiento',
          'type' => 'date',
          'default' => date('Y-m-d'),
          'required' => true,
        ]) ?>


        <div>
          <?php $typeError = validation_show_error('type') ?>
          <label for="typeIncome" class="form-label">Tipo de Transacción</label>
          <div class="mb-3">
            <div class="form-check form-check-inline">
              <input type="radio" <?= set_radio('type', 'income', true) ?> class="form-check-input <?= $typeError ? 'is-invalid' : '' ?>"
                id="typeIncome" value="income" name="type" required>
              <label class="form-check-label" for="typeIncome">Ingreso</label>
            </div>
            <div class="form-check form-check-inline">
              <input type="radio" <?= set_radio('type', 'expense') ?> class="form-check-input <?= $typeError ? 'is-invalid' : '' ?>"
                id="typeExpose" value="expense" name="type" required>
              <label class="form-check-label" for="typeExpose">Gasto</label>
              <?php if ($typeError): ?>
                <div class="invalid-feedback"><?= $typeError ?></div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <input type="hidden" name="contact_id" id='contact_id' class="form-control">
        <div class="input-group mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="contact_name" name="contact_name" readonly
              aria-label="Contacto" aria-describedby="button-contact">
            <label for="contact_name">Contacto</label>
          </div>
          <button class="btn btn-primary" type="button" id="button-contact" onclick="showContactModal()">Buscar contacto</button>
        </div>

        <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="contactModalLabel">Lista de contactos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <table class="table text-center">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nombre</th>
                      <th scope="col">Correo</th>
                      <th scope="col">Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <?= view_cell('FormSelectCell', [
          'name' => 'payment_status',
          'label' => 'Estado del Pago',
          'options' => [
            'paid' => 'Pagada',
            'pending' => 'Pendiente',
            'overdue' => 'Atrasada',
            'cancelled' => 'Cancelada',
          ],
          'default' => 'paid'
        ]) ?>


        <?= view_cell('FormSelectCell', [
          'name' => 'payment_method',
          'label' => 'Método de Pago',
          'options' => [
            'cash' => 'Efectivo',
            'card' => 'Tarjeta de Débito/Crédito',
            'transfer' => 'Transferencia Bancaria',
          ],
          'default' => 'cash'
        ]) ?>

        <div class="mb-3">
          <label for="records" class="form-label">Registros</label>
          <table class="table text-center" id="table-records">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Categoria</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Acción</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          <button type="button" class="btn btn-primary" onclick="showItemModal()">
            Añadir Elemento
          </button>
          <div class="mt-3">
            <?php $recordsError = validation_show_error('records') ?>
            <?php if ($recordsError): ?>
              <div class="alert alert-danger" role="alert">
                <?= $recordsError ?></div>
            <?php endif; ?>
          </div>
          <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="itemModalLabel">Lista de Elementos</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <table class="table text-center">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">En inventario</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">B/. </span>
          <div class="form-floating">
            <input type="text" class="form-control" value='0.00' readonly id="total" placeholder="Username">
            <label for="total">Total</label>
          </div>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-success">Registrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const formatter = new Intl.NumberFormat('es-PA', {
    style: 'currency',
    currency: 'PAB',
  });

  let isIncome = true;


  /**
   * @type {{'index' : string, id:string, category:string, name:string, type:string, stock:string, money:string}[]}
   */
  const incomes = <?= json_encode($jsIncomes, JSON_UNESCAPED_UNICODE) ?>;
  /**
   * @type {Map<string,{'index' : string, id:string, category:string, name:string, type:string, stock:string, money:string}>}
   */
  const incomesMap = new Map();

  incomes.forEach(e => incomesMap.set(e.id, e));
  /**
   * @type {{'index' : string, id:string, category:string, name:string, type:string, stock:string, money:string}[]}
   */
  const expenses = <?= json_encode($jsExpenses, JSON_UNESCAPED_UNICODE) ?>;

  /**
   * @type {Map<string,{'index' : string, id:string, category:string, name:string, type:string, stock:string, money:string}>}
   */
  const expensesMap = new Map();

  expenses.forEach(e => expensesMap.set(e.id, e));

  /**
   * @type {Map<string,{id:string, category:string, name:string, type:string,stock:number, amount:number, money:number}>}
   */
  const recordsMap = new Map();

  let itemsMap = isIncome ? incomesMap : expensesMap;

  const $totalInput = document.getElementById('total');

  /**@type {HTMLTableElement} */
  const $recordsTable = document.getElementById('table-records');
  const $recordsTBody = $recordsTable.querySelector('tbody');
  /**
   * <th scope="col">Nombre</th>
                  <th scope="col">Categoria</th>
                  <th scope="col">Cantidad</th>
                  <th scope="col">Subtotal</th>
                  <th scope="col">Acción</th>
   */

  function calcRecordSubtotal() {

  }

  function calcRecordtotal() {
    let tol = 0;
    recordsMap.forEach(e => {
      tol += e.amount * e.money;
    });
    console.log("total: ", tol);

    $totalInput.value = tol.toFixed(2);
  }

  function renderTableRecords() {
    $recordsTBody.innerHTML = '';
    recordsMap.forEach((item, key) => {
      const row = $recordsTBody.insertRow();
      let {
        id,
        type,
        category,
        amount,
        money,
        name,
        stock
      } = item;
      const nameCell = row.insertCell();
      nameCell.innerHTML = `
      <span>name</span>
      <input type="hidden" value="${category}" name="records[${id}][category]"/>
      <input type="hidden" value="${id}" name="records[${id}][item_id]"/>
      `;
      nameCell.setAttribute('scope', 'col');
      nameCell.classList.add('text-center');

      const typeCell = row.insertCell();
      typeCell.innerText = type;
      typeCell.setAttribute('scope', 'col');

      const amountInput = document.createElement('input');
      amountInput.type = 'number';
      amountInput.value = amount;
      amountInput.min = 1;
      amountInput.max = stock;
      amountInput.required = true;
      amountInput.name = `records[${key}][amount]`
      amountInput.classList.add('form-control');


      const amountCell = row.insertCell();
      amountCell.setAttribute('scope', 'col');
      amountCell.appendChild(apprendInputGroup(amountInput));

      const subTotalInput = document.createElement('input');
      subTotalInput.type = 'number';
      subTotalInput.value = (amount * money).toFixed(2);
      subTotalInput.min = 1;
      subTotalInput.max = stock;
      subTotalInput.required = true;
      subTotalInput.readOnly = true;
      subTotalInput.classList.add('form-control');
      const subTotalCell = row.insertCell();
      subTotalCell.setAttribute('scope', 'col');
      subTotalCell.appendChild(apprendInputGroup(subTotalInput));

      amountInput.addEventListener('change', (e) => {
        let caclAmount = parseFloat(e.target.value ?? '1');
        if (!caclAmount) caclAmount = 1;
        item.amount = caclAmount;
        subTotalInput.value = (caclAmount * money).toFixed(2);
        calcRecordtotal()
      })

      const actionCell = row.insertCell();
      actionCell.innerHTML = `
                        <button class="btn btn-outline-danger" type="button" onclick="removeItemToRecords('${id}')">
                          <svg class="bi flex-shrink-0" role="img" aria-label="Seleccionar contacto" width="24" height="24">
                            <use xlink:href="#fe-close"/>
                          </svg>
                        </button>
                      `;
    });
    calcRecordtotal();
  }
  /**
   * @param input{HTMLInputElement} 
   * @param spanContent{string} 
   * @return {HTMLDivElement}
   * */
  function apprendInputGroup(input, spanContent = "B/.") {
    //     <div class="input-group mb-3">
    //   <span class="input-group-text" id="basic-addon1">@</span>
    //   <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
    // </div>
    const div = document.createElement('div');
    const span = document.createElement('span');

    div.classList.add('input-group');
    span.classList.add('input-group-text');
    span.innerText = spanContent;
    div.appendChild(span)
    div.appendChild(input)
    return div;
  }

  renderTableRecords();
  const $itemModal = document.getElementById('itemModal');
  /**@type {HTMLTitleElement} */
  const $h1ItemModal = document.getElementById('itemModalLabel');
  const $itemTable = $itemModal.querySelector('table');
  const $itemTBody = $itemTable.querySelector('tbody');

  function renderTableItem() {
    $itemTBody.innerHTML = ''; // Vacía el cuerpo de la tabla
    const items = isIncome ? incomes : expenses;
    $h1ItemModal.textContent = isIncome ? 'Lista de Elementos' : 'Lista de Elementos';
    itemsMap.forEach((item) => {
      const row = $itemTBody.insertRow();
      const {
        id,
        category,
        ...fields
      } = item;
      const values = Object.values(fields);
      values.forEach((value, i) => {
        const cell = row.insertCell();
        cell.textContent = i === values.length - 1 ? formatter.format(value) : value;
        cell.setAttribute('scope', 'col');
        // cell.classList.add('')
      });
      const actionCell = row.insertCell();
      const inRecords = recordsMap.has(id);
      actionCell.innerHTML = `
                        <button class="btn btn-outline-${inRecords?'danger':'primary'}" type="button" onclick="${inRecords?'removeItemToRecords':'addItemToRecords'}('${id}')">
                          <svg class="bi flex-shrink-0" role="img" aria-label="Seleccionar contacto" width="24" height="24">
                            <use xlink:href="#${inRecords?'fe-close':'fe-check'}"/>
                          </svg>
                        </button>
                      `;
    });
  }

  function removeItemToRecords(itemId) {
    if (!itemId || typeof itemId !== 'string') {
      alert('Error el id es invalid');
      return;
    }
    recordsMap.delete(itemId);
    renderTableRecords()
    bootstrap.Modal.getOrCreateInstance($itemModal).hide();
  }

  function addItemToRecords(itemId) {
    if (!itemId || typeof itemId !== 'string') {
      alert('Error el id es invalid');
      return;
    }
    if (!itemsMap.has(itemId)) {
      alert('Error el id es invalid, no exite el item', itemId, 'isImcome: ', isIncome)
      return;
    }
    if (recordsMap.has(itemId)) {
      alert('El Elemento ya esta registrado');
      return;
    }

    const item = itemsMap.get(itemId);

    try {
      recordsMap.set(item.id, {
        index: item.index,
        id: item.id,
        category: item.category,
        name: item.name,
        type: item.type,
        stock: parseFloat(item.stock),
        money: parseFloat(item.money),
        amount: 1
      })

      renderTableRecords()
    } catch (error) {
      console.log("Error:", error);

      alert("No fue posible agregar el Elemento")
    }

    bootstrap.Modal.getOrCreateInstance($itemModal).hide();
  }

  function showItemModal() {
    if (!$itemModal) {
      alert('Error del Modal')
      return;
    }
    renderTableItem();
    bootstrap.Modal.getOrCreateInstance($itemModal).show();
  }


  /**
   * @type {{'index' : string,id : string,name : string,email : string,phone : string,address:string}[]}
   */
  const customers = <?= json_encode($jsCustomers, JSON_UNESCAPED_UNICODE) ?>;
  /**
   * @type {{'index' : string,id : string,name : string,email : string,phone : string,address:string}[]}
   */
  const providers = <?= json_encode($jsProviders, JSON_UNESCAPED_UNICODE) ?>;

  /**@type {HTMLInputElement} */
  const $contactNameInput = document.getElementById('contact_name');
  /**@type {HTMLInputElement} */
  const $contactIdInput = document.getElementById('contact_id');
  const $contacModal = document.getElementById('contactModal');
  /**@type {HTMLTitleElement} */
  const $h1ContacModal = document.getElementById('contactModalLabel');
  const $contactTable = $contacModal.querySelector('table');

  const $contactTBody = $contactTable.querySelector('tbody');
  /**@type {HTMLInputElement} */
  const $typeExposeRadio = document.getElementById('typeExpose');
  /**@type {HTMLInputElement} */
  const $typeIncomeRadio = document.getElementById('typeIncome');

  /**@param e{Event} */
  const radioChange = (e) => {
    if (!$contactIdInput || !$contactNameInput) {
      alert("Elementos inexistente")
      return;
    }

    if (!$typeExposeRadio || !$typeIncomeRadio) {
      alert("Elementos inexistente")
      return;
    }

    if ($typeExposeRadio.checked) {
      isIncome = false;
    } else if ($typeIncomeRadio.checked) {
      isIncome = true;
    } else {
      alert("No hay tipo de cliente Seleccionado");
      typeIncomeRadio.checked = true;
      isIncome = true;
    }

    itemsMap = isIncome ? incomesMap : expensesMap;

    recordsMap.clear();
    renderTableRecords();
    $contactNameInput.value = null;
    $contactIdInput.value = null;
  }

  if ($typeExposeRadio) {
    $typeExposeRadio.addEventListener('change', radioChange);
  }
  if ($typeIncomeRadio) {
    $typeIncomeRadio.addEventListener('change', radioChange);
  }

  function renderTableContacts() {
    $contactTBody.innerHTML = ''; // Vacía el cuerpo de la tabla
    const contacts = isIncome ? customers : providers;
    $h1ContacModal.textContent = isIncome ? 'Lista de Clientes' : 'Lista de Proveedores';
    contacts.forEach((contact, i) => {
      const row = $contactTBody.insertRow();
      const {
        id,
        phone,
        address,
        ...fields
      } = contact;
      Object.values(fields).forEach(value => {
        const cell = row.insertCell();
        cell.textContent = value;
        cell.setAttribute('scope', 'col');
      });
      const actionCell = row.insertCell();

      const selected = id === $contactIdInput?.value;
      actionCell.innerHTML = `
                        <button class="btn ${selected?'btn-primary':'btn-outline-primary'}" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="contactHandlerClick('${id}','${contact.name}')">
                          <svg class="bi flex-shrink-0" role="img" aria-label="Seleccionar contacto" width="24" height="24">
                            <use xlink:href="#fe-check"/>
                          </svg>
                        </button>
                      `;
    });
  }

  function showContactModal() {
    if (!$contacModal) {
      alert('Error del Modal')
      return;
    }
    renderTableContacts();
    bootstrap.Modal.getOrCreateInstance($contacModal).show();
  }

  function contactHandlerClick(contactId, contactName) {
    if (!contactId || typeof contactId !== 'string' || !$contactIdInput) {
      alert('Error el id es invalid');
      return;
    }
    if (!contactName || typeof contactName !== 'string' || !$contactNameInput) {
      alert('Error el nombre es invalid');
      return;
    }
    $contactIdInput.value = contactId;
    // $contactNameInput.setAttribute('readonly', false);
    $contactIdInput.value = contactId;
    $contactNameInput.value = contactName;
    // $contactNameInput.setAttribute('readonly', true);
  }
</script>
<!-- <script src="/assets/js/table-dialogs.js"></script> -->
<!-- <script src="/assets/js/transaction-table-modal.js"></script> -->
<?= $this->endSection() ?>