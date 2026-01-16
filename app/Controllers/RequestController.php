<?php

namespace App\Controllers;

use App\Models\RequestModel;
use App\Models\CategoryModel;
use App\Models\VoteModel;
use App\Models\CommentModel;

class RequestController extends BaseController
{
    protected RequestModel $requestModel;
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->requestModel = model(RequestModel::class);
        $this->categoryModel = model(CategoryModel::class);
    }

    /**
     * List all feature requests.
     */
    public function index()
    {
        return redirect()->to('/');
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $data = [
            'categories' => $this->categoryModel->getOrdered(),
        ];

        return view('requests/create', $data);
    }

    /**
     * Store new feature request.
     */
    public function store()
    {
        $rules = [
            'title'       => 'required|min_length[5]|max_length[255]',
            'description' => 'required|min_length[20]',
            'category_id' => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'user_id'     => auth()->id(),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'category_id' => $this->request->getPost('category_id') ?: null,
            'status'      => 'open',
            'vote_count'  => 1, // Auto-upvote own request
        ];

        $requestId = $this->requestModel->insert($data);

        if ($requestId) {
            // Auto-vote for own request
            $voteModel = model(VoteModel::class);
            $voteModel->insert([
                'user_id'    => auth()->id(),
                'request_id' => $requestId,
            ]);

            $request = $this->requestModel->find($requestId);
            return redirect()->to('/requests/' . $request->slug)
                ->with('message', 'Your feature request has been submitted successfully!');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create feature request. Please try again.');
    }

    /**
     * Show single feature request.
     */
    public function show($slug)
    {
        $request = $this->requestModel->findBySlug($slug);

        if (!$request) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get related data
        $author = $this->requestModel->getAuthor($request->id);
        $category = $request->category_id ? $this->categoryModel->find($request->category_id) : null;
        $comments = $this->requestModel->getThreadedComments($request->id);

        // Check if current user voted
        $hasVoted = false;
        if (auth()->loggedIn()) {
            $voteModel = model(VoteModel::class);
            $hasVoted = $voteModel->hasVoted(auth()->id(), $request->id);
        }

        // Get merged requests if any
        $mergedRequests = $this->requestModel->getMergedRequests($request->id);

        $data = [
            'request'        => $request,
            'author'         => $author,
            'category'       => $category,
            'comments'       => $comments,
            'hasVoted'       => $hasVoted,
            'mergedRequests' => $mergedRequests,
            'statusInfo'     => $this->requestModel->getStatusInfo($request->status),
        ];

        return view('requests/show', $data);
    }

    /**
     * Get requests by category.
     */
    public function byCategory($slug)
    {
        $category = $this->categoryModel->where('slug', $slug)->first();

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return redirect()->to('/?category=' . $category->id);
    }
}
