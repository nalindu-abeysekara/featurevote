<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Submit a Feature Request<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="<?= base_url() ?>" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Feature Board
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Submit a Feature Request</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Share your idea with the community</p>
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

        <form action="<?= base_url('requests') ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Title <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="<?= old('title') ?>"
                    placeholder="A short, descriptive title for your request"
                    required
                    minlength="5"
                    maxlength="255"
                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-primary-500 focus:ring-primary-500 transition-colors"
                >
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimum 5 characters</p>
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Category
                </label>
                <select
                    name="category_id"
                    id="category_id"
                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 transition-colors"
                >
                    <option value="">Select a category (optional)</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id ?>" <?= old('category_id') == $category->id ? 'selected' : '' ?>>
                            <?= esc($category->name) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea
                    name="description"
                    id="description"
                    rows="6"
                    placeholder="Describe your feature request in detail. What problem does it solve? How would it work?"
                    required
                    minlength="20"
                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-primary-500 focus:ring-primary-500 transition-colors resize-y"
                ><?= old('description') ?></textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimum 20 characters. Be as detailed as possible.</p>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="<?= base_url() ?>" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Submit Request
                </button>
            </div>
        </form>
    </div>

    <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4">
        <div class="flex">
            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Tips for a great request</h3>
                <ul class="mt-2 text-sm text-blue-700 dark:text-blue-300 list-disc list-inside space-y-1">
                    <li>Check if a similar request already exists</li>
                    <li>Be specific about what you want and why</li>
                    <li>Explain the problem you're trying to solve</li>
                    <li>Include any relevant context or examples</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
