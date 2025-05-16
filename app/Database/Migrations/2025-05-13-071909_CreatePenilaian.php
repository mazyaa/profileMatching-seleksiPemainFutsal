<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenilaian extends Migration
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
            ],
            'stamina' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'kecepatan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'kekuatan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'kerja_sama' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'pengalaman' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
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

        $this->forge->addForeignKey('id_pemain', 'pemain', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('penilaian');
    }

    public function down()
    {
        $this->forge->dropTable('penilaian');
    }
}
