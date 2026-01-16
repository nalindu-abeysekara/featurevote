<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="text-center mb-10">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">
            <?= esc($settings['site_name'] ?? 'Feature Voting Board') ?>
        </h1>
        <p class="mt-3 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
            <?= esc($settings['site_description'] ?? 'Share your ideas and vote on features you want to see') ?>
        </p>
        <?php if (auth()->loggedIn()): ?>
            <div class="mt-6">
                <a href="<?= base_url('requests/create') ?>" class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-colors">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Submit a Request
                </a>
            </div>
        <?php else: ?>
            <div class="mt-6">
                <a href="<?= url_to('register') ?>" class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-colors">
                    Get Started to Submit Ideas
                </a>
            </div>
        <?php endif ?>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <!-- Search -->
            <div class="relative flex-1 max-w-md">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input
                    type="text"
                    name="search"
                    placeholder="Search feature requests..."
                    value="<?= esc($filters['search'] ?? '') ?>"
                    hx-get="<?= base_url() ?>"
                    hx-trigger="keyup changed delay:500ms"
                    hx-target="#request-list"
                    hx-include="[name='status'], [name='category'], [name='sort']"
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 pl-10 pr-3 py-2 text-sm placeholder-gray-400 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                >
            </div>

            <!-- Filters -->
            <div class="flex items-center space-x-3">
                <!-- Status Filter -->
                <select
                    name="status"
                    hx-get="<?= base_url() ?>"
                    hx-trigger="change"
                    hx-target="#request-list"
                    hx-include="[name='search'], [name='category'], [name='sort']"
                    class="rounded-lg border-gray-300 dark:border-gray-600 py-2 pl-3 pr-8 text-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                >
                    <option value="">All Status</option>
                    <option value="open" <?= ($filters['status'] ?? '') === 'open' ? 'selected' : '' ?>>Open</option>
                    <option value="under_review" <?= ($filters['status'] ?? '') === 'under_review' ? 'selected' : '' ?>>Under Review</option>
                    <option value="planned" <?= ($filters['status'] ?? '') === 'planned' ? 'selected' : '' ?>>Planned</option>
                    <option value="in_progress" <?= ($filters['status'] ?? '') === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="completed" <?= ($filters['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>

                <!-- Category Filter -->
                <select
                    name="category"
                    hx-get="<?= base_url() ?>"
                    hx-trigger="change"
                    hx-target="#request-list"
                    hx-include="[name='search'], [name='status'], [name='sort']"
                    class="rounded-lg border-gray-300 dark:border-gray-600 py-2 pl-3 pr-8 text-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                >
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id ?>" <?= ($filters['category_id'] ?? '') == $category->id ? 'selected' : '' ?>>
                            <?= esc($category->name) ?>
                        </option>
                    <?php endforeach ?>
                </select>

                <!-- Sort -->
                <select
                    name="sort"
                    hx-get="<?= base_url() ?>"
                    hx-trigger="change"
                    hx-target="#request-list"
                    hx-include="[name='search'], [name='status'], [name='category']"
                    class="rounded-lg border-gray-300 dark:border-gray-600 py-2 pl-3 pr-8 text-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                >
                    <option value="vote_count" <?= ($filters['sort'] ?? 'vote_count') === 'vote_count' ? 'selected' : '' ?>>Most Voted</option>
                    <option value="created_at" <?= ($filters['sort'] ?? '') === 'created_at' ? 'selected' : '' ?>>Newest</option>
                    <option value="comment_count" <?= ($filters['sort'] ?? '') === 'comment_count' ? 'selected' : '' ?>>Most Discussed</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Request List -->
    <div id="request-list">
        <?= $this->include('partials/request_list') ?>
    </div>
</div>

<?= $this->endSection() ?>
