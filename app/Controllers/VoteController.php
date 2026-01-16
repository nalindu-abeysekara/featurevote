<?php

namespace App\Controllers;

use App\Models\VoteModel;
use App\Models\RequestModel;

class VoteController extends BaseController
{
    protected VoteModel $voteModel;
    protected RequestModel $requestModel;

    public function __construct()
    {
        $this->voteModel = model(VoteModel::class);
        $this->requestModel = model(RequestModel::class);
    }

    /**
     * Toggle vote for a request (HTMX endpoint).
     */
    public function toggle(int $requestId)
    {
        // Check if request exists
        $featureRequest = $this->requestModel->find($requestId);
        if (!$featureRequest) {
            return $this->response->setStatusCode(404)->setBody('Request not found');
        }

        // Toggle the vote
        $userId = auth()->id();
        $result = $this->voteModel->toggle($userId, $requestId);

        // Get updated vote status
        $hasVoted = $result['action'] === 'added';
        $voteCount = $result['count'];

        // Return the updated vote button HTML for HTMX swap
        return $this->renderVoteButton($requestId, $hasVoted, $voteCount);
    }

    /**
     * Render the vote button HTML.
     */
    protected function renderVoteButton(int $requestId, bool $hasVoted, int $voteCount): string
    {
        $buttonClass = $hasVoted
            ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/30'
            : 'border-gray-200 dark:border-gray-600 hover:border-primary-300 dark:hover:border-primary-700';

        $iconClass = $hasVoted
            ? 'text-primary-600 dark:text-primary-400'
            : 'text-gray-400 group-hover:text-primary-500';

        $countClass = $hasVoted
            ? 'text-primary-600 dark:text-primary-400'
            : 'text-gray-700 dark:text-gray-300';

        $iconFill = $hasVoted ? 'currentColor' : 'none';

        return <<<HTML
<div class="flex-shrink-0">
    <button
        hx-post="{$this->request->getUri()->getBaseURL()}votes/toggle/{$requestId}"
        hx-swap="outerHTML"
        hx-target="closest div.flex-shrink-0"
        class="group flex flex-col items-center justify-center w-16 h-16 rounded-xl border-2 transition-all {$buttonClass}"
    >
        <svg class="w-5 h-5 transition-colors {$iconClass}" fill="{$iconFill}" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
        <span class="mt-1 text-sm font-semibold {$countClass}">
            {$voteCount}
        </span>
    </button>
</div>
HTML;
    }
}
