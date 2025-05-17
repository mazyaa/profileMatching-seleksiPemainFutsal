<?php

namespace App\Controllers\PelatihController;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KriteriaModel;
use App\models\PemainModel;
use App\Models\HasilSeleksiModel;
use App\Models\PenilaianModel;

class PenilaianController extends BaseController
{
    protected $penilaianModel;
    protected $pemainModel;
    protected $hasilSeleksiModel;

    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
        $this->pemainModel = new PemainModel();
        $this->hasilSeleksiModel = new HasilSeleksiModel();
    }
    public function index()
    {
        $page = [
            'title' => 'Penilaian Pemain',
            'page' => 'pelatih/penilaian',
        ];
        return view('pelatih/penilaian', $page);
    }

    public function hasil()
    {
        $page = [
            'title' => 'Hasil Seleksi',
            'page' => 'pelatih/hasil_seleksi',
        ];
        return view('pelatih/hasilSeleksi', $page);
    }

    public function pemainLolos() 
    {
        $page = [
            'title' => 'Pemain Lolos',
            'page' => 'pelatih/pemainLolos',
        ];
        return view('pelatih/pemainLolos', $page);
    }

    public function pemainTidakLolos() 
    {
        $page = [
            'title' => 'Pemain Tidak Lolos',
            'page' => 'pelatih/pemainTidakLolos',
        ];
        return view('pelatih/pemainTidakLolos', $page);
    }

    public function store()
    {
        $json = $this->request->getJSON(true);

        $data = [
            'id_pemain' => $json['id_pemain'],
            'stamina' => $json['stamina'],
            'kecepatan' => $json['kecepatan'],
            'kekuatan' => $json['kekuatan'],
            'kerja_sama' => $json['kerja_sama'],
            'pengalaman' => $json['pengalaman'],
        ];

        $rules = [
            'id_pemain' => 'required',
            'stamina' => 'required',
            'kecepatan' => 'required',
            'kekuatan' => 'required',
            'kerja_sama' => 'required',
            'pengalaman' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJson([
                'status' => 422,
                'message' => 'Semua field harus diisi'
            ])->setStatusCode(422);
        }

        $this->penilaianModel->where('id_pemain', $json['id_pemain'])->delete(); // delete value if exists

        // Insert new data
        if ($this->penilaianModel->insert($data)) {
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

    public function getAllPenilaian()
    {
        $penilaian = $this->penilaianModel
            ->select('penilaian.*, pemain.nama') // select all columns from penilaian and nama from pemain
            ->join('pemain', 'pemain.id = penilaian.id_pemain') // join with pemain table and match id_pemain with id
            ->findAll();

        if ($penilaian) {
            return $this->response->setJson([
                'status' => 200,
                'data' => $penilaian
            ])->setStatusCode(200);
        } else {
            return $this->response->setJson([
                'status' => 404,
                'message' => 'Data tidak ditemukan'
            ])->setStatusCode(404);
        }
    }

    public function increment()
    {
        $pemainList = $this->pemainModel->findAll();
        $hasil = [];

        foreach ($pemainList as $pemain) {
            $nilai = $this->penilaianModel->where('id_pemain', $pemain['id'])->first();
            if (!$nilai) {
                continue;
            } // if user not have penilaian, skip to the next step


            $nilai_ideal = 5;

            //incrementing the gap
            $gaps = [
                'stamina' => $nilai['stamina'] - $nilai_ideal,
                'kecepatan' => $nilai['kecepatan'] - $nilai_ideal,
                'kekuatan' => $nilai['kekuatan'] - $nilai_ideal,
                'kerja_sama' => $nilai['kerja_sama'] - $nilai_ideal,
                'pengalaman' => $nilai['pengalaman'] - $nilai_ideal,
            ];

            // konversi gap to nilai bobot
            $bobot = [];
            foreach ($gaps as $key => $gap) {
                $bobot[$key] = $this->konversiGap($gap);
            }

            // incrementing value core factors
            $ncf = ($bobot['stamina'] + $bobot['kecepatan'] + $bobot['kekuatan']) / 3;

            // incrementing value secondary factors
            $nsf = ($bobot['kerja_sama'] + $bobot['pengalaman']) / 2;

            // incrementing value total
            $total = ($ncf * 0.6) + ($nsf * 0.4);

            $hasil[] = [
                'id_pemain' => $pemain['id'],
                'nama' => $pemain['nama'],
                'nilai_asli' => [
                    'stamina' => $nilai['stamina'],
                    'kecepatan' => $nilai['kecepatan'],
                    'kekuatan' => $nilai['kekuatan'],
                    'kerja_sama' => $nilai['kerja_sama'],
                    'pengalaman' => $nilai['pengalaman'],
                ],
                'gap' => $gaps,
                'bobot_gap' => $bobot,
                'nilai_cf' => round($ncf, 2), // use round to 2 decimal places
                'nilai_sf' => round($nsf, 2),
                'nilai_akhir' => round($total, 2),
                'status' => $total >= 3 ? 'lolos' : 'tidak lolos',
                'ranking' => 0,
            ];
        }

        // sorting by nilai_akhir (descending) for ranking
        usort($hasil, fn($a, $b) => $b['nilai_akhir'] <=> $a['nilai_akhir']);

        //delete previous data in hasil_seleksi if exists
        $this->hasilSeleksiModel->truncate();

        // set ranking and status
        foreach ($hasil as $key => $value) {
            $ranking = $key + 1;
            $status = $value['nilai_akhir'] >= 3 ? 'lolos' : 'tidak lolos';

            $hasil[$key]['ranking'] = $ranking; // set ranking to hasil array

            // insert into hasil_seleksi
            $this->hasilSeleksiModel->insert([
                'id_pemain' => $value['id_pemain'],
                'nilai_cf' => $value['nilai_cf'],
                'nilai_sf' => $value['nilai_sf'],
                'nilai_akhir' => $value['nilai_akhir'],
                'ranking' => $ranking,
                'status' => $status,
            ]);
        }

        return $this->response->setJson([
            'status' => 200,
            'message' => 'Perhitungan & Perangkingan selesai',
            'data' => $hasil
        ])->setStatusCode(200);
    }

    private function konversiGap($gap)
    {
        $mapping = [
            0 => 5,
            1 => 4.5,
            2 => 3.5,
            3 => 2.5,
            4 => 1.5,
            -1 => 4,
            -2 => 3,
            -3 => 2,
            -4 => 1
        ];
        return $mapping[$gap] ?? 0;
    }

    public function getHasilSeleksiByStatusLolos(){
        $hasil = $this->hasilSeleksiModel
            ->select('hasil_seleksi.*, pemain.*')
            ->join('pemain', 'pemain.id = hasil_seleksi.id_pemain')
            ->where('status', 'lolos')
            ->orderBy('ranking', 'ASC')
            ->findAll();

        if ($hasil) {
            return $this->response->setJson([
                'status' => 200,
                'data' => $hasil
            ])->setStatusCode(200);
        } else {
            return $this->response->setJson([
                'status' => 404,
                'message' => 'Data tidak ditemukan'
            ])->setStatusCode(404);
        }
    }

    public function getHasilSeleksiByStatusTidakLolos(){
        $hasil = $this->hasilSeleksiModel
            ->select('hasil_seleksi.*, pemain.*')
            ->join('pemain', 'pemain.id = hasil_seleksi.id_pemain')
            ->where('status', 'tidak lolos')
            ->orderBy('ranking', 'ASC')
            ->findAll();

        if ($hasil) {
            return $this->response->setJson([
                'status' => 200,
                'data' => $hasil
            ])->setStatusCode(200);
        } else {
            return $this->response->setJson([
                'status' => 404,
                'message' => 'Data tidak ditemukan'
            ])->setStatusCode(404);
        }
    }
}
