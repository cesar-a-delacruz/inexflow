// abrir cualquier dialogo
function openDialog(element, event, dataset) {
    event.preventDefault()
    
    const headings = document.querySelectorAll('dialog h5');
    const type = document.querySelector('input[name="type"]:checked');
    headings.forEach(heading => {
        heading.innerHTML = type ? 'Elige un registro (Haz click en una fila)' : 'Selecciona el Tipo de Factura primero';
    });

    document.querySelector(`dialog.${dataset}`).showModal(); 
}
// mostrar tablas de todos los dialogos segun el tipo de factura
const typeRadios = document.querySelectorAll('input[name="type"]');
const tables = document.querySelectorAll('dialog table');
typeRadios.forEach(radio => {
    radio.addEventListener('change', () => {
        tables.forEach(table => {
            table.style.display = radio.value === table.classList[0]
            ? 'table' : 'none';
        })
        typeRadios.forEach(radio => radio.disabled = true);
    })
});
// pasar datos de las tablas en el dialogo de contactos al input de contactos
const contactsTables = document.querySelectorAll('dialog.contacts table');
contactsTables.forEach(table => {
    const tbody = table.children[2].children;
    for (const row of tbody) {
        row.addEventListener('click', () => {
            const contactInput = document.querySelector('form input.contact');
            const contactIdInput = document.querySelector('form input[name="contact_id"]');
            
            const cells = {
                name: row.children[1].innerHTML,
                address: row.children[4].innerHTML
            };
            const contactId = row.dataset.id;

            contactInput.value = `${cells.name} | ${cells.address}`;
            contactIdInput.value = contactId;
        })
    }
});
// crear fila en tabla de transacciones con datos de las tablas de items
const formTableTbody = document.querySelector('form table tbody');
const itemsTables = document.querySelectorAll('dialog.items table');
itemsTables.forEach(table => {
    const tbody = table.children[2].children;
    for (const row of tbody) {
        // al hacer click en la fila la tabla items de se crea la fila de transacciones
        row.addEventListener('click', () => {
            const transactionIndex = formTableTbody.children.length;
            const amount = row.children[4].innerHTML;
            const invoiceType = document.querySelector('input[name="type"]:checked').value;

            const inputs = {
                amount: document.createElement('input'),
                subtotal: document.createElement('input'),
            }
            for (const input in inputs) {
                inputs[input].type = 'number';
            }

            inputs.amount.name = `transactions[${transactionIndex}][amount]`;
            inputs.amount.className = 'amount form-control';
            inputs.amount.step = '1';

            // llenar inputs dependiendo si el item es servicio o producto
            const itemType = row.children[3].innerHTML;
            if (itemType === 'Servicio') {
                // si es servicio no se usa el campo cantidad y se llena el subtotal y toal con el monto
                const money = row.children[5].innerHTML.replace('$', '');
                const totalInput = document.querySelector('input[name="total"]');

                inputs.amount.disabled = true;
                inputs.subtotal.value = parseFloat(money).toFixed(2);

                totalInput.value = (parseFloat(totalInput.value || 0) + parseFloat(inputs.subtotal.value)).toFixed(2);
            } else {
                //si es producto la cantidad tiene limite y al cambiar se calcula el subtotal y total
                inputs.amount.min = '1';
                if (invoiceType === 'income') inputs.amount.max = amount;

                inputs.amount.addEventListener('change', () => {
                    const transactionRow = inputs.amount.parentElement.parentElement;
                    const moneyCell = document.querySelector(`dialog table.${invoiceType} tbody ` +
                        `tr[data-index="${transactionRow.dataset.index}"] td.money`); 
                    const money = parseFloat(moneyCell.innerHTML.replace('$', '')).toFixed(2);

                    inputs.subtotal.value = (parseInt(inputs.amount.value) * money).toFixed(2);
                    inputs.subtotal.dispatchEvent(new Event("change"));
                });
            }

            inputs.subtotal.name = `transactions[${transactionIndex}][subtotal]`;
            inputs.subtotal.className = 'subtotal form-control';
            inputs.subtotal.readOnly = true;
            inputs.subtotal.addEventListener('change', () => calculateTotal());

            const cells = {
                category: row.children[1],
                description: row.children[2],
            }
            
            // colocar elementos en la nueva fila en la tabla de transacciones
            const transactionRow = document.createElement('tr');
            transactionRow.dataset.index = row.dataset.index;
            const transactionContent = [cells.category, cells.description, inputs.amount, inputs.subtotal];

            for (const content of transactionContent) {
                if (content.tagName === 'INPUT') {
                    const cell = document.createElement('td');
                    cell.append(content);
                    transactionRow.append(cell);
                } else {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `transactions[${transactionIndex}][${content.className}]`;
                    input.value = content.innerHTML;
                    const dataClone = content.cloneNode(true);
                    dataClone.append(input);
                    transactionRow.append(dataClone);
                }
            }
            // celda de eliminar fila con boton
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
                const transactionRow = removeButton.parentElement.parentElement;
                const hiddenRow = document.querySelector(`dialog table.${invoiceType} tbody `+
                    `tr[data-index="${transactionRow.dataset.index}"]`); 
                hiddenRow.style.display = 'table-row';
                transactionRow.remove();
                calculateTotal();
            });
            removeCell.append(removeButton);
            transactionRow.append(removeCell);
            formTableTbody.append(transactionRow);
            row.style.display = 'none';
        })
    }
});
// calcular valor del total
function calculateTotal() {
    const totalInput = document.querySelector('input[name="total"]');
    const subtotals = document.querySelectorAll('form table tbody input.subtotal');
    let total = 0;
    subtotals.forEach(subtotal => {
        total = total + parseFloat(subtotal.value || 0)
    })
    totalInput.value = total.toFixed(2);
}