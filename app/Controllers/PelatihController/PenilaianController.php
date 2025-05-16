<?php

namespace App\Controllers\PelatihController;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KriteriaModel;

class PenilaianController extends BaseController
{   
    protected $model;

    public function __construct()
    {
        $this->model = new KriteriaModel();
    }
    public function index()
    {
        $page = [
            'title' => 'Penilaian Pemain',
            'page' => 'pelatih/penilaian',
        ];
        return view('pelatih/penilaian', $page);
    }

    public function store() 
    {
        $json = $this->request->getJSON();

        $data = [
            'id_pemain' => $json->id_pemain,
            'id_kriteria' => $json->id_kriteria,
            'nilai' => $json->nilai
        ];
    }

    
}
