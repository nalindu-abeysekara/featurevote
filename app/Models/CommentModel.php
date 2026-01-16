<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table            = 'comments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'user_id',
        'request_id',
        'parent_id',
        'body',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id'    => 'required|integer',
        'request_id' => 'required|integer',
        'body'       => 'required|min_length[2]|max_length[5000]',
    ];

    protected $validationMessages = [
        'body' => [
            'required'   => 'Comment text is required.',
            'min_length' => 'Comment must be at least 2 characters.',
            'max_length' => 'Comment cannot exceed 5000 characters.',
        ],
    ];

    protected $skipValidation = false;

    // Callbacks
    protected $afterInsert = ['incrementRequestComments'];
    protected $afterDelete = ['decrementRequestComments'];

    /**
     * Increment request comment count after insert.
     *
     * @param array $data
     * @return array
     */
    protected function incrementRequestComments(array $data): array
    {
        if (isset($data['data']['request_id'])) {
            model(RequestModel::class)->incrementCommentCount($data['data']['request_id']);
        }
        return $data;
    }

    /**
     * Decrement request comment count after delete.
     *
     * @param array $data
     * @return array
     */
    protected function decrementRequestComments(array $data): array
    {
        // Note: The request_id needs to be tracked before deletion
        return $data;
    }

    /**
     * Get user (author) of this comment.
     *
     * @param int $commentId
     * @return object|null
     */
    public function getAuthor(int $commentId)
    {
        $comment = $this->find($commentId);
        if (!$comment) {
            return null;
        }

        return model(UserModel::class)->find($comment->user_id);
    }

    /**
     * Get request for this comment.
     *
     * @param int $commentId
     * @return object|null
     */
    public function getRequest(int $commentId)
    {
        $comment = $this->find($commentId);
        if (!$comment) {
            return null;
        }

        return model(RequestModel::class)->find($comment->request_id);
    }

    /**
     * Get parent comment.
     *
     * @param int $commentId
     * @return object|null
     */
    public function getParent(int $commentId)
    {
        $comment = $this->find($commentId);
        if (!$comment || !$comment->parent_id) {
            return null;
        }

        return $this->find($comment->parent_id);
    }

    /**
     * Get child comments (replies).
     *
     * @param int $commentId
     * @return array
     */
    public function getReplies(int $commentId): array
    {
        return $this->where('parent_id', $commentId)
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

    /**
     * Get comments for a request in threaded format.
     *
     * @param int $requestId
     * @return array
     */
    public function getThreaded(int $requestId): array
    {
        $comments = $this->where('request_id', $requestId)
            ->orderBy('created_at', 'ASC')
            ->findAll();

        $userModel = model(UserModel::class);

        // Add author to each comment
        foreach ($comments as &$comment) {
            $comment->author = $userModel->find($comment->user_id);
        }

        // Build threaded structure
        return $this->buildThread($comments);
    }

    /**
     * Build threaded comment structure.
     *
     * @param array $comments
     * @param int|null $parentId
     * @return array
     */
    protected function buildThread(array $comments, ?int $parentId = null): array
    {
        $branch = [];

        foreach ($comments as $comment) {
            if ($comment->parent_id == $parentId) {
                $comment->replies = $this->buildThread($comments, $comment->id);
                $branch[] = $comment;
            }
        }

        return $branch;
    }

    /**
     * Get all comments for a request (flat list).
     *
     * @param int $requestId
     * @return array
     */
    public function getForRequest(int $requestId): array
    {
        return $this->where('request_id', $requestId)
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

    /**
     * Get comment count for a request.
     *
     * @param int $requestId
     * @return int
     */
    public function getCommentCount(int $requestId): int
    {
        return $this->where('request_id', $requestId)->countAllResults();
    }

    /**
     * Check if user owns this comment.
     *
     * @param int $commentId
     * @param int $userId
     * @return bool
     */
    public function isOwnedBy(int $commentId, int $userId): bool
    {
        $comment = $this->find($commentId);
        return $comment && $comment->user_id == $userId;
    }

    /**
     * Delete comment and all its replies.
     *
     * @param int $commentId
     * @return bool
     */
    public function deleteWithReplies(int $commentId): bool
    {
        $comment = $this->find($commentId);
        if (!$comment) {
            return false;
        }

        $this->db->transStart();

        // Get all reply IDs recursively
        $replyIds = $this->getAllReplyIds($commentId);

        // Delete all replies
        if (!empty($replyIds)) {
            $this->whereIn('id', $replyIds)->delete();
        }

        // Delete the comment itself
        $this->delete($commentId);

        // Update comment count
        $totalDeleted = count($replyIds) + 1;
        $this->db->query(
            "UPDATE requests SET comment_count = GREATEST(comment_count - ?, 0) WHERE id = ?",
            [$totalDeleted, $comment->request_id]
        );

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    /**
     * Get all reply IDs recursively.
     *
     * @param int $parentId
     * @return array
     */
    protected function getAllReplyIds(int $parentId): array
    {
        $ids = [];
        $replies = $this->where('parent_id', $parentId)->findAll();

        foreach ($replies as $reply) {
            $ids[] = $reply->id;
            $ids = array_merge($ids, $this->getAllReplyIds($reply->id));
        }

        return $ids;
    }
}
