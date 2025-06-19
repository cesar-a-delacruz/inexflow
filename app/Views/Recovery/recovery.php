<?= $this->extend('layouts/default')?>

<?= $this->section('content') ?>


 <div class="container d-flex justify-content-center pt-5" style="min-height: 50vh;">
        <div class="card shadow p-4 w-100" style="max-width: 400px;">
            
            <div class="text-center mb-4">
                <h2 class="fw-bold">Restablecer su acceso</h2>
                </div>
        <br> 
      <div class="d-grid gap-3">
    <button class="btn btn-outline-primary d-flex justify-content-between align-items-center" id="emailOption">
        <span class="icon">📧</span>
        <span class="text">Recuperar por email</span>
        <span class="arrow">›</span>
    </button>  
    <a class="btn btn-outline-primary d-flex justify-content-between align-items-center" id="prgOption" href="<?= base_url('questions')?>">
        <span class="icon">📄​</span>
        <span class="text">Preguntas de Seguridad</span>
        <span class="arrow">›</span>
</a>
</div>
  

        
    </div>

    </div>
       

<?= $this->endSection()?>