<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVotesTable extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'request_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['user_id', 'request_id'], 'uk_votes_user_request');
        $this->forge->addKey('user_id', false, false, 'idx_votes_user');
        $this->forge->addKey('request_id', false, false, 'idx_votes_request');

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE', 'fk_votes_user');
        $this->forge->addForeignKey('request_id', 'requests', 'id', 'CASCADE', 'CASCADE', 'fk_votes_request');

        $this->forge->createTable('votes', true);
    }

    public function down()
    {
        $this->forge->dropTable('votes', true);
    }
}
