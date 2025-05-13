<?php

namespace App\Controllers\PelatihController;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PemainModel;

class Pemain extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new PemainModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Data Pemain',
            'page' => 'pelatih/pemain/index',
        ];

        return view('pelatih/inputPemain', $data);
    }

    public function create()
    {
        $json = $this->request->getJSON(true);

        $data = [
            'nama' => $json['nama'],
            'tinggi_badan' => $json['tinggi_badan'],
            'alamat' => $json['alamat'],
            'no_hp' => $json['no_hp'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $rules = [
            'nama' => 'required',
            'tinggi_badan' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJson([
                'status' => 422,
                'message' => 'Semua field harus diisi'
            ])->setStatusCode(422);
        }

        if ($this->model->insert($data)) {
            return $this->response->setJson([
                'status' => 201,
                'message' => 'Data berhasil ditambahkan'
            ])->setStatusCode(201);
        } else {
            return $this->response->setJson([
                'status' => 500,
                'message' => 'Gagal menambahkan data'
            ])->setStatusCode(500);
        }
    }
}
