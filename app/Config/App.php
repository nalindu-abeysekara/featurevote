<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * Base URL of the application.
     */
    public string $baseURL = 'http://localhost:8080/';

    /**
     * Allowed Hostnames in the Site URL.
     *
     * @var list<string>
     */
    public array $allowedHostnames = [];

    /**
     * Index File.
     */
    public string $indexPage = '';

    /**
     * URI Protocol.
     */
    public string $uriProtocol = 'REQUEST_URI';

    /**
     * Default Locale.
     */
    public string $defaultLocale = 'en';

    /**
     * Negotiate Locale.
     */
    public bool $negotiateLocale = false;

    /**
     * Supported Locales.
     *
     * @var list<string>
     */
    public array $supportedLocales = ['en'];

    /**
     * Application Timezone.
     */
    public string $appTimezone = 'UTC';

    /**
     * Default Character Set.
     */
    public string $charset = 'UTF-8';

    /**
     * Force Global Secure Requests.
     */
    public bool $forceGlobalSecureRequests = false;

    /**
     * Reverse Proxy IPs.
     *
     * @var array<string, string>
     */
    public array $proxyIPs = [];

    /**
     * Content Security Policy.
     */
    public bool $CSPEnabled = false;
}
