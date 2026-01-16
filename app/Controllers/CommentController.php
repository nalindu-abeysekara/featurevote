<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\RequestModel;

class CommentController extends BaseController
{
    protected CommentModel $commentModel;
    protected RequestModel $requestModel;

    public function __construct()
    {
        $this->commentModel = model(CommentModel::class);
        $this->requestModel = model(RequestModel::class);
    }

    /**
     * Store a new comment.
     */
    public function store(int $requestId)
    {
        // Check if request exists
        $featureRequest = $this->requestModel->find($requestId);
        if (!$featureRequest) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Validate
        $rules = [
            'content' => 'required|min_length[2]|max_length[5000]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Create comment
        $data = [
            'user_id'    => auth()->id(),
            'request_id' => $requestId,
            'body'       => $this->request->getPost('content'),
            'parent_id'  => $this->request->getPost('parent_id') ?: null,
        ];

        $this->commentModel->insert($data);

        return redirect()->to('/requests/' . $featureRequest->slug)
            ->with('message', 'Your comment has been posted!');
    }

    /**
     * Delete a comment.
     */
    public function delete(int $commentId)
    {
        $comment = $this->commentModel->find($commentId);

        if (!$comment) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Check ownership or admin
        if ($comment->user_id !== auth()->id() && !auth()->user()->inGroup('admin')) {
            return redirect()->back()->with('error', 'You are not authorized to delete this comment.');
        }

        $featureRequest = $this->requestModel->find($comment->request_id);

        // Delete comment and its replies
        $this->commentModel->deleteWithReplies($commentId);

        return redirect()->to('/requests/' . $featureRequest->slug)
            ->with('message', 'Comment deleted successfully.');
    }
}
