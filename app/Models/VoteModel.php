<?php

namespace App\Models;

use CodeIgniter\Model;

class VoteModel extends Model
{
    protected $table            = 'votes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'user_id',
        'request_id',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';

    // Callbacks
    protected $afterInsert = ['incrementRequestVotes'];
    protected $afterDelete = ['decrementRequestVotes'];

    /**
     * Increment request vote count after insert.
     *
     * @param array $data
     * @return array
     */
    protected function incrementRequestVotes(array $data): array
    {
        if (isset($data['data']['request_id'])) {
            model(RequestModel::class)->incrementVoteCount($data['data']['request_id']);
        }
        return $data;
    }

    /**
     * Decrement request vote count after delete.
     *
     * @param array $data
     * @return array
     */
    protected function decrementRequestVotes(array $data): array
    {
        // Note: This requires the request_id to be tracked before deletion
        return $data;
    }

    /**
     * Toggle vote for a user on a request.
     *
     * @param int $userId
     * @param int $requestId
     * @return array ['action' => 'added'|'removed', 'count' => int]
     */
    public function toggle(int $userId, int $requestId): array
    {
        $existing = $this->where('user_id', $userId)
            ->where('request_id', $requestId)
            ->first();

        $requestModel = model(RequestModel::class);

        if ($existing) {
            // Remove vote
            $this->delete($existing->id);
            $requestModel->decrementVoteCount($requestId);

            $request = $requestModel->find($requestId);
            return [
                'action' => 'removed',
                'count'  => $request->vote_count,
            ];
        }

        // Add vote (afterInsert callback handles incrementing vote count)
        $this->insert([
            'user_id'    => $userId,
            'request_id' => $requestId,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $request = $requestModel->find($requestId);
        return [
            'action' => 'added',
            'count'  => $request->vote_count,
        ];
    }

    /**
     * Check if user has voted for a request.
     *
     * @param int $userId
     * @param int $requestId
     * @return bool
     */
    public function hasVoted(int $userId, int $requestId): bool
    {
        return $this->where('user_id', $userId)
            ->where('request_id', $requestId)
            ->countAllResults() > 0;
    }

    /**
     * Get all request IDs that a user has voted for.
     *
     * @param int $userId
     * @return array
     */
    public function getUserVotedRequestIds(int $userId): array
    {
        $votes = $this->where('user_id', $userId)->findAll();
        return array_column((array) $votes, 'request_id');
    }

    /**
     * Get vote count for a request.
     *
     * @param int $requestId
     * @return int
     */
    public function getVoteCount(int $requestId): int
    {
        return $this->where('request_id', $requestId)->countAllResults();
    }

    /**
     * Get voters for a request.
     *
     * @param int $requestId
     * @param int $limit
     * @return array
     */
    public function getVoters(int $requestId, int $limit = 10): array
    {
        $votes = $this->where('request_id', $requestId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();

        $userModel = model(UserModel::class);
        $voters = [];

        foreach ($votes as $vote) {
            $user = $userModel->find($vote->user_id);
            if ($user) {
                $voters[] = $user;
            }
        }

        return $voters;
    }

    /**
     * Get user object for a vote.
     *
     * @param int $voteId
     * @return object|null
     */
    public function getUser(int $voteId)
    {
        $vote = $this->find($voteId);
        if (!$vote) {
            return null;
        }

        return model(UserModel::class)->find($vote->user_id);
    }

    /**
     * Get request object for a vote.
     *
     * @param int $voteId
     * @return object|null
     */
    public function getRequest(int $voteId)
    {
        $vote = $this->find($voteId);
        if (!$vote) {
            return null;
        }

        return model(RequestModel::class)->find($vote->request_id);
    }
}
