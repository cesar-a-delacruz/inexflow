<nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" class="text-dark rounded-1 p-lg-3 d-flex align-items-center">
    <ol class="breadcrumb mb-0">
        <?php
        $segments = service('uri')->getSegments();
        $url = '';
        $last = count($segments) - 1;

        $normalice = [
            'supplies' => 'Suministros',
            'products' => 'Productos',
            'new' => 'Nuevo',
            'edit' => 'Editar',
            'providers' => 'Proveedores',
            'customers' => 'Clientes',
            'transactions' => 'Transacciones',
            'business' => 'Negocio',
            'dashboard' => 'Dashboard',
            'user' => 'Usuario',
            'tenants' => 'Negocio',
            'employees' => 'Empleados',
        ];
        ?>

        <div class="breadcrumb-item"></div>
        <?php foreach ($segments as $i => $segment): ?>
            <?php $url .= '/' . $segment; ?>
            <?php $name = ($normalice[$segment] ?? esc($segment)); ?>

            <?php if ($i === $last): ?>
                <li class="breadcrumb-item active" aria-current="page"><?= $name ?></li>
            <?php else: ?>
                <li class="breadcrumb-item"><a href="<?= base_url($url) ?>"><?= $name ?></a></li>
            <?php endif ?>
        <?php endforeach ?>
    </ol>
</nav>