<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Edit Request<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="<?= base_url('admin/requests') ?>" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Requests
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Request</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update request details and status</p>
        </div>

        <?php if (session()->has('errors')): ?>
            <div class="mb-6 rounded-lg bg-red-50 dark:bg-red-900/20 p-4">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Please fix the following errors:</h3>
                        <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <form action="<?= base_url('admin/requests/' . $request->id) ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Title <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="<?= old('title', $request->title) ?>"
                    required
                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-primary-500"
                >
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Status <span class="text-red-500">*</span>
                </label>
                <select
                    name="status"
                    id="status"
                    required
                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-primary-500"
                >
                    <?php foreach ($statuses as $value => $info): ?>
                        <option value="<?= $value ?>" <?= old('status', $request->status) === $value ? 'selected' : '' ?>>
                            <?= $info['label'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
                <div class="mt-2 flex flex-wrap gap-2">
                    <?php foreach ($statuses as $value => $info): ?>
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-<?= $info['color'] ?>-100 dark:bg-<?= $info['color'] ?>-900/30 text-<?= $info['color'] ?>-800 dark:text-<?= $info['color'] ?>-300">
                            <?= $info['label'] ?>
                        </span>
                    <?php endforeach ?>
                </div>
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Category
                </label>
                <select
                    name="category_id"
                    id="category_id"
                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-primary-500"
                >
                    <option value="">No Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id ?>" <?= old('category_id', $request->category_id) == $category->id ? 'selected' : '' ?>>
                            <?= esc($category->name) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- Admin Response -->
            <div>
                <label for="admin_response" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Official Response
                </label>
                <textarea
                    name="admin_response"
                    id="admin_response"
                    rows="4"
                    placeholder="Add an official response that will be displayed on the request page..."
                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white placeholder-gray-400 focus:border-primary-500 focus:ring-primary-500 resize-y"
                ><?= old('admin_response', $request->admin_response) ?></textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">This will be shown as an official response on the request page.</p>
            </div>

            <!-- Request Info -->
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Request Information</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Votes</dt>
                        <dd class="font-medium text-gray-900 dark:text-white"><?= number_format($request->vote_count) ?></dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Comments</dt>
                        <dd class="font-medium text-gray-900 dark:text-white"><?= number_format($request->comment_count) ?></dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Created</dt>
                        <dd class="font-medium text-gray-900 dark:text-white"><?= date('M j, Y g:i A', strtotime($request->created_at)) ?></dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Last Updated</dt>
                        <dd class="font-medium text-gray-900 dark:text-white"><?= date('M j, Y g:i A', strtotime($request->updated_at)) ?></dd>
                    </div>
                </dl>
            </div>

            <!-- Description (Read-only) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Original Description
                </label>
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 text-sm text-gray-700 dark:text-gray-300">
                    <?= nl2br(esc($request->description)) ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="<?= base_url('requests/' . $request->slug) ?>" target="_blank" class="text-sm text-primary-600 hover:text-primary-500 dark:text-primary-400">
                    View public page →
                </a>
                <div class="flex items-center space-x-3">
                    <a href="<?= base_url('admin/requests') ?>" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
