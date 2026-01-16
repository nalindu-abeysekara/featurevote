<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;

class User extends ShieldUser
{
    /**
     * Additional fillable attributes.
     *
     * @var array<string>
     */
    protected $casts = [
        'active'          => 'int-bool',
        'force_pass_reset' => 'int-bool',
    ];

    /**
     * Get avatar URL or default Gravatar.
     *
     * @return string
     */
    public function getAvatarUrl(): string
    {
        if (!empty($this->avatar)) {
            return base_url('uploads/avatars/' . $this->avatar);
        }

        // Generate Gravatar URL
        $email = $this->email ?? '';
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=150";
    }

    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->inGroup('admin');
    }

    /**
     * Get display name (username or email prefix).
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        if (!empty($this->username)) {
            return $this->username;
        }

        // Use email prefix as fallback
        $email = $this->email ?? 'user';
        return explode('@', $email)[0];
    }

    /**
     * Get user's feature requests.
     *
     * @return array
     */
    public function getRequests(): array
    {
        return model('App\Models\RequestModel')
            ->where('user_id', $this->id)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get user's votes.
     *
     * @return array
     */
    public function getVotes(): array
    {
        return model('App\Models\VoteModel')
            ->where('user_id', $this->id)
            ->findAll();
    }

    /**
     * Get user's comments.
     *
     * @return array
     */
    public function getComments(): array
    {
        return model('App\Models\CommentModel')
            ->where('user_id', $this->id)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Check if user has voted for a specific request.
     *
     * @param int $requestId
     * @return bool
     */
    public function hasVotedFor(int $requestId): bool
    {
        return model('App\Models\VoteModel')
            ->where('user_id', $this->id)
            ->where('request_id', $requestId)
            ->countAllResults() > 0;
    }

    /**
     * Get count of user's requests.
     *
     * @return int
     */
    public function getRequestCount(): int
    {
        return model('App\Models\RequestModel')
            ->where('user_id', $this->id)
            ->countAllResults();
    }

    /**
     * Get count of user's votes.
     *
     * @return int
     */
    public function getVoteCount(): int
    {
        return model('App\Models\VoteModel')
            ->where('user_id', $this->id)
            ->countAllResults();
    }
}
