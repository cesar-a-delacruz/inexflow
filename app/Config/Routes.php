<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->addPlaceholder('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
$routes->get('/user/(:uuid)', 'UserController::show/$1');
$routes->put('/user/(:uuid)', 'UserController::update/$1');
$routes->get('/user/new/', 'UserController::new');
$routes->get('/', 'UserController::login');
$routes->post('/', 'UserController::verify');
$routes->get('user/index', 'UserController::index');
