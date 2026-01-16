<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Admin Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Admin Dashboard</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Overview of your feature voting board</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Requests -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Requests</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($totalRequests) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Open Requests -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Open</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($openRequests) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Votes -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Votes</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($totalVotes) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Comments -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Comments</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($totalComments) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Requests -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Requests</h2>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php if (empty($recentRequests)): ?>
                    <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        No requests yet.
                    </div>
                <?php else: ?>
                    <?php foreach ($recentRequests as $request): ?>
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <a href="<?= base_url('requests/' . $request->slug) ?>" class="text-sm font-medium text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 truncate block">
                                        <?= esc($request->title) ?>
                                    </a>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <?= date('M j, Y', strtotime($request->created_at)) ?>
                                    </p>
                                </div>
                                <span class="ml-4 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?= $request->status === 'open' ? 'yellow' : ($request->status === 'completed' ? 'green' : 'blue') ?>-100 dark:bg-<?= $request->status === 'open' ? 'yellow' : ($request->status === 'completed' ? 'green' : 'blue') ?>-900/30 text-<?= $request->status === 'open' ? 'yellow' : ($request->status === 'completed' ? 'green' : 'blue') ?>-800 dark:text-<?= $request->status === 'open' ? 'yellow' : ($request->status === 'completed' ? 'green' : 'blue') ?>-300">
                                    <?= ucfirst($request->status) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        </div>

        <!-- Top Voted -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Top Voted</h2>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php if (empty($topVoted)): ?>
                    <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        No requests yet.
                    </div>
                <?php else: ?>
                    <?php foreach ($topVoted as $request): ?>
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <a href="<?= base_url('requests/' . $request->slug) ?>" class="text-sm font-medium text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 truncate block">
                                        <?= esc($request->title) ?>
                                    </a>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <?= $request->vote_count ?> votes · <?= $request->comment_count ?> comments
                                    </p>
                                </div>
                                <div class="ml-4 flex items-center text-primary-600 dark:text-primary-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                    <span class="font-semibold"><?= $request->vote_count ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="<?= base_url('admin/requests') ?>" class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Manage Requests</span>
            </a>
            <a href="<?= base_url('admin/categories') ?>" class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Manage Categories</span>
            </a>
            <a href="<?= base_url('admin/users') ?>" class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Manage Users</span>
            </a>
            <a href="<?= base_url('admin/settings') ?>" class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Settings</span>
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
