
<?php
helper('reset');
$password = '';
$email = '';
$errores = [];
$errores_password = [];
$errores_email = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $password = $_POST['password'] ?? '';
  $email = $_POST['email'] ?? '';
// Llamar a la función del helper
  $errores_password = validar_contraseña($password);
  $errores_email = validar_email($email);
// si la validacion es correcta limpia el campo
  if (empty($errores_password) && empty($errores_email)) {
    $password = '';
    $email = '';
 // Aquí puedes hacer redirección si quieres
 // header('Location: success.php'); exit;

}
    }

?>
<!-- validando el boton mostrar y ocultar contraseña -->
<script>
function togglePassword() {
  const passwordInput = document.getElementById('password');
  const showPasswordCheckbox = document.getElementById('showPassword');

  passwordInput.type = showPasswordCheckbox.checked ? 'text' : 'password';
  if (showPasswordCheckbox.checked) {
    passwordInput.type = 'text';
    eyeIcon.classList.remove('bi-eye-slash');
    eyeIcon.classList.add('bi-eye');
    eyeLabel.textContent = 'Ocultar contraseña';
  } else {
    passwordInput.type = 'password';
    eyeIcon.classList.remove('bi-eye');
    eyeIcon.classList.add('bi-eye-slash');
    eyeLabel.textContent = 'Ver contraseña';
  }
}
</script>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="This is a login page template based on Bootstrap 5">
	<title>Resetear contraseña</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<!-- <img src="" alt="logo" width="100"> -->
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Resetear Contraseña</h1>
							<form method="POST" action="" class="needs-validation" novalidate="" autocomplete="off">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="password">Nueva Contraseña</label>
									<input id="password" type="password" class="form-control <?= !empty($errores_password) ? 'is-invalid' : '' ?>" name="password" value="<?= htmlspecialchars($password) ?>" required autofocus>
									<div class="invalid-feedback">
										<!-- validando el password ingresado -->
                    <?php if (!empty($errores_password)): ?>
                       <?php foreach ($errores_password as $error): ?>
                             <p><?= htmlspecialchars($error) ?></p>
                           <?php endforeach; ?>
                    <?php endif; ?>

									</div>
								</div>

								<div class="mb-3">
									<label class="mb-2 text-muted" for="password-confirm">Introduzca su Email</label>
									  <input id="email" type="email" class="form-control <?= !empty($errores_email) ? 'is-invalid' : '' ?>" name="email" required value="<?= htmlspecialchars($email) ?>">
								      <div class="invalid-feedback">
                        <!-- validando los email -->
                        <?php if (!empty($errores_email)): ?>
                           <?php foreach ($errores_email as $error): ?>
                             <p><?= htmlspecialchars($error) ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
							    	</div>
								</div>

								<div class="d-flex align-items-center">
									<div class="form-check">
										<input name="showPassword" type="checkbox" name="logout_devices" id="showPassword" class="form-check-input" onclick="togglePassword()">
										 <label id="label" for="logout" class="form-check-label">
                       <i id="eyeIcon" class="bi bi-eye-slash"></i>
                        <span id="eyeLabel">Ver contraseña</span>
                    </label>
									</div>
									<button type="submit" class="btn btn-primary ms-auto">
										Reset Password
									</button>
								</div>
							</form>
						</div>
					</div>
					<div class="text-center mt-5 text-muted">

					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
