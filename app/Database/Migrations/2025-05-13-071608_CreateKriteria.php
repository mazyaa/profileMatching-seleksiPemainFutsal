<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKriteria extends Migration
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
            'kode' => [
            'type'       => 'VARCHAR',
            'constraint' => '12',
            ],
            'nama_kriteria' => [
            'type'       => 'VARCHAR',
            'constraint' => '100',
            ],
            'tipe' => [
            'type'       => 'ENUM',
            'constraint' => ['core', 'secondary'],
            'default'    => 'core',
            ],
            'nilai_ideal' => [
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 5,
            ],
            'created_at' => [
            'type'    => 'DATETIME',
            'null'    => true,
            ],
            'updated_at' => [
            'type'    => 'DATETIME',
            'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('kriteria');
    }
}
