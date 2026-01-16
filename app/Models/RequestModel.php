<?php

namespace App\Models;

use CodeIgniter\Model;

class RequestModel extends Model
{
    protected $table            = 'requests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'status',
        'admin_response',
        'internal_notes',
        'merged_into_id',
        'image',
        'vote_count',
        'comment_count',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id'     => 'required|integer',
        'title'       => 'required|min_length[5]|max_length[255]',
        'description' => 'required|min_length[20]',
        'status'      => 'permit_empty|in_list[open,under_review,planned,in_progress,completed,closed,merged]',
    ];

    protected $validationMessages = [
        'title' => [
            'required'   => 'A title is required for the feature request.',
            'min_length' => 'Title must be at least 5 characters.',
        ],
        'description' => [
            'required'   => 'A description is required.',
            'min_length' => 'Please provide more detail (at least 20 characters).',
        ],
    ];

    protected $skipValidation = false;

    // Callbacks
    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['updateSlugIfNeeded'];

    /**
     * Status labels and colors.
     */
    public const STATUS_LABELS = [
        'open'         => ['label' => 'Open', 'color' => 'gray'],
        'under_review' => ['label' => 'Under Review', 'color' => 'yellow'],
        'planned'      => ['label' => 'Planned', 'color' => 'blue'],
        'in_progress'  => ['label' => 'In Progress', 'color' => 'purple'],
        'completed'    => ['label' => 'Completed', 'color' => 'green'],
        'closed'       => ['label' => 'Closed', 'color' => 'red'],
        'merged'       => ['label' => 'Merged', 'color' => 'indigo'],
    ];

    /**
     * Generate slug before insert.
     *
     * @param array $data
     * @return array
     */
    protected function generateSlug(array $data): array
    {
        if (isset($data['data']['title']) && empty($data['data']['slug'])) {
            $data['data']['slug'] = $this->createUniqueSlug($data['data']['title']);
        }
        return $data;
    }

    /**
     * Update slug if title changed.
     *
     * @param array $data
     * @return array
     */
    protected function updateSlugIfNeeded(array $data): array
    {
        if (isset($data['data']['title']) && !isset($data['data']['slug'])) {
            $data['data']['slug'] = $this->createUniqueSlug($data['data']['title'], $data['id'][0] ?? null);
        }
        return $data;
    }

    /**
     * Create unique slug from title.
     *
     * @param string $title
     * @param int|null $excludeId
     * @return string
     */
    public function createUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = url_title($title, '-', true);
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
     * Find request by slug.
     *
     * @param string $slug
     * @return object|null
     */
    public function findBySlug(string $slug)
    {
        return $this->where('slug', $slug)->first();
    }

    /**
     * Get author (user) of this request.
     *
     * @param int $requestId
     * @return object|null
     */
    public function getAuthor(int $requestId)
    {
        $request = $this->find($requestId);
        if (!$request) {
            return null;
        }

        return model(UserModel::class)->find($request->user_id);
    }

    /**
     * Get category for this request.
     *
     * @param int $requestId
     * @return object|null
     */
    public function getCategory(int $requestId)
    {
        $request = $this->find($requestId);
        if (!$request || !$request->category_id) {
            return null;
        }

        return model(CategoryModel::class)->find($request->category_id);
    }

    /**
     * Get votes for this request.
     *
     * @param int $requestId
     * @return array
     */
    public function getVotes(int $requestId): array
    {
        return model(VoteModel::class)
            ->where('request_id', $requestId)
            ->findAll();
    }

    /**
     * Get comments for this request.
     *
     * @param int $requestId
     * @return array
     */
    public function getComments(int $requestId): array
    {
        return model(CommentModel::class)
            ->where('request_id', $requestId)
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

    /**
     * Get threaded comments for this request.
     *
     * @param int $requestId
     * @return array
     */
    public function getThreadedComments(int $requestId): array
    {
        return model(CommentModel::class)->getThreaded($requestId);
    }

    /**
     * Get merged requests (requests that were merged into this one).
     *
     * @param int $requestId
     * @return array
     */
    public function getMergedRequests(int $requestId): array
    {
        return $this->where('merged_into_id', $requestId)->findAll();
    }

    /**
     * Get parent request (if this was merged).
     *
     * @param int $requestId
     * @return object|null
     */
    public function getMergedInto(int $requestId)
    {
        $request = $this->find($requestId);
        if (!$request || !$request->merged_into_id) {
            return null;
        }

        return $this->find($request->merged_into_id);
    }

    /**
     * Get requests with filters and pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return array
     */
    public function getFiltered(array $filters = [], int $perPage = 20)
    {
        $builder = $this->builder();

        // Status filter
        if (!empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        } else {
            // Exclude merged by default
            $builder->where('status !=', 'merged');
        }

        // Category filter
        if (!empty($filters['category_id'])) {
            $builder->where('category_id', $filters['category_id']);
        }

        // Search filter
        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('title', $filters['search'])
                ->orLike('description', $filters['search'])
                ->groupEnd();
        }

        // Sorting
        $sortField = $filters['sort'] ?? 'vote_count';
        $sortDir = $filters['direction'] ?? 'DESC';
        $allowedSorts = ['vote_count', 'created_at', 'comment_count', 'title'];

        if (in_array($sortField, $allowedSorts)) {
            $builder->orderBy($sortField, $sortDir);
        }

        return [
            'requests' => $this->paginate($perPage),
            'pager'    => $this->pager,
        ];
    }

    /**
     * Increment vote count.
     *
     * @param int $requestId
     * @return bool
     */
    public function incrementVoteCount(int $requestId): bool
    {
        return $this->set('vote_count', 'vote_count + 1', false)
            ->where('id', $requestId)
            ->update();
    }

    /**
     * Decrement vote count.
     *
     * @param int $requestId
     * @return bool
     */
    public function decrementVoteCount(int $requestId): bool
    {
        return $this->set('vote_count', 'GREATEST(vote_count - 1, 0)', false)
            ->where('id', $requestId)
            ->update();
    }

    /**
     * Increment comment count.
     *
     * @param int $requestId
     * @return bool
     */
    public function incrementCommentCount(int $requestId): bool
    {
        return $this->set('comment_count', 'comment_count + 1', false)
            ->where('id', $requestId)
            ->update();
    }

    /**
     * Decrement comment count.
     *
     * @param int $requestId
     * @return bool
     */
    public function decrementCommentCount(int $requestId): bool
    {
        return $this->set('comment_count', 'GREATEST(comment_count - 1, 0)', false)
            ->where('id', $requestId)
            ->update();
    }

    /**
     * Merge a request into another.
     *
     * @param int $fromId
     * @param int $intoId
     * @return bool
     */
    public function mergeInto(int $fromId, int $intoId): bool
    {
        $from = $this->find($fromId);
        $into = $this->find($intoId);

        if (!$from || !$into) {
            return false;
        }

        $this->db->transStart();

        // Update the merged request
        $this->update($fromId, [
            'status'         => 'merged',
            'merged_into_id' => $intoId,
        ]);

        // Transfer votes (skip duplicates)
        $voteModel = model(VoteModel::class);
        $votes = $voteModel->where('request_id', $fromId)->findAll();

        foreach ($votes as $vote) {
            // Check if user already voted for target
            $exists = $voteModel
                ->where('user_id', $vote->user_id)
                ->where('request_id', $intoId)
                ->first();

            if (!$exists) {
                $voteModel->insert([
                    'user_id'    => $vote->user_id,
                    'request_id' => $intoId,
                ]);
            }
        }

        // Recalculate vote count
        $newVoteCount = $voteModel->where('request_id', $intoId)->countAllResults();
        $this->update($intoId, ['vote_count' => $newVoteCount]);

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    /**
     * Get status label and color.
     *
     * @param string $status
     * @return array
     */
    public function getStatusInfo(string $status): array
    {
        return self::STATUS_LABELS[$status] ?? ['label' => 'Unknown', 'color' => 'gray'];
    }
}
