<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->addPlaceholder('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
// Rutas del usuario
$routes->get('user/(:uuid)', 'UserController::show/$1');
$routes->put('user/(:uuid)', 'UserController::update/$1');
$routes->get('user/new', 'UserController::new');
$routes->post('user/', 'UserController::create');

$routes->get('user/', 'UserController::index');
// Rutas del negocio
$routes->get('user/(:uuid)/business/new', 'BusinessController::new/$1');
$routes->post('user/(:uuid)', 'BusinessController::create');
$routes->get('user/(:uuid)/business', 'BusinessController::show/$1');
$routes->put('user/(:uuid)/business', 'BusinessController::update/$1');

//Rutas de Login
$routes->get('/','LoginController::index');
$routes->get('login','LoginController::index');
$routes->post('login','LoginController::procesarLogin');
$routes->get('logout', 'LoginController::logout'); 

$routes->get('dashboard/admin', 'DashboardController::index');
