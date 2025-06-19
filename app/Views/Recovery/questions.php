<?= $this->extend('layouts/default')?>

<?= $this->section('content')?>

 <div class="container mt-5">
        <div class="card shadow p-4">
            <h4 class="mb-4 text-center">Responde las preguntas de seguridad</h4>
            <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>
            <form action="<?= base_url('questionsverify') ?>" method="post">
                <div class="mb-3">
                    <label class="form-label">¿Cuál es el nombre de tu primera mascota?</label>
                    <input type="text" name="respuesta1" class="form-control" >
                </div>
                <div class="mb-3">
                    <label class="form-label">¿En qué ciudad naciste?</label>
                    <input type="text" name="respuesta2" class="form-control" >
                </div>
                <div class="mb-3">
                    <label class="form-label">¿Cuál es tu comida favorita?</label>
                    <input type="text" name="respuesta3" class="form-control" >
                </div>
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('/') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Verificar</button>
                </div>
            </form>
        </div>
    </div>

<?= $this->endSection()?>