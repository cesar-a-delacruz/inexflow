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
$routes->get('/', 'UserController::login');
$routes->get('user/', 'UserController::index'); 
$routes->delete('user/(:uuid)', 'UserController::delete/$1');
// Rutas del negocio
$routes->get('user/(:uuid)/business/new', 'BusinessController::new/$1');
$routes->post('user/(:uuid)', 'BusinessController::create');
$routes->get('user/(:uuid)/business', 'BusinessController::show/$1');
$routes->put('user/(:uuid)/business', 'BusinessController::update/$1');
