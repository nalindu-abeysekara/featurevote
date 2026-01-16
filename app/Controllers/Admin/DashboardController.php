<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RequestModel;
use App\Models\CategoryModel;
use App\Models\CommentModel;
use App\Models\VoteModel;

class DashboardController extends BaseController
{
    /**
     * Admin dashboard index.
     */
    public function index()
    {
        // Check if user is admin
        if (!auth()->user()->inGroup('admin')) {
            return redirect()->to('/')->with('error', 'Access denied.');
        }

        $requestModel = model(RequestModel::class);
        $categoryModel = model(CategoryModel::class);
        $commentModel = model(CommentModel::class);
        $voteModel = model(VoteModel::class);

        // Get stats
        $data = [
            'totalRequests'   => $requestModel->countAll(),
            'openRequests'    => $requestModel->where('status', 'open')->countAllResults(),
            'plannedRequests' => $requestModel->where('status', 'planned')->countAllResults(),
            'completedRequests' => $requestModel->where('status', 'completed')->countAllResults(),
            'totalCategories' => $categoryModel->countAll(),
            'totalComments'   => $commentModel->countAll(),
            'totalVotes'      => $voteModel->countAll(),
            'recentRequests'  => $requestModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'topVoted'        => $requestModel->orderBy('vote_count', 'DESC')->limit(5)->findAll(),
        ];

        return view('admin/dashboard', $data);
    }
}
