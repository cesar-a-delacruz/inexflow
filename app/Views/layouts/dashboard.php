<!-- llamando un helper -->
<?php helper('BreabCrumb'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->renderSection('titulo') ?></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-2.3.2/datatables.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

     <link rel="stylesheet" href="<?php echo base_url('inexflow-c1/public/assets/css/style.css') ?>">
  </head>
  <body>

    <nav class="navbar navbar-light bg-light p-3">
      <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
        <a class="navbar-brand" href=""> Emprendedores </a>
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
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"> Administrador, Alvin Gil</button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <!-- <li><a class="dropdown-item" href="#">Settings</a></li> -->
            <!-- <li><a class="dropdown-item" href="#">Messages</a></li> -->
            <li>
              <a class="dropdown-item" href="#">Sign out</a>
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
            <!-- <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?php echo base_url("/inexflow-c1/public/user/dashboard")?>">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line>
                  </svg>
                  <span class="ml-2">Administrador </span>
                </a>
              </li> -->
              <!-- prueba -->
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
                <!-- prueba -->

            <!-- fin dropdown -->

              </li>

            </ul>
          </div>
        </nav>
        <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
          <!-- contenido principal -->
          <!-- renderisamos la funcion miga de pan que viene del helper -->
          <?= render_dynamic_breadcrumb(); ?>
          <!-- aqui va todo el contenido  -->
          <?php echo $this->renderSection('contenido') ?>
          <!-- fin contenido  -->
        </main>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.3.2/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <script src="<?php echo base_url("/inexflow-c1/public/assets/js/table.js")?>"></script>

  </head>
  <body>
    <!-- <script>
      $(document).ready(function(){
        $('#showtable').DataTable();
      });
    </script> -->

    <!-- Github buttons -->
  </body>
</html>
