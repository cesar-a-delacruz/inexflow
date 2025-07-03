<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <h1 class="mb-4"><?= $title ?></h1>
  <button type="button" class="btn btn-primary">Registrar transacciones</button>

  <div class="table-responsive" >
    <table id="showtable" class="table table-striped table-hover table-bordered">
      <thead class="table-dark">
        <tr>
          <th>Id</th>
          <th>Categoría</th>
          <th>Monto</th>
          <th>Descripción</th>
          <th>Fecha</th>
          <th>Método de pago</th>
          <th>Notas</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>101</td>
          <td>$120.00</td>
          <td>Compra en tienda</td>
          <td>2025-06-10</td>
          <td>Cash</td>
          <td>Pagos al Contado</td>
          <td>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-success btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </button>
            </div>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>102</td>
          <td>$85.50</td>
          <td>Transferencia bancaria</td>
          <td>2025-06-11</td>
          <td>Transferencia</td>
          <td>Pagado por transferencia</td>
          <td>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-success btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </button>
            </div>
          </td>
        </tr>
        <tr>
          <td>3</td>
          <td>103</td>
          <td>$99.50</td>
          <td>Ventas al contado</td>
          <td>2025-06-11</td>
          <td>Transferencia</td>
          <td>Pagado por transferencia</td>
          <td>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-success btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </button>
            </div>
          </td>
        </tr>
        <tr>
          <td>4</td>
          <td>104</td>
          <td>$100.00</td>
          <td>Ingreso</td>
          <td>2025-06-11</td>
          <td>Transferencia</td>
          <td>Asesorías</td>
          <td>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-success btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </button>
            </div>
          </td>
        </tr>
        <tr>
          <td>5</td>
          <td>105</td>
          <td>$12.00</td>
          <td>Transporte</td>
          <td>2025-03-16</td>
          <td>Efectivos </td>
          <td>Transporte público</td>
          <td>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-success btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </button>
            </div>
          </td>
        </tr>
        <tr>
          <td>6</td>
          <td>106</td>
          <td>$123.00</td>
          <td>Consultas médicas</td>
          <td>2025-04-13</td>
          <td>Tarjetas de crédito</td>
          <td>Consulta médicas</td>
          <td>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-success btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </button>
            </div>
          </td>
        </tr>
        <tr>
          <td>7</td>
          <td>107</td>
          <td>$140.00</td>
          <td>Renta mensual</td>
          <td>2025-04-15</td>
          <td>Tarjetas de crédito</td>
          <td>Vivienda</td>
          <td>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-success btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </button>
            </div>
          </td>
        </tr>
        <tr>
          <td>8</td>
          <td>108</td>
          <td>$150.00</td>
          <td>Entretenimiento</td>
          <td>2025-04-14</td>
          <td>Pago contado</td>
          <td>Entretenimiento</td>
          <td>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-success btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </button>
            </div>
          </td>
        </tr>
        <tr>
          <td>9</td>
          <td>109</td>
          <td>$140.00</td>
          <td>Gasto domiciliario</td>
          <td>2025-03-14</td>
          <td>Pago contado</td>
          <td>Gastos de oficina</td>
          <td>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-success btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </button>
            </div>
          </td>
        </tr>
        <tr>
          <td>10</td>
          <td>110</td>
          <td>$130.00</td>
          <td>Gasto de oficina</td>
          <td>2025-03-18</td>
          <td>Cash </td>
          <td>Pago de luz y agua</td>
          <td>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-success btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </button>
            </div>
          </td>
        </tr>
        <tr>
          <td>11</td>
          <td>130</td>
          <td>$50.00</td>
          <td>Gasto diarios</td>
          <td>2025-03-18</td>
          <td>Cash </td>
          <td>Pago de basura</td>
          <td>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-success btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>
