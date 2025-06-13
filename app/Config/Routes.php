<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/user/(:num)', 'UserController::show/$1');
$routes->put('/user/(:num)', 'UserController::update/$1');
$routes->get('/user/new', 'UserController::new');
$routes->get('user/login', 'UserController::login');
$routes->get('user/dashboard', 'UserController::dashboard');
$routes->get('user/traders', 'UserController::traders');
$routes->match(['get', 'post'], 'user/recovery', 'UserController::reset');
