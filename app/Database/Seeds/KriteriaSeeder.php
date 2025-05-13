<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
            'kode' => 'C1',
            'nama_kriteria' => 'Stamina',
            'tipe' => 'core',
            'nilai_ideal' => 5
            ],
            [
            'kode' => 'C2',
            'nama_kriteria' => 'Kecepatan',
            'tipe' => 'core',
            'nilai_ideal' => 5
            ],
            [
            'kode' => 'C3',
            'nama_kriteria' => 'Kekuatan',
            'tipe' => 'core',
            'nilai_ideal' => 5
            ],
            [
            'kode' => 'C4',
            'nama_kriteria' => 'Kerja Sama',
            'tipe' => 'secondary',
            'nilai_ideal' => 5
            ],
            [
            'kode' => 'C5',
            'nama_kriteria' => 'Pengalaman',
            'tipe' => 'secondary',
            'nilai_ideal' => 5
            ],
        ];

        // Insert data to the table 'kriteria'
        $this->db->table('kriteria')->insertBatch($data);
    }
}
