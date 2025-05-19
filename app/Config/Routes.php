<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', function () {
    return redirect()->to('auth/login');
});

$routes->group('auth', function ($routes) {
    $routes->get('login', 'Auth\LoginController::index');
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

        /** Penilaian */
        $routes->get('pagePenilaian', 'PelatihController\PenilaianController::index', ['filter' => 'pelatih']);
        $routes->get('hasilSeleksi', 'PelatihController\PenilaianController::hasil', ['filter' => 'pelatih']);
        $routes->get('getHasilSeleksi', 'PelatihController\PenilaianController::getAllPenilaian', ['filter' => 'pelatih']);
        $routes->post('penilaian', 'PelatihController\PenilaianController::store', ['filter' => 'pelatih']);
        $routes->post('hasilPerhitungan', 'PelatihController\PenilaianController::increment', ['filter' => 'pelatih']);

        /** Hasil Seleksi */
        $routes->get('pemainLolos', 'PelatihController\penilaianController::pemainLolos', ['filter' => 'pelatih']);
        $routes->get('getHasilLolos', 'PelatihController\penilaianController::getHasilSeleksiByStatusLolos', ['filter' => 'pelatih']);
        $routes->get('pemainTidakLolos', 'PelatihController\penilaianController::pemainTidakLolos', ['filter' => 'pelatih']);
        $routes->get('getHasilTidakLolos', 'PelatihController\penilaianController::getHasilSeleksiByStatusTidakLolos', ['filter' => 'pelatih']);
        $routes->get('getAllStatusHasilSeleksi', 'PelatihController\penilaianController::getAllStatusHasilSeleksi', ['filter' => 'pelatih']);

        $routes->post('pemain/edit/(:num)', 'PelatihController\Pemain::edit/$1', ['filter' => 'pelatih']);
        $routes->post('pemain/update/(:num)', 'PelatihController\Pemain::update/$1', ['filter' => 'pelatih']);
        $routes->post('pemain/delete/(:num)', 'PelatihController\Pemain::delete/$1', ['filter' => 'pelatih']);
});



