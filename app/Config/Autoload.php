<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

class Autoload extends AutoloadConfig
{
    /**
     * PSR-4 namespaces.
     *
     * @var array<string, list<string>|string>
     */
    public $psr4 = [
        APP_NAMESPACE => APPPATH,
    ];

    /**
     * Classmap.
     *
     * @var array<string, string>
     */
    public $classmap = [];

    /**
     * Files to load on every request.
     *
     * @var list<string>
     */
    public $files = [];

    /**
     * Helper files to load on every request.
     *
     * @var list<string>
     */
    public $helpers = ['auth', 'setting', 'url', 'form', 'html', 'vite'];
}
