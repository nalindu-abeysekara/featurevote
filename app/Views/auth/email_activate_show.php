<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<div class="text-center">
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-primary-100 dark:bg-primary-900">
        <svg class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
    </div>
    <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
        Check your email
    </h2>
    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
        We've sent a verification link to <strong class="text-gray-900 dark:text-white"><?= esc($user->email ?? '') ?></strong>
    </p>
</div>

<div class="mt-6 space-y-4">
    <div class="rounded-lg bg-gray-50 dark:bg-gray-700/50 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Click the link in the email to verify your account. The link will expire in 24 hours.
                </p>
            </div>
        </div>
    </div>

    <p class="text-center text-sm text-gray-600 dark:text-gray-400">
        Didn't receive the email? Check your spam folder or
    </p>

    <form action="<?= url_to('auth-action-verify') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="email" value="<?= esc($user->email ?? '') ?>">
        <button
            type="submit"
            class="flex w-full justify-center rounded-lg bg-white dark:bg-gray-700 px-4 py-2.5 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors"
        >
            Resend verification email
        </button>
    </form>
</div>

<div class="mt-6 text-center">
    <a href="<?= base_url() ?>" class="text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
        &larr; Back to home
    </a>
</div>

<?= $this->endSection() ?>
