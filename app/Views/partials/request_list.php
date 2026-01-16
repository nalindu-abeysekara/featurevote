<?php if (empty($requests)): ?>
    <!-- Empty State -->
    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
        </svg>
        <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">No feature requests</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new feature request.</p>
        <?php if (auth()->loggedIn()): ?>
            <div class="mt-6">
                <a href="<?= base_url('requests/create') ?>" class="inline-flex items-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Request
                </a>
            </div>
        <?php endif ?>
    </div>
<?php else: ?>
    <!-- Request Cards -->
    <div class="space-y-4">
        <?php foreach ($requests as $request): ?>
            <?php
                $categoryModel = model('App\Models\CategoryModel');
                $category = $request->category_id ? $categoryModel->find($request->category_id) : null;
                $hasVoted = in_array($request->id, $votedIds ?? []);
                $statusInfo = model('App\Models\RequestModel')->getStatusInfo($request->status);
            ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                <div class="p-5 flex items-start gap-4">
                    <!-- Vote Button -->
                    <div class="flex-shrink-0">
                        <button
                            <?php if (auth()->loggedIn()): ?>
                                hx-post="<?= base_url('votes/toggle/' . $request->id) ?>"
                                hx-swap="outerHTML"
                                hx-target="closest div.flex-shrink-0"
                            <?php else: ?>
                                onclick="window.location.href='<?= url_to('login') ?>'"
                            <?php endif ?>
                            class="group flex flex-col items-center justify-center w-16 h-16 rounded-xl border-2 transition-all <?= $hasVoted ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/30' : 'border-gray-200 dark:border-gray-600 hover:border-primary-300 dark:hover:border-primary-700' ?>"
                        >
                            <svg class="w-5 h-5 transition-colors <?= $hasVoted ? 'text-primary-600 dark:text-primary-400' : 'text-gray-400 group-hover:text-primary-500' ?>" fill="<?= $hasVoted ? 'currentColor' : 'none' ?>" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                            <span class="mt-1 text-sm font-semibold <?= $hasVoted ? 'text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300' ?>">
                                <?= number_format($request->vote_count) ?>
                            </span>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <a href="<?= base_url('requests/' . $request->slug) ?>" class="block group">
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors truncate">
                                        <?= esc($request->title) ?>
                                    </h3>
                                </a>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                    <?= esc(substr($request->description, 0, 150)) ?><?= strlen($request->description) > 150 ? '...' : '' ?>
                                </p>
                            </div>

                            <!-- Status Badge -->
                            <?php
                                $statusColors = [
                                    'open' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                    'under_review' => 'bg-violet-100 text-violet-700 dark:bg-violet-900/50 dark:text-violet-300',
                                    'planned' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300',
                                    'in_progress' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300',
                                    'completed' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300',
                                    'closed' => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300',
                                    'merged' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300',
                                ];
                            ?>
                            <span class="flex-shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusColors[$request->status] ?? $statusColors['open'] ?>">
                                <?= esc($statusInfo['label']) ?>
                            </span>
                        </div>

                        <!-- Meta -->
                        <div class="mt-3 flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                            <?php if ($category): ?>
                                <span class="inline-flex items-center">
                                    <span class="w-2 h-2 rounded-full mr-1.5" style="background-color: <?= esc($category->color) ?>"></span>
                                    <?= esc($category->name) ?>
                                </span>
                            <?php endif ?>

                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <?= $request->comment_count ?> comments
                            </span>

                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <?= date('M j, Y', strtotime($request->created_at)) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>

    <!-- Pagination -->
    <?php if (isset($pager)): ?>
        <div class="mt-6">
            <?= $pager->links('default', 'tailwind_full') ?>
        </div>
    <?php endif ?>
<?php endif ?>
