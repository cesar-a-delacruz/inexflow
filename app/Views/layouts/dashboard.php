<?php helper('bread_crumb') ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>INEXflow C1: <?= $title ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous" defer></script>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="vh-100 mw-vw-100">
  <nav class="navbar navbar-light bg-light p-3 h-10 w-100">
    <div class="d-flex col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
      <a class="navbar-brand" href="">INEXflow C1</a>
    </div>
    <div class="col-lg-4">
      <input class="form-control form-control-dark" type="text" placeholder="Buscar" aria-label="Search">
    </div>
    <div class="col-lg-4 d-flex align-items-center justify-content-md-end mt-3 mt-md-0 me">
      <div class="dropdown-center">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">Opciones</button>
        <ul class="dropdown-menu" style="right: 0; left: unset;" aria-labelledby="dropdownMenuButton">
          <li>
            <a class="dropdown-item" href="/logout">Cerrar Sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container-fluid h-100">
    <div class="row h-100">
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light py-lg-3 border-end">
        <div class="position-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="#" id="sidebarDropdown" role="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg> 
                <?= session()->get('name') ?>
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <main class="col-lg-10 px-md-4 py-4">
        <!-- renderisamos la funcion miga de pan que viene del helper -->
        <?= render_breadcrumb(); ?>
        <?= $this->renderSection('content') ?>
      </main>
    </div>
  </div>
</body>
</html>
