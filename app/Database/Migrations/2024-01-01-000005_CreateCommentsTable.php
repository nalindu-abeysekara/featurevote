<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommentsTable extends Migration
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
            'parent_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'body' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id', false, false, 'idx_comments_user');
        $this->forge->addKey('request_id', false, false, 'idx_comments_request');
        $this->forge->addKey('parent_id', false, false, 'idx_comments_parent');
        $this->forge->addKey('created_at', false, false, 'idx_comments_created');

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE', 'fk_comments_user');
        $this->forge->addForeignKey('request_id', 'requests', 'id', 'CASCADE', 'CASCADE', 'fk_comments_request');
        $this->forge->addForeignKey('parent_id', 'comments', 'id', 'CASCADE', 'CASCADE', 'fk_comments_parent');

        $this->forge->createTable('comments', true);
    }

    public function down()
    {
        $this->forge->dropTable('comments', true);
    }
}
