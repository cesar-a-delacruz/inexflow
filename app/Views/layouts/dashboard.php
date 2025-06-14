<?php helper('bread_crumb') ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous" defer></script>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
  <nav class="navbar navbar-light bg-light p-3">
    <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
      <a class="navbar-brand" href="">INEXflow C1</a>
      <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
    <div class="col-12 col-md-4 col-lg-2">
      <input class="form-control form-control-dark" type="text" placeholder="Search" aria-label="Search">
    </div>
    <div class="col-12 col-md-5 col-lg-8 d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
      <div class="mr-3 mt-1"></div>
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">Opciones</button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li>
            <a class="dropdown-item" href="/logout">Cerrar Sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky">
          <ul class="nav flex-column">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="sidebarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line>
              </svg> Admisnitrador
              </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarDropdown">
              <li><a class="dropdown-item" href="<?php echo base_url("/inexflow-c1/public/user/dashboard")?>">Editar roles</a></li>
                <li><a class="dropdown-item" href="#">Ingresar roles</a></li>
            </ul>
          </li>
        <!-- fin dropdown -->
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url("/inexflow-c1/public/user/traders")?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-arrow-down-circle"><circle cx="12" cy="12" r="10">
                  </circle><polyline points="8 12 12 16 16 12"></polyline>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                </svg>
                <span class="ml-2">Egresos</span>
              </a>
              <!-- ingresos  -->
              <a class="nav-link" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line>
                  <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
                <span class="ml-2">Ingresos</span>
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
        <!-- renderisamos la funcion miga de pan que viene del helper -->
        <?= render_breadcrumb(); ?>
        <?= $this->renderSection('content') ?>
      </main>
    </div>
  </div>
</body>
</html>
