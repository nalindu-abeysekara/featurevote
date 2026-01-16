<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center">
        Reset your password
    </h2>
    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 text-center">
        Enter your email and we'll send you a magic link to sign in
    </p>
</div>

<?php if (session('error')): ?>
    <div class="mt-4 rounded-lg bg-red-50 dark:bg-red-900/50 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800 dark:text-red-200"><?= session('error') ?></p>
            </div>
        </div>
    </div>
<?php endif ?>

<form action="<?= url_to('magic-link') ?>" method="post" class="mt-6 space-y-6">
    <?= csrf_field() ?>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Email address
        </label>
        <div class="mt-1">
            <input
                id="email"
                name="email"
                type="email"
                autocomplete="email"
                required
                value="<?= old('email') ?>"
                class="block w-full appearance-none rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2.5 placeholder-gray-400 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-primary-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                placeholder="you@example.com"
            >
        </div>
        <?php if (session('errors.email')): ?>
            <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?= session('errors.email') ?></p>
        <?php endif ?>
    </div>

    <!-- Submit Button -->
    <div>
        <button
            type="submit"
            class="flex w-full justify-center rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-colors"
        >
            Send magic link
        </button>
    </div>
</form>

<!-- Back to Login -->
<p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
    Remember your password?
    <a href="<?= url_to('login') ?>" class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
        Sign in
    </a>
</p>

<?= $this->endSection() ?>
