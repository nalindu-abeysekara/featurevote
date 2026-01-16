<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?><?= esc($request->title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="<?= base_url() ?>" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Feature Board
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

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <!-- Vote Section -->
                <div class="flex-shrink-0">
                    <button
                        <?php if (auth()->loggedIn()): ?>
                            hx-post="<?= base_url('votes/toggle/' . $request->id) ?>"
                            hx-swap="outerHTML"
                            hx-target="#vote-btn-<?= $request->id ?>"
                        <?php else: ?>
                            onclick="window.location.href='<?= url_to('login') ?>'"
                        <?php endif ?>
                        id="vote-btn-<?= $request->id ?>"
                        class="flex flex-col items-center justify-center w-16 h-20 rounded-lg border-2 transition-all <?= $hasVoted ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20 text-primary-600' : 'border-gray-200 dark:border-gray-600 hover:border-primary-300 dark:hover:border-primary-700 text-gray-500 dark:text-gray-400' ?>"
                    >
                        <svg class="w-5 h-5 <?= $hasVoted ? 'text-primary-600' : '' ?>" fill="<?= $hasVoted ? 'currentColor' : 'none' ?>" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                        </svg>
                        <span class="text-lg font-bold mt-1"><?= number_format($request->vote_count) ?></span>
                    </button>
                </div>

                <!-- Content Section -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-3 mb-2">
                        <?php if ($category): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: <?= esc($category->color) ?>20; color: <?= esc($category->color) ?>">
                                <?= esc($category->name) ?>
                            </span>
                        <?php endif ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?= $statusInfo['color'] ?>-100 dark:bg-<?= $statusInfo['color'] ?>-900/30 text-<?= $statusInfo['color'] ?>-800 dark:text-<?= $statusInfo['color'] ?>-300">
                            <?= $statusInfo['label'] ?>
                        </span>
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">
                        <?= esc($request->title) ?>
                    </h1>

                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <?php if ($author): ?>
                            <img src="<?= $author->getAvatarUrl() ?>" alt="<?= esc($author->username) ?>" class="w-6 h-6 rounded-full mr-2">
                            <span><?= esc($author->username) ?></span>
                            <span class="mx-2">·</span>
                        <?php endif ?>
                        <span><?= date('M j, Y', strtotime($request->created_at)) ?></span>
                        <span class="mx-2">·</span>
                        <span><?= $request->comment_count ?> <?= $request->comment_count == 1 ? 'comment' : 'comments' ?></span>
                    </div>

                    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                        <?= nl2br(esc($request->description)) ?>
                    </div>

                    <?php if ($request->admin_response): ?>
                        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span class="font-semibold text-blue-800 dark:text-blue-200">Official Response</span>
                            </div>
                            <p class="text-blue-700 dark:text-blue-300"><?= nl2br(esc($request->admin_response)) ?></p>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Comments (<?= $request->comment_count ?>)
            </h2>

            <?php if (auth()->loggedIn()): ?>
                <form action="<?= base_url('comments/' . $request->id) ?>" method="post" class="mb-6">
                    <?= csrf_field() ?>
                    <textarea
                        name="content"
                        rows="3"
                        placeholder="Add a comment..."
                        required
                        class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-primary-500 focus:ring-primary-500 transition-colors resize-y"
                    ></textarea>
                    <div class="mt-2 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                            Post Comment
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-center">
                    <p class="text-gray-600 dark:text-gray-400">
                        <a href="<?= url_to('login') ?>" class="text-primary-600 hover:text-primary-500 font-medium">Sign in</a>
                        to leave a comment.
                    </p>
                </div>
            <?php endif ?>

            <?php if (empty($comments)): ?>
                <p class="text-center text-gray-500 dark:text-gray-400 py-8">No comments yet. Be the first to share your thoughts!</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($comments as $comment): ?>
                        <div class="flex space-x-3" id="comment-<?= $comment->id ?>">
                            <img src="<?= $comment->author->getAvatarUrl() ?>" alt="<?= esc($comment->author->username) ?>" class="w-8 h-8 rounded-full flex-shrink-0">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <span class="font-medium text-gray-900 dark:text-white"><?= esc($comment->author->username) ?></span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400"><?= date('M j, Y g:i A', strtotime($comment->created_at)) ?></span>
                                </div>
                                <p class="mt-1 text-gray-700 dark:text-gray-300"><?= nl2br(esc($comment->body)) ?></p>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
