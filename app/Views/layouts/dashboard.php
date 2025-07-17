<?php helper('breadcrumb') ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>INEXflow C1: <?= $title ?></title>
  <!-- bootstrap -->
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
  <link rel="stylesheet" href="/assets/css/style.css">
  <script src="/assets/js/data-table.js" defer></script>
</head>
<body class="vh-100 mw-vw-100">
  <nav class="navbar navbar-light bg-light p-3 h-10 w-100">
    <div class="d-flex col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
      <a class="navbar-brand" href="">INEXflow C1</a>
    </div>
    <div class="col-lg-4">
      <input class="form-control form-control-dark" type="text" placeholder="Buscar" aria-label="Search">
    </div>
    <div class="col-lg-4 d-flex align-items-center justify-content-md-end mt-3 mt-md-0 me-lg-4">
      <div class="dropdown-center">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">Opciones</button>
        <ul class="dropdown-menu" style="left: -25%;" aria-labelledby="dropdownMenuButton">
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
              <a class="nav-link" href="/user" role="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg> 
                <?= session()->get('name') ?>
              </a>
            </li>
            <?php if (session()->get('role') == 'admin'): ?>
              <li class="nav-item">
                <a class="nav-link" href="/users" role="button">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list">
                    <line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line>
                    <line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line>
                    <line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line>
                  </svg>
                  Usuarios
                </a>
              </li>
              <?php else: ?>
                <li class="nav-item">
                  <a class="nav-link" href="/business" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase">
                      <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                      <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                    Negocio
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/transactions" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                      <line x1="12" y1="1" x2="12" y2="23"></line>
                      <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                    Transacciones
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/items" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard">
                      <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                      <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                    </svg>
                    Items
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/contacts" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                      <circle cx="9" cy="7" r="4"></circle>
                      <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                      <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    Contactos
                  </a>
                </li>
              <?php endif; ?>
          </ul>
        </div>
      </nav>
      <main class="col-lg-10 px-md-4 py-4">
        <?= render_breadcrumb(); ?>
        <?= $this->renderSection('content') ?>
      </main>
    </div>
  </div>
</body>
</html>
