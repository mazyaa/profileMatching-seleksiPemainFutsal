<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatehasilSeleksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_pemain' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'nilai_cf' => [
                'type'       => 'FLOAT',
                'null'       => false,
            ],
            'nilai_sf' => [
                'type'       => 'FLOAT',
                'null'       => false,
            ],
            'nilai_total' => [
                'type'       => 'FLOAT',
                'null'       => false,
            ],
            'ranking' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['lolos', 'tidak_lolos'],
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'DATE',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATE',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pemain', 'pemain', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('hasil_seleksi');
    }

    public function down()
    {
        $this->forge->dropTable('hasil_seleksi');
    }
}
