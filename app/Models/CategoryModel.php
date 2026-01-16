<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'name',
        'slug',
        'color',
        'sort_order',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'slug' => 'required|min_length[2]|max_length[100]|alpha_dash|is_unique[categories.slug,id,{id}]',
        'color' => 'required|regex_match[/^#[0-9A-Fa-f]{6}$/]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Category name is required.',
        ],
        'slug' => [
            'is_unique' => 'This slug is already in use.',
        ],
        'color' => [
            'regex_match' => 'Color must be a valid hex color (e.g., #6366f1).',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Get all categories ordered by sort_order.
     *
     * @return array
     */
    public function getOrdered()
    {
        return $this->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll();
    }

    /**
     * Get category by slug.
     *
     * @param string $slug
     * @return object|null
     */
    public function findBySlug(string $slug)
    {
        return $this->where('slug', $slug)->first();
    }

    /**
     * Get requests for this category.
     *
     * @param int $categoryId
     * @return array
     */
    public function requests(int $categoryId)
    {
        return model(RequestModel::class)
            ->where('category_id', $categoryId)
            ->orderBy('vote_count', 'DESC')
            ->findAll();
    }

    /**
     * Get request count for this category.
     *
     * @param int $categoryId
     * @return int
     */
    public function requestCount(int $categoryId): int
    {
        return model(RequestModel::class)
            ->where('category_id', $categoryId)
            ->countAllResults();
    }

    /**
     * Generate unique slug from name.
     *
     * @param string $name
     * @param int|null $excludeId
     * @return string
     */
    public function generateSlug(string $name, ?int $excludeId = null): string
    {
        $slug = url_title($name, '-', true);
        $originalSlug = $slug;
        $count = 1;

        $builder = $this->where('slug', $slug);
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        while ($builder->countAllResults(false) > 0) {
            $slug = $originalSlug . '-' . $count;
            $builder = $this->where('slug', $slug);
            if ($excludeId) {
                $builder->where('id !=', $excludeId);
            }
            $count++;
        }

        return $slug;
    }

    /**
     * Update sort order for multiple categories.
     *
     * @param array $order Array of [id => sort_order]
     * @return bool
     */
    public function updateOrder(array $order): bool
    {
        $this->db->transStart();

        foreach ($order as $id => $sortOrder) {
            $this->update($id, ['sort_order' => $sortOrder]);
        }

        $this->db->transComplete();

        return $this->db->transStatus();
    }
}
