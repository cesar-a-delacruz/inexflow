<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/user/(:segment)', 'UserController::show/$1');
$routes->get('/user/new', 'UserController::new');
