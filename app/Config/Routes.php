<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->addPlaceholder('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
// Rutas del usuario
// vistas
$routes->get('user/', 'UserController::index'); 
$routes->get('/', 'UserController::login');
$routes->get('user/new', 'UserController::new');
$routes->get('user/(:uuid)', 'UserController::show/$1');
// otras
$routes->post('user/', 'UserController::create');
$routes->delete('user/(:uuid)', 'UserController::delete/$1');
$routes->post('/', 'UserController::verify');
$routes->get('logout/', 'UserController::logout');
$routes->put('user/(:uuid)', 'UserController::update/$1');

// Rutas del negocio
// vistas
$routes->get('user/(:uuid)/business/new', 'BusinessController::new/$1');
$routes->get('user/(:uuid)/business', 'BusinessController::show/$1');
// otras
$routes->post('user/(:uuid)', 'BusinessController::create');
$routes->put('user/(:uuid)/business', 'BusinessController::update/$1');
