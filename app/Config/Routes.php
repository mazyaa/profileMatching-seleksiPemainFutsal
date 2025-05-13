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


$routes->group('pelatih', function ($routes) {
        $routes->get('dashboard', 'PelatihController\DashboardController::index', ['filter' => 'pelatih']);
        $routes->get('pemain', 'PelatihController\Pemain::index', ['filter' => 'pelatih']);
        $routes->Post('inputPemain', 'PelatihController\Pemain::create', ['filter' => 'pelatih']);
        $routes->post('pemain/store', 'PelatihController\Pemain::store', ['filter' => 'pelatih']);
        $routes->get('pemain/edit/(:num)', 'PelatihController\Pemain::edit/$1', ['filter' => 'pelatih']);
        $routes->post('pemain/update/(:num)', 'PelatihController\Pemain::update/$1', ['filter' => 'pelatih']);
        $routes->post('pemain/delete/(:num)', 'PelatihController\Pemain::delete/$1', ['filter' => 'pelatih']);
});

$routes->group('admin', function ($routes) {
        $routes->get('/', 'Admin\Dashboard::index');
        $routes->get('pemain', 'Admin\Pemain::index');
        $routes->get('pemain/create', 'Admin\Pemain::create');
        $routes->post('pemain/store', 'Admin\Pemain::store');
        $routes->get('pemain/edit/(:num)', 'Admin\Pemain::edit/$1');
        $routes->post('pemain/update/(:num)', 'Admin\Pemain::update/$1');
        $routes->post('pemain/delete/(:num)', 'Admin\Pemain::delete/$1');
});


