<nav class="nav nav-pills flex-column gap-2">
    <?php
    $segments1 = service('uri')->getSegment(1);
    $segments2 = service('uri')->getSegment(2);
    $username = session()->get('name') ?? 'No tiene nombre';
    $links = [
        [
            'href' => '/profile',
            'svg' => 'fe-user',
            'label' => $username,
            'active' => $segments1 === 'profile',
        ],
    ];
    if (session()->get('role') === 'admin') {
        $links[] = [
            'href' => '/admin/users',
            'svg' => 'fe-users',
            'label' => 'Usuarios',
            'active' => $segments2 === 'users',
        ];
    } else {
        array_push(
            $links,
            [
                'href' => '/tenants/dashboard',
                'svg' => 'fe-layout',
                'label' => 'Dashboard',
                'active' => $segments2 === 'dashboard',
            ],
            [
                'href' => '/tenants/business',
                'svg' => 'fe-bar-chart',
                'label' => 'Negocio',
                'active' => $segments2 === 'business',
            ],
            [
                'href' => '/tenants/transactions',
                'svg' => 'fe-boock',
                'label' => 'Transacciones',
                'active' => $segments2 === 'transactions',
            ],
            [
                'href' => '/tenants/products',
                'svg' => 'fe-layer',
                'label' => 'Productos',
                'active' => $segments2 === 'products',
            ],
            [
                'href' => '/tenants/supplies',
                'svg' => 'fe-layer',
                'label' => 'Suministros',
                'active' => $segments2 === 'supplies',
            ],
            [
                'href' => '/tenants/contacts',
                'svg' => 'fe-users',
                'label' => 'Contactos',
                'active' => $segments2 === 'contacts',
            ],
        );
    }
    ?>
    <?php foreach ($links as $link): ?>
        <a class="nav-link <?= $link['active'] ? 'active' : null ?>" <?= $link['active'] ? 'aria-current="page"' : null ?> href="<?= $link['active'] ? '#' : $link['href'] ?>">
            <svg class="bi flex-shrink-0" role="img" width="24" height="24">
                <use href="/assets/svg/navSprite.svg#<?= $link['svg'] ?>" />
            </svg>
            <?= $link['label'] ?>
        </a>
    <?php endforeach; ?>
</nav>