<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // Seed default categories
        $categories = [
            [
                'name'       => 'Feature Request',
                'slug'       => 'feature-request',
                'color'      => '#6366f1',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Bug Report',
                'slug'       => 'bug-report',
                'color'      => '#ef4444',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Improvement',
                'slug'       => 'improvement',
                'color'      => '#10b981',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Integration',
                'slug'       => 'integration',
                'color'      => '#8b5cf6',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('categories')->insertBatch($categories);

        // Seed default settings
        $settings = [
            ['key' => 'site_name', 'value' => 'FeatureVote'],
            ['key' => 'site_description', 'value' => 'Share your ideas and vote on features'],
            ['key' => 'allow_registration', 'value' => '1'],
            ['key' => 'require_email_verify', 'value' => '0'],
            ['key' => 'items_per_page', 'value' => '20'],
            ['key' => 'allow_anonymous_view', 'value' => '1'],
            ['key' => 'default_status', 'value' => 'open'],
            ['key' => 'brand_color', 'value' => '#6366f1'],
        ];

        $this->db->table('settings')->insertBatch($settings);
    }
}
