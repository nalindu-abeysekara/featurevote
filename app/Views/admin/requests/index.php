<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Manage Requests<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manage Requests</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">View and manage all feature requests</p>
        </div>
        <a href="<?= base_url('admin') ?>" class="inline-flex items-center text-sm text-gray-500 hover:text-primary-600">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    <?php if (session()->has('message')): ?>
        <div class="mb-6 rounded-lg bg-green-50 dark:bg-green-900/20 p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="ml-3 text-sm text-green-700 dark:text-green-300"><?= esc(session('message')) ?></p>
            </div>
        </div>
    <?php endif ?>

    <!-- Filters -->
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <form method="get" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input
                    type="text"
                    name="search"
                    value="<?= esc($filters['search'] ?? '') ?>"
                    placeholder="Search requests..."
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:border-primary-500 focus:ring-primary-500"
                >
            </div>
            <div>
                <select name="status" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-sm text-gray-900 dark:text-white focus:border-primary-500 focus:ring-primary-500">
                    <option value="">All Status</option>
                    <?php foreach ($statuses as $status): ?>
                        <option value="<?= $status ?>" <?= ($filters['status'] ?? '') === $status ? 'selected' : '' ?>>
                            <?= ucwords(str_replace('_', ' ', $status)) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div>
                <select name="category" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-sm text-gray-900 dark:text-white focus:border-primary-500 focus:ring-primary-500">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id ?>" <?= ($filters['category'] ?? '') == $category->id ? 'selected' : '' ?>>
                            <?= esc($category->name) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Filter
                </button>
            </div>
            <?php if (!empty($filters['search']) || !empty($filters['status']) || !empty($filters['category'])): ?>
                <div>
                    <a href="<?= base_url('admin/requests') ?>" class="inline-flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        Clear filters
                    </a>
                </div>
            <?php endif ?>
        </form>
    </div>

    <!-- Requests Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <?php if (empty($requests)): ?>
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No requests found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your filters.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Request
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Category
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Votes
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Comments
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php foreach ($requests as $request): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div>
                                            <a href="<?= base_url('requests/' . $request->slug) ?>" class="text-sm font-medium text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400" target="_blank">
                                                <?= esc($request->title) ?>
                                            </a>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">
                                                <?= esc(substr($request->description, 0, 60)) ?>...
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $statusColors = [
                                        'open' => 'yellow',
                                        'under_review' => 'blue',
                                        'planned' => 'purple',
                                        'in_progress' => 'indigo',
                                        'completed' => 'green',
                                        'closed' => 'gray',
                                    ];
                                    $color = $statusColors[$request->status] ?? 'gray';
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?= $color ?>-100 dark:bg-<?= $color ?>-900/30 text-<?= $color ?>-800 dark:text-<?= $color ?>-300">
                                        <?= ucwords(str_replace('_', ' ', $request->status)) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $category = null;
                                    foreach ($categories as $cat) {
                                        if ($cat->id == $request->category_id) {
                                            $category = $cat;
                                            break;
                                        }
                                    }
                                    ?>
                                    <?php if ($category): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: <?= esc($category->color) ?>20; color: <?= esc($category->color) ?>">
                                            <?= esc($category->name) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-400 dark:text-gray-500 text-sm">—</span>
                                    <?php endif ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white"><?= number_format($request->vote_count) ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400"><?= number_format($request->comment_count) ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <?= date('M j, Y', strtotime($request->created_at)) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="<?= base_url('admin/requests/' . $request->id . '/edit') ?>" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                            Edit
                                        </a>
                                        <form action="<?= base_url('admin/requests/' . $request->id . '/delete') ?>" method="post" class="inline" onsubmit="return confirm('Are you sure you want to delete this request?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($pager->getPageCount() > 1): ?>
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <?= $pager->links('default', 'tailwind_full') ?>
                </div>
            <?php endif ?>
        <?php endif ?>
    </div>
</div>
<?= $this->endSection() ?>
