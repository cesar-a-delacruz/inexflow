<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/user/index', 'UserController::index');
$routes->get('/user/new', 'UserController::new');
