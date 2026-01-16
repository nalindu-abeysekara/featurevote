<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserExtensions extends Migration
{
    public function up()
    {
        // Add custom fields to Shield's users table
        $this->forge->addColumn('users', [
            'avatar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'username',
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'user'],
                'default'    => 'user',
                'null'       => false,
                'after'      => 'avatar',
            ],
        ]);

        // Add index on role
        $this->forge->addKey('role', false, false, 'idx_users_role');

        // Modify table to add index
        $this->db->query('ALTER TABLE users ADD INDEX idx_users_role (role)');
    }

    public function down()
    {
        // Remove index
        $this->db->query('ALTER TABLE users DROP INDEX idx_users_role');

        // Remove custom fields
        $this->forge->dropColumn('users', ['avatar', 'role']);
    }
}
