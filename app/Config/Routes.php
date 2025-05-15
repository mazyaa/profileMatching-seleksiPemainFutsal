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
        /** dashboard */
        $routes->get('dashboard', 'PelatihController\DashboardController::index', ['filter' => 'pelatih']);

        /** get kriteria */
        $routes->get('kriteria', 'PelatihController\KriteriaPemain::index', ['filter' => 'pelatih']);
        $routes->get('kriteria/fetch', 'PelatihController\KriteriaPemain::getAllCriteria', ['filter' => 'pelatih']);

        /** input pemain */
        $routes->get('pemain', 'PelatihController\Pemain::index', ['filter' => 'pelatih']);
        $routes->Post('inputPemain', 'PelatihController\Pemain::create', ['filter' => 'pelatih']);

        /** get pemain after input */
        $routes->get('getPemain', 'PelatihController\Pemain::getPemain', ['filter' => 'pelatih']);
        $routes->get('fetchPemain', 'PelatihController\Pemain::fetchPemain', ['filter' => 'pelatih']);

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


