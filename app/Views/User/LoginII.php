<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>
                        
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>

                        <form method="post" action="<?= base_url('login')?>">
                            <?= csrf_field() ?>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Nombre de usuario</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="passw" required>
                            </div>
                            
                            <div class="d-flex justify-content-end mb-3">
                                <a href="<?= base_url('recovery')?>" class="text-decoration-none">¿Olvidó su contraseña?</a>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 py-2">Acceder</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?= $this->endSection()?>
