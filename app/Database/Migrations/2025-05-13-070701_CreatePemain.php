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
            'tinggi_badan' => [
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
        $this->forge->createTable('pemain');
    }

    public function down()
    {
        $this->forge->dropTable('pemain');
    }
}
