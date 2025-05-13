<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePemain extends Migration
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
            'nama' => [
            'type'       => 'VARCHAR',
            'constraint' => 100,
            ],
            'tanggal_lahir' => [
            'type' => 'DATE',
            ],
            'tinggi_badan' => [
            'type'       => 'VARCHAR',
            'constraint' => 50,
            ],
            'pendidikan' => [
            'type'       => 'VARCHAR',
            'constraint' => 50,
            ],
            'alamat' => [
            'type'       => 'TEXT',
            ],
            'no_hp' => [
            'type'       => 'VARCHAR',
            'constraint' => 20,
            ],
            'status_seleksi' => [
            'type'       => 'VARCHAR',
            'constraint' => 20,
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
        $this->forge->createTable('pemain');
    }

    public function down()
    {
        $this->forge->dropTable('pemain');
    }
}
