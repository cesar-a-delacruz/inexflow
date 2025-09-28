<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>
                    <form method="POST" action="/auth/login" class="needs-validation" novalidate>
                        <?php $emailValid = !!validation_show_error('email') ?>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control <?= $emailValid ? 'is-invalid' : null ?>" require
                                value="<?= !validation_show_error('email') ? set_value('email') : null ?>"
                                id="email" name="email" placeholder="name@example.com">
                            <label for="email">Correo</label>
                            <?php if ($emailValid): ?>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('email') ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <?php $passValid = !!validation_show_error('password') ?>
                        <div class="form-floating mb-3 ">
                            <input type="password" class="form-control <?= $passValid ? 'is-invalid' : null ?>" require id="password" name="password">
                            <label for="password">Contraseña</label>
                            <?php if ($passValid): ?>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('password') ?>
                                </div>
                            <?php endif ?>
                        </div>

                        <div class="d-flex justify-content-end mb-3">
                            <a href="#" class="text-decoration-none">¿Olvidó su contraseña?</a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">Acceder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="img-bg"></div>
<style>
    .img-bg {
        position: absolute;
        inset: 0px;
        z-index: -10;
        background-image: url("/assets/img/login-bg.avif");
        background-position: center;
        background-repeat: no-repeat;
        filter: blur(2px);
        background-size: 100%;
    }
</style>
<?= $this->endSection() ?>