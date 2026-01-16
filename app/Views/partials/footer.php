<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="md:flex md:items-center md:justify-between">
            <!-- Logo & Description -->
            <div class="flex items-center space-x-2">
                <div class="w-6 h-6 bg-primary-600 rounded-md flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    Powered by <span class="font-semibold text-gray-700 dark:text-gray-300">FeatureVote</span>
                </span>
            </div>

            <!-- Links -->
            <div class="mt-4 md:mt-0 flex items-center space-x-6">
                <a href="<?= base_url() ?>" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                    Feature Board
                </a>
                <a href="<?= base_url('roadmap') ?>" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                    Roadmap
                </a>
                <a href="<?= base_url('changelog') ?>" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                    Changelog
                </a>
            </div>

            <!-- Copyright -->
            <div class="mt-4 md:mt-0">
                <p class="text-sm text-gray-400 dark:text-gray-500">
                    &copy; <?= date('Y') ?> All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>
