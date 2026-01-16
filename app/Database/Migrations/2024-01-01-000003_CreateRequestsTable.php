<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRequestsTable extends Migration
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
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['open', 'under_review', 'planned', 'in_progress', 'completed', 'closed', 'merged'],
                'default'    => 'open',
                'null'       => false,
            ],
            'admin_response' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'internal_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'merged_into_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'vote_count' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'null'       => false,
            ],
            'comment_count' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'null'       => false,
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
        $this->forge->addUniqueKey('slug', 'uk_requests_slug');
        $this->forge->addKey('user_id', false, false, 'idx_requests_user');
        $this->forge->addKey('category_id', false, false, 'idx_requests_category');
        $this->forge->addKey('status', false, false, 'idx_requests_status');
        $this->forge->addKey('vote_count', false, false, 'idx_requests_votes');
        $this->forge->addKey('created_at', false, false, 'idx_requests_created');
        $this->forge->addKey('merged_into_id', false, false, 'idx_requests_merged');

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE', 'fk_requests_user');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'SET NULL', 'CASCADE', 'fk_requests_category');
        $this->forge->addForeignKey('merged_into_id', 'requests', 'id', 'SET NULL', 'CASCADE', 'fk_requests_merged');

        $this->forge->createTable('requests', true);
    }

    public function down()
    {
        $this->forge->dropTable('requests', true);
    }
}
