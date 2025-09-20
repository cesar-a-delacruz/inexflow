<?php
$segments1 = service('uri')->getSegment(1);
$segments2 = service('uri')->getSegment(2);
$username = session('user_name') ?? 'No tiene nombre';

$links = [
    [
        'href' => '/profile',
        'svg' => 'fe-user',
        'label' => $username,
        'active' => $segments1 === 'profile',
    ],
];

$sections = [];

if (session()->get('role') === 'admin') {
    $links[] = [
        'href' => '/admin/users',
        'svg' => 'fe-users',
        'label' => 'Usuarios',
        'active' => $segments2 === 'users',
    ];
} else {
    // array_push(
    //     $links,


    // );
    $sections = [
        [
            'label' => 'Gestión del negocio',
            'links' => [
                // [
                //     'href' => '/tenants/dashboard',
                //     'svg' => 'fe-layout',
                //     'label' => 'Dashboard',
                //     'active' => $segments2 === 'dashboard',
                // ],
                [
                    'href' => '/tenants/business',
                    'svg' => 'fe-bar-chart',
                    'label' => 'Negocio',
                    'active' => $segments2 === 'business',
                ],
                [
                    'href' => '/tenants/employees',
                    'svg' => 'fe-users',
                    'label' => 'Empleados',
                    'active' => $segments2 === 'employees',
                ],
                [
                    'href' => '/tenants/purchase',
                    'svg' => 'fe-boock',
                    'label' => 'Compras',
                    'active' => $segments2 === 'purchase',
                ],
                [
                    'href' => '/tenants/orders',
                    'svg' => 'fe-boock',
                    'label' => 'Ordenes',
                    'active' => $segments2 === 'orders',
                ],
            ]
        ],
        [
            'label' => 'Gestión de recursos',
            'links' => [
                [
                    'href' => '/tenants/products',
                    'svg' => 'fe-layer',
                    'label' => 'Productos',
                    'active' => $segments2 === 'products',
                ],
                [
                    'href' => '/tenants/expense-services',
                    'svg' => 'fe-apron',
                    'label' => 'Servicio-salida',
                    'active' => $segments2 === 'expense-services',
                ],
                [
                    'href' => '/tenants/supplies',
                    'svg' => 'fe-codepen',
                    'label' => 'Suministros',
                    'active' => $segments2 === 'supplies',
                ],
                [
                    'href' => '/tenants/customers',
                    'svg' => 'fe-users',
                    'label' => 'Clientes',
                    'active' => $segments2 === 'customers',
                ],
                [
                    'href' => '/tenants/providers',
                    'svg' => 'fe-truck',
                    'label' => 'Proveedores',
                    'active' => $segments2 === 'providers',
                ],
                [
                    'href' => '/tenants/income-services',
                    'svg' => 'fe-money',
                    'label' => 'Servicio-entrada',
                    'active' => $segments2 === 'income-services',
                ],
            ]
        ]
    ];
}
?>
<nav class="nav nav-pills flex-column">
    <?php foreach ($links as $link): ?>
        <a class="nav-link my-1 <?= $link['active'] ? 'active' : null ?>" <?= $link['active'] ? 'aria-current="page"' : null ?> href="<?= $link['active'] ? '#' : $link['href'] ?>">
            <svg class="bi flex-shrink-0" role="img" width="24" height="24">
                <use href="/assets/svg/navSprite.svg#<?= $link['svg'] ?>" />
            </svg>
            <?= $link['label'] ?>
        </a>
    <?php endforeach; ?>
    <hr class="border border-primary border-1 my-1 opacity-75">
    <?php foreach ($sections as $section): ?>
        <!-- <p class="text-primary small m-0"><?= $section['label'] ?></p> -->
        <?php foreach ($section['links'] as $link): ?>
            <a class="nav-link my-1 <?= $link['active'] ? 'active' : null ?>" <?= $link['active'] ? 'aria-current="page"' : null ?> href="<?= $link['active'] ? '#' : $link['href'] ?>">
                <svg class="bi flex-shrink-0" role="img" width="24" height="24">
                    <use href="/assets/svg/navSprite.svg#<?= $link['svg'] ?>" />
                </svg>
                <?= $link['label'] ?>
            </a>
        <?php endforeach; ?>
        <hr class="border border-primary border-1 my-1 opacity-75">
    <?php endforeach; ?>
</nav>