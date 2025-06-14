<?php
helper('reset');
$email = '';
$errores_email = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = $_POST['email'] ?? '';
	// Llamar a la función del helper
	$errores_email = validar_email($email);
	// si la validacion es correcta limpia el campo
	if (empty($errores_email)) {
		$email = '';
	}
}
?>
<?= $this->extend('layouts/default')?>

<?= $this->section('content')?>
<section class="h-100">
	<div class="container h-100">
		<div class="row justify-content-sm-center h-100">
			<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
				<div class="card shadow-lg">
					<div class="card-body p-5">
						<h1 class="fs-4 card-title fw-bold mb-4"><?= $title?></h1>
						<form method="POST" action="" class="needs-validation" novalidate="" autocomplete="off">
							<div class="mb-3">
								<label class="mb-2 text-muted" for="password-confirm">Introduzca su Correo</label>
								<input id="email" type="email" class="form-control <?= !empty($errores_email) ? 'is-invalid' : '' ?>" 
								name="email" required value="<?= htmlspecialchars($email) ?>">
								<div class="invalid-feedback">
									<!-- validando los email -->
									<?php if (!empty($errores_email)): ?>
										<?php foreach ($errores_email as $error): ?>
											<p><?= htmlspecialchars($error) ?></p>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>
							<button type="submit" class="btn btn-primary ms-auto">
								Recuperar
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?= $this->endSection()?>