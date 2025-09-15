<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<?php

use App\Enums\ItemType;
?>
<div class="d-flex align-items-center gap-2">
    <a href="/tenants/<?= $segment . '/' . $item->id ?>/edit" class="btn btn-outline-primary d-flex gap-1 align-items-center float-none">
        Editar
        <svg class="bi flex-shrink-0" role="img" width="20" height="20">
            <use href="/assets/svg/miscellaniaSprite.svg#fe-edit" />
        </svg>
    </a>
</div>

<pre>
    <?php print_r($item); ?>
</pre>

<?= $this->endSection() ?>