<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rutas del usuario
// vistas
$routes->get('/', 'UserController::login');
$routes->get('user', 'UserController::show');
$routes->get('users', 'UserController::index'); 
$routes->get('users/new', 'UserController::new');
$routes->get('password', 'UserController::password');
$routes->get('recovery', 'UserController::recovery');
$routes->get('token', 'UserController::token');
// otras
$routes->post('/', 'UserController::verify');
$routes->put('user', 'UserController::update');
$routes->delete('user/(:segment)', 'UserController::delete/$1');
$routes->put('user/(:segment)/activate', 'UserController::activate/$1');
$routes->post('users', 'UserController::create');
$routes->get('logout', 'UserController::logout');
$routes->post('password', 'UserController::password');
$routes->post('recovery', 'UserController::recovery');
$routes->post('token', 'UserController::token');

// Rutas del negocio
// vistas
$routes->get('business', 'BusinessController::show');
$routes->get('business/new', 'BusinessController::new');
// otras
$routes->post('business', 'BusinessController::create');
$routes->put('business', 'BusinessController::update');

// Rutas de categoríaa
//vistas
$routes->get('categories/new', 'CategoryController::new');
$routes->get('categories', 'CategoryController::index');
// otras
$routes->post('categories', 'CategoryController::create');
$routes->delete('category/(:segment)', 'CategoryController::delete/$1');

// Rutas de transacciones
//vistas
$routes->get('transaction/(:segment)', 'TransactionController::show/$1');
$routes->get('transactions', 'TransactionController::index');
$routes->get('transactions/new', 'TransactionController::new');
// otras
$routes->post('transactions', 'TransactionController::create');
$routes->put('transaction/(:segment)', 'TransactionController::update/$1');

// Rutas de Contactos
// vistas
$routes->get('contacts', 'ContactController::index');
$routes->get('contacts/new', 'ContactController::new');
$routes->get('contacts/(:segment)', 'ContactController::show/$1');
// otras
$routes->post('contacts', 'ContactController::create');
$routes->put('contacts/(:segment)', 'ContactController::update/$1');
$routes->delete('contacts/(:segment)', 'ContactController::delete/$1');

// Rutas de Items
// vistas
$routes->get('items', 'ItemController::index');
$routes->get('items/new', 'ItemController::new');
$routes->get('items/(:segment)', 'ItemController::show/$1');
// otras
$routes->post('items', 'ItemController::create');
$routes->put('items/(:segment)', 'ItemController::update/$1');
$routes->delete('items/(:segment)', 'ItemController::delete/$1');