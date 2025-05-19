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
    public function getPemain()
    {
        $data = [
            'title' => 'Data Pemain',
            'page' => 'pelatih/getPemain',
        ];

        return view('pelatih/getPemain', $data);
    }

    public function fetchPemain()
    {
        $pemain = $this->model->findAll();

        if ($pemain) {
            return $this->response->setJson([
                'status' => 200,
                'data' => $pemain
            ])->setStatusCode(200);
        } else {
            return $this->response->setJson([
                'status' => 404,
                'message' => 'Data tidak ditemukan'
            ])->setStatusCode(404);
        }
    }

    public function edit($id)
    {
        $json = $this->request->getJSON(true);

        $pemain = $this->model->find($id);

        if (!$pemain) {
            return $this->response->setJson([
                'status' => 404,
                'message' => 'Pemain tidak ditemukan'
            ])->setStatusCode(404);
        }

        $data = [
            'nama' => isset($json['nama']) && trim($json['nama']) !== '' ? $json['nama'] : $pemain['nama'],
            'tinggi_badan' => isset($json['tinggi_badan']) && trim($json['tinggi_badan']) !== '' ? $json['tinggi_badan'] : $pemain['tinggi_badan'],
            'alamat' => isset($json['alamat']) && trim($json['alamat']) !== '' ? $json['alamat'] : $pemain['alamat'],
            'no_hp' => isset($json['no_hp']) && trim($json['no_hp']) !== '' ? $json['no_hp'] : $pemain['no_hp'],
        ];

        if ($this->model->update($id, $data)) {
            return $this->response->setJson([
                'status' => 200,
                'message' => 'Data berhasil diupdate'
            ])->setStatusCode(200);
        } else {
            return $this->response->setJson([
                'status' => 500,
                'message' => 'Gagal mengupdate data'
            ])->setStatusCode(500);
        }
    }
    public function delete($id)
    {
        $session = session();
        $userId = $session->get('id');

        if (!$userId) {
            return $this->response->setJson([
                'status' => 401,
                'message' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        if ($this->model->delete($id)) {
            return $this->response->setJson([
                'status' => 200,
                'message' => 'Pemain berhasil dihapus'
            ])->setStatusCode(200);
        } else {
            return $this->response->setJson([
                'status' => 500,
                'message' => 'Gagal menghapus data'
            ])->setStatusCode(500);
        }
    }
}
