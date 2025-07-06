<?= $this->extend('layouts/default')?>

<?= $this->section('content')?>
 <div class="container mt-5">
        <div class="card shadow p-4">
            <h1 class="mb-4 card-header text-center bg-primary text-white"><?= $title ?></h1>

            <?php if (!empty(validation_errors())): ?>
                <div class="alert alert-danger"><?= validation_list_errors() ?></div>
            <?php endif; ?>

            <form action="/token" method="POST">
                <div class="mb-3">
                    <label class="form-label" for="token">Introduzca el código que se le envió a su correo</label>
                    <input type="text" name="token" id="token" class="form-control">
                </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="/" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Verificar</button>
                </div>
            </form>
        </div>
    </div>
<?= $this->endSection()?>