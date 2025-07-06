<?= $this->extend('layouts/default')?>

<?= $this->section('content')?>
<section class="h-100">
	<div class="container h-100">
		<div class="row justify-content-sm-center h-100">
			<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
				<div class="card shadow-lg">
					<div class="card-body p-5">
						<h1 class="fs-4 card-title fw-bold mb-4"><?= $title?></h1>

						<?php if (!empty(validation_errors())): ?>
                            <div class="alert alert-danger"><?= validation_list_errors() ?></div>
                        <?php endif; ?>

						<form method="POST" action="/recovery" class="needs-validation" novalidate>
							<div class="mb-3">
								<label class="mb-2 text-muted" for="password-confirm">Introduzca su Correo</label>
								<input id="email" type="email" 
								class="form-control <?= !validation_show_error('email') ? 'is-invalid' : '' ?>" name="email">
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