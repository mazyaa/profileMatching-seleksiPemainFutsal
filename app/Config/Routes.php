<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth\LoginController::index');

$routes->group('auth', function ($routes) {
    $routes->post('login', 'Auth\LoginController::login');
    $routes->post('logout', 'Auth\LoginController::logout');
});
