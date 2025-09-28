<?php

$routes->environment('development', static function ($routes) {
    $routes->get('builder', 'Tools\Builder::index');
});

$routes->get('/', 'Home::index', ['filter' => 'role']);

// auth
$routes->group('auth', ['namespace' => 'App\Controllers'], static function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::verify');
    $routes->get('logout', 'AuthController::logout');
});

// user
$routes->group('user', ['namespace' => 'App\Controllers\CRUD'], static function ($routes) {
    $routes->get('/', 'UserController::index', ['filter' => 'role:admin']);
    $routes->get('new', 'UserController::new', ['filter' => 'role:admin']);
    $routes->post('new', 'UserController::create', ['filter' => 'role:admin']);
    $routes->get('show', 'UserController::show', ['filter' => 'role']);
    $routes->put('show', 'UserController::update', ['filter' => 'role']);
});

// Grupo multitenancy normales
$routes->group('tenants', ['namespace' => 'App\Controllers\Tenants', 'filter' => 'role:businessman'], static function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('business', 'BusinessController::index');

    $routes->resource('users', ['controller' => 'UserController']);
    $routes->resource('products', ['controller' => 'ProductController']);
    $routes->resource('supplies', ['controller' => 'SupplyController']);
    $routes->resource('providers', ['controller' => 'ProviderController']);
    $routes->resource('customers', ['controller' => 'CustomerController']);
    $routes->resource('employees', ['controller' => 'EmployeeController']);
    $routes->resource('income-services', ['controller' => 'IncomeServicesController']);
    $routes->resource('expense-services', ['controller' => 'ExposeServicesController']);
    $routes->resource('orders', ['controller' => 'OrderController']);
    $routes->resource('purchases', ['controller' => 'PurchaseController']);


    // $routes->resource('items', ['controller' => 'ItemController']);
});

// Grupo Admin
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('dashboard', 'DashboardController::index');
    $routes->resource('users', ['controller' => 'UserController']);
    $routes->resource('reports', ['controller' => 'ReportsController']);
});

// Perfil del usuario
$routes->group('profile', ['namespace' => 'App\Controllers', 'filter' => 'role'], static function ($routes) {
    $routes->get('/', 'ProfileController::profile');
});

// Rutas de User
// vistas
// $routes->get('/', 'UserController::login');
// $routes->get('user', 'UserController::show');
// $routes->get('users', 'UserController::index');
// $routes->get('users/new', 'UserController::new');
// $routes->get('password', 'UserController::password');
// $routes->get('recovery', 'UserController::recovery');
// $routes->get('token', 'UserController::token');
// // otras
// $routes->post('/', 'UserController::verify');
// $routes->put('user', 'UserController::update');
// $routes->put('user/(:segment)/activate', 'UserController::activate/$1');
// $routes->post('users/new', 'UserController::create');
// $routes->delete('users/(:segment)', 'UserController::delete/$1');
// $routes->get('logout', 'UserController::logout');
// $routes->post('password', 'UserController::password');
// $routes->post('recovery', 'UserController::recovery');
// $routes->post('token', 'UserController::token');

// // Rutas de Business
// // vistas
// $routes->get('business', 'BusinessController::show');
// $routes->get('business/new', 'BusinessController::new');
// // otras
// $routes->post('business', 'BusinessController::create');
// $routes->put('business', 'BusinessController::update');

// // Rutas de Contact
// // vistas
// $routes->get('contacts', 'ContactController::index');
// $routes->get('contacts/new', 'ContactController::new');
// $routes->get('contacts/(:segment)', 'ContactController::show/$1');
// // otras
// $routes->post('contacts', 'ContactController::create');
// $routes->put('contacts/(:segment)', 'ContactController::update/$1');
// $routes->delete('contacts/(:segment)', 'ContactController::delete/$1');

// // Rutas de Item
// // vistas
// $routes->get('items', 'ItemController::index');
// $routes->get('items/new', 'ItemController::new');
// $routes->get('items/(:segment)', 'ItemController::show/$1');
// // otras
// $routes->post('items', 'ItemController::create');
// $routes->put('items/(:segment)', 'ItemController::update/$1');
// $routes->delete('items/(:segment)', 'ItemController::delete/$1');

// // Rutas de Category
// // vistas
// $routes->get('categories', 'CategoryController::index');
// $routes->get('categories/new', 'CategoryController::new');
// $routes->get('categories/(:segment)', 'CategoryController::show/$1');
// // otras
// $routes->post('categories', 'CategoryController::create');
// $routes->put('categories/(:segment)', 'CategoryController::update/$1');
// $routes->delete('categories/(:segment)', 'CategoryController::delete/$1');

// // Rutas de Transaction
// // vistas
// $routes->get('transactions', 'TransactionController::index');
// $routes->get('transactions/new', 'TransactionController::new');
// $routes->get('transactions/(:segment)', 'TransactionController::show/$1');
// // otras
// $routes->post('transactions', 'TransactionController::create');
// $routes->put('transactions/(:segment)', 'TransactionController::update/$1');

// $routes->get('/example', 'ExampleController::index');
// $routes->get('/dashboard', 'DashboardController::index');

// $routes->group('', ['filter' => 'cors'], function ($routes) {
//     $routes->get('api/report', 'Api\ReportController::index');
//     $routes->options('api/incomeStatement', 'Api\ReportController::preflight');
//     $routes->get('api/incomeStatement', 'Api\ReportController::incomeStatement');
// });
// $routes->group('', ['filter' => 'cors'], static function (RouteCollection $routes): void {
//     $routes->get('api/report', 'Api\ReportController::index');

//     $routes->options('api/incomeStatement', static function () {
//         $response = response();
//         $response->setStatusCode(204);
//         $response->setHeader('Allow:', 'OPTIONS, GET, POST, PUT, PATCH, DELETE');

//         return $response;
//     });

//     $routes->get('api/incomeStatement', 'Api\ReportController::incomeStatement');
// });
// $routes->group('api', ['filter' => 'cors:api'], static function (RouteCollection $routes): void {
//     $routes->get('report', 'Api\ReportController::index');

//     $routes->options('report', static function () {
//         $response = response();
//         $response->setStatusCode(204);
//         $response->setHeader('Allow:', 'OPTIONS, GET, POST, PUT, PATCH, DELETE');
//         return $response;
//     });
//     $routes->options('incomeStatement', static function () {
//         $response = response();
//         $response->setStatusCode(204);
//         $response->setHeader('Allow:', 'OPTIONS, GET, POST, PUT, PATCH, DELETE');
//         return $response;
//     });
//     $routes->get('incomeStatement', 'Api\ReportController::incomeStatement');
//     $routes->get('paymentStatus', 'Api\ReportController::paymentStatus');
//     $routes->get('paymentMethod', 'Api\ReportController::paymentMethod');
//     $routes->get('topItems', 'Api\ReportController::topItems');
//     $routes->get('dashboardMetrics', 'Api\ReportController::dashboardMetrics');
// });
