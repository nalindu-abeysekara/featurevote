<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\Auth as ShieldAuth;
use CodeIgniter\Shield\Authentication\Actions\Email2FA;
use CodeIgniter\Shield\Authentication\Actions\EmailActivator;
use CodeIgniter\Shield\Authentication\Authenticators\AccessTokens;
use CodeIgniter\Shield\Authentication\Authenticators\Session;

class Auth extends ShieldAuth
{
    /**
     * Views used by Shield.
     *
     * @var array<string, string>
     */
    public array $views = [
        'login'                       => '\App\Views\auth\login',
        'register'                    => '\App\Views\auth\register',
        'layout'                      => '\App\Views\layouts\auth',
        'action_email_2fa'            => '\CodeIgniter\Shield\Views\email_2fa_show',
        'action_email_2fa_verify'     => '\CodeIgniter\Shield\Views\email_2fa_verify',
        'action_email_2fa_email'      => '\CodeIgniter\Shield\Views\Email\email_2fa_email',
        'action_email_activate_show'  => '\App\Views\auth\email_activate_show',
        'action_email_activate_email' => '\CodeIgniter\Shield\Views\Email\email_activate_email',
        'magic-link-login'            => '\App\Views\auth\magic_link',
        'magic-link-message'          => '\App\Views\auth\magic_link_message',
        'magic-link-email'            => '\CodeIgniter\Shield\Views\Email\magic_link_email',
    ];

    /**
     * Redirect URLs after authentication actions.
     *
     * @var array<string, string>
     */
    public array $redirects = [
        'register'          => '/',
        'login'             => '/',
        'logout'            => '/',
        'force_reset'       => '/',
        'permission_denied' => '/',
        'group_denied'      => '/',
    ];

    /**
     * The available authentication authenticators.
     *
     * @var array<string, class-string>
     */
    public array $authenticators = [
        'tokens'  => AccessTokens::class,
        'session' => Session::class,
    ];

    /**
     * The default authenticator.
     */
    public string $defaultAuthenticator = 'session';

    /**
     * Actions after registration/login.
     *
     * @var array<string, class-string|null>
     */
    public array $actions = [
        'register' => null,
        'login'    => null,
    ];

    /**
     * Session configuration.
     *
     * @var array<string, bool|string>
     */
    public array $sessionConfig = [
        'field'              => 'user',
        'allowRemembering'   => true,
        'rememberCookieName' => 'remember',
        'rememberLength'     => 30 * DAY,
    ];

    /**
     * Minimum password length.
     */
    public int $minimumPasswordLength = 8;

    /**
     * Password validation rules.
     *
     * @var array<string, array<string>>
     */
    public array $passwordValidationRules = [
        'password' => [
            'required',
            'min_length[8]',
            'max_length[255]',
            'strong_password[]',
        ],
    ];

    /**
     * User provider class.
     */
    public string $userProvider = \App\Models\UserModel::class;

    /**
     * Allow registration.
     */
    public bool $allowRegistration = true;

    /**
     * Record active date.
     */
    public bool $recordActiveDate = true;
}
