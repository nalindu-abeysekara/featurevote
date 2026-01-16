<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RequestModel;
use App\Models\CategoryModel;

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
     * List all requests for admin management.
     */
    public function index()
    {
        $status = $this->request->getGet('status');
        $category = $this->request->getGet('category');
        $search = $this->request->getGet('search');

        $builder = $this->requestModel;

        if ($status) {
            $builder = $builder->where('status', $status);
        }

        if ($category) {
            $builder = $builder->where('category_id', $category);
        }

        if ($search) {
            $builder = $builder->groupStart()
                ->like('title', $search)
                ->orLike('description', $search)
                ->groupEnd();
        }

        $data = [
            'requests'   => $builder->orderBy('created_at', 'DESC')->paginate(20),
            'pager'      => $this->requestModel->pager,
            'categories' => $this->categoryModel->getOrdered(),
            'statuses'   => ['open', 'under_review', 'planned', 'in_progress', 'completed', 'closed'],
            'filters'    => [
                'status'   => $status,
                'category' => $category,
                'search'   => $search,
            ],
        ];

        return view('admin/requests/index', $data);
    }

    /**
     * Edit request form.
     */
    public function edit(int $id)
    {
        $request = $this->requestModel->find($id);

        if (!$request) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'request'    => $request,
            'categories' => $this->categoryModel->getOrdered(),
            'statuses'   => [
                'open'        => ['label' => 'Open', 'color' => 'yellow'],
                'under_review'=> ['label' => 'Under Review', 'color' => 'blue'],
                'planned'     => ['label' => 'Planned', 'color' => 'purple'],
                'in_progress' => ['label' => 'In Progress', 'color' => 'indigo'],
                'completed'   => ['label' => 'Completed', 'color' => 'green'],
                'closed'      => ['label' => 'Closed', 'color' => 'gray'],
            ],
        ];

        return view('admin/requests/edit', $data);
    }

    /**
     * Update request.
     */
    public function update(int $id)
    {
        $existingRequest = $this->requestModel->find($id);

        if (!$existingRequest) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'title'          => 'required|min_length[5]|max_length[255]',
            'status'         => 'required|in_list[open,under_review,planned,in_progress,completed,closed]',
            'category_id'    => 'permit_empty|integer',
            'admin_response' => 'permit_empty|max_length[5000]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'          => $this->request->getPost('title'),
            'status'         => $this->request->getPost('status'),
            'category_id'    => $this->request->getPost('category_id') ?: null,
            'admin_response' => $this->request->getPost('admin_response') ?: null,
        ];

        // Use database query builder directly for the update
        $db = \Config\Database::connect();
        $builder = $db->table('requests');
        $result = $builder->where('id', $id)->update($data);

        if (!$result) {
            return redirect()->back()->withInput()->with('errors', ['Update failed. Please try again.']);
        }

        return redirect()->to('/admin/requests')
            ->with('message', 'Request updated successfully.');
    }

    /**
     * Delete request.
     */
    public function delete(int $id)
    {
        $request = $this->requestModel->find($id);

        if (!$request) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->requestModel->delete($id);

        return redirect()->to('/admin/requests')
            ->with('message', 'Request deleted successfully.');
    }

    /**
     * Merge request into another.
     */
    public function merge(int $id)
    {
        $request = $this->requestModel->find($id);

        if (!$request) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $targetId = $this->request->getPost('target_id');
        $target = $this->requestModel->find($targetId);

        if (!$target || $target->id === $request->id) {
            return redirect()->back()->with('error', 'Invalid target request.');
        }

        // Merge votes and comments would go here
        // For now, just update the merged_into field
        $this->requestModel->update($id, [
            'merged_into' => $targetId,
            'status'      => 'closed',
        ]);

        return redirect()->to('/admin/requests')
            ->with('message', 'Request merged successfully.');
    }
}
