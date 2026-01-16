<?php

namespace App\Controllers;

use App\Models\RequestModel;
use App\Models\CategoryModel;
use App\Models\SettingModel;

class Home extends BaseController
{
    protected RequestModel $requestModel;
    protected CategoryModel $categoryModel;
    protected SettingModel $settingModel;

    public function __construct()
    {
        $this->requestModel = model(RequestModel::class);
        $this->categoryModel = model(CategoryModel::class);
        $this->settingModel = model(SettingModel::class);
    }

    /**
     * Display the home page with feature requests.
     */
    public function index()
    {
        $filters = [
            'status'      => $this->request->getGet('status'),
            'category_id' => $this->request->getGet('category'),
            'search'      => $this->request->getGet('search'),
            'sort'        => $this->request->getGet('sort') ?? 'vote_count',
            'direction'   => $this->request->getGet('direction') ?? 'DESC',
        ];

        $perPage = (int) $this->settingModel->get('items_per_page', 20);
        $result = $this->requestModel->getFiltered($filters, $perPage);

        // Get voted request IDs for current user
        $votedIds = [];
        if (auth()->loggedIn()) {
            $voteModel = model(\App\Models\VoteModel::class);
            $votedIds = $voteModel->getUserVotedRequestIds(auth()->id());
        }

        $data = [
            'requests'   => $result['requests'],
            'pager'      => $result['pager'],
            'categories' => $this->categoryModel->getOrdered(),
            'filters'    => $filters,
            'votedIds'   => $votedIds,
            'settings'   => $this->settingModel->getAll(),
        ];

        // Return partial view for HTMX requests
        if ($this->isHtmxRequest()) {
            return view('partials/request_list', $data);
        }

        return view('home', $data);
    }
}
