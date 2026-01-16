<!DOCTYPE html>
<html lang="en" class="h-full" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title><?= $title ?? 'FeatureVote' ?> - <?= setting('App.siteName') ?? 'Feature Voting Board' ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg') ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Vite Assets -->
    <?= vite(['resources/js/app.js', 'resources/css/app.css']) ?>

    <!-- Dark mode script (prevent flash) -->
    <script>
        if (localStorage.getItem('darkMode') === 'true' ||
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900 font-sans antialiased">
    <div class="min-h-full flex flex-col">
        <!-- Header -->
        <?= $this->include('partials/header') ?>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('message')): ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" data-flash-message>
                <div class="rounded-lg bg-green-50 dark:bg-green-900/50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800 dark:text-green-200"><?= session()->getFlashdata('message') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" data-flash-message>
                <div class="rounded-lg bg-red-50 dark:bg-red-900/50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800 dark:text-red-200"><?= session()->getFlashdata('error') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <!-- Main Content -->
        <main class="py-8 flex-grow">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Footer -->
        <?= $this->include('partials/footer') ?>
    </div>
</body>
</html>
