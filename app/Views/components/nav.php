<nav class="nav nav-pills flex-column gap-2">
    <?php
    $segments = service('uri')->getSegment(1);
    $username = session()->get('name') ?? 'No tiene nombre';
    $links = [
        [
            'href' => '/user',
            'svg' => 'fe-user',
            'label' => $username,
            'active' => $segments === 'user',
        ],
    ];
    if (session()->get('role') === 'admin') {
        $links += [
            'href' => '/users',
            'svg' => 'fe-users',
            'label' => 'Usuarios',
            'active' => $segments === 'users',
        ];
    } else {
        array_push(
            $links,
            [
                'href' => '/dashboard',
                'svg' => 'fe-layout',
                'label' => 'Dashboard',
                'active' => $segments === 'dashboard',
            ],
            [
                'href' => '/business',
                'svg' => 'fe-bar-chart',
                'label' => 'Negocio',
                'active' => $segments === 'business',
            ],
            [
                'href' => '/transactions',
                'svg' => 'fe-boock',
                'label' => 'Transacciones',
                'active' => $segments === 'transactions',
            ],
            [
                'href' => '/items',
                'svg' => 'fe-layer',
                'label' => 'Elementos',
                'active' => $segments === 'items',
            ],
            [
                'href' => '/contacts',
                'svg' => 'fe-users',
                'label' => 'Contactos',
                'active' => $segments === 'contacts',
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