<?php

namespace App\Controllers\PelatihController;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KriteriaModel;

class KriteriaPemain extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new KriteriaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kriteria',
            'page' => 'pelatih/kriteria',
        ];

        return view('pelatih/kriteria', $data);   
    }

    public function getAllCriteria()
    {
        $kriteria = $this->model->findAll();
        if ($kriteria) {
            return $this->response->setJSON([
                'status' => 200,
                'data' => $kriteria
            ])->setStatusCode(200);
        } else {
            return $this->response->setJSON([
                'status' => 404,
                'message' => 'Data tidak ditemukan'
            ])->setStatusCode(404);
        }
    }
}
