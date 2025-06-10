<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/user/(:num)', 'UserController::show/$1');
$routes->get('/user/(:num)/edit', 'UserController::edit/$1');
$routes->put('/user/(:num)', 'UserController::update/$1');
$routes->get('/user/new', 'UserController::new');
