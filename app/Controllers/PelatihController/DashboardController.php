<?php

namespace App\Controllers\PelatihController;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard Pelatih',
            'page' => 'pelatih/dashboard',
        ];

        return view('pelatih/dashboard', $data);
    }
}
