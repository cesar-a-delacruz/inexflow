<?php helper('breadcrumb') ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>INEXflow - <?= $title ?></title>
  <!-- bootstrap -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous" defer></script>
  <!-- data table -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js" defer></script>
  <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js" defer></script>
  <!-- css y javascript personalizado -->
  <!-- <link rel="stylesheet" href="/assets/css/style.css"> -->


  <script src="/assets/js/data-table.js" defer></script>
  <link href="https://fonts.googleapis.com/css2?family=Anta&display=swap" rel="stylesheet">
  <script src="/assets/js/view-transition.js"></script>
</head>

<body class="bg-secondary-subtle vh-100">
  <style>
    * {
      scrollbar-width: thin;
    }
  </style>
  <div class="container-fluid">
    <div class="row">

      <aside class="col-12 col-sm-4 col-md-3 col-lg-2 p-3 ps-4 d-flex flex-column gap-4 bg-white text-dark">
        <header>
          <h1 class="h3">INEXflow</h1>
        </header>

        <?= view('components/nav') ?>

        <footer class="">
          <a type="button" class="btn btn-outline-primary btn-md d-flex align-items-center gap-2 " href="/logout">
            <svg class="bi flex-shrink-0" role="img" width="24" height="24">
              <use href="/assets/svg/navSprite.svg#fe-logout" />
            </svg>
            <span>Cerrar Sesión</span>
          </a>
        </footer>
      </aside>


      <main class="col-12 col-sm-8 col-md-9 col-lg-10 p-4 vh-100 overflow-y-auto">
        <h1 class="mb-1"><?= $title ?></h1>
        <?= view('components/breadcrumb') ?>
        <div class="bg-white p-4 rounded-4">
          <?= $this->renderSection('content') ?>
        </div>
      </main>

    </div>
  </div>

</html>