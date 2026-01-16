<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    /**
     * The default template to use.
     */
    public string $defaultTemplate = 'tailwind_full';

    /**
     * Pagination templates.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'default_full'   => 'CodeIgniter\Pager\Views\default_full',
        'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
        'default_head'   => 'CodeIgniter\Pager\Views\default_head',
        'tailwind_full'  => 'App\Views\Pagers\tailwind_full',
    ];

    /**
     * Number of links per page.
     */
    public int $perPage = 20;
}
