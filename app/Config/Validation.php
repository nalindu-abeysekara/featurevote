<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    /**
     * Stores the classes that contain the rules.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Custom Validation Rules
    // --------------------------------------------------------------------

    /**
     * Request validation rules.
     *
     * @var array<string, array<string, string>>
     */
    public array $request = [
        'title' => [
            'rules'  => 'required|min_length[5]|max_length[100]',
            'errors' => [
                'required'   => 'Please enter a title for your request.',
                'min_length' => 'Title must be at least 5 characters.',
                'max_length' => 'Title cannot exceed 100 characters.',
            ],
        ],
        'description' => [
            'rules'  => 'required|min_length[20]|max_length[2000]',
            'errors' => [
                'required'   => 'Please provide a description.',
                'min_length' => 'Description must be at least 20 characters.',
                'max_length' => 'Description cannot exceed 2000 characters.',
            ],
        ],
        'category_id' => [
            'rules'  => 'permit_empty|integer',
            'errors' => [
                'integer' => 'Invalid category selected.',
            ],
        ],
    ];

    /**
     * Comment validation rules.
     *
     * @var array<string, array<string, string>>
     */
    public array $comment = [
        'body' => [
            'rules'  => 'required|min_length[2]|max_length[5000]',
            'errors' => [
                'required'   => 'Please enter a comment.',
                'min_length' => 'Comment is too short.',
                'max_length' => 'Comment cannot exceed 5000 characters.',
            ],
        ],
    ];

    /**
     * Category validation rules.
     *
     * @var array<string, array<string, string>>
     */
    public array $category = [
        'name' => [
            'rules'  => 'required|min_length[2]|max_length[50]',
            'errors' => [
                'required'   => 'Category name is required.',
                'min_length' => 'Category name is too short.',
                'max_length' => 'Category name cannot exceed 50 characters.',
            ],
        ],
        'color' => [
            'rules'  => 'required|regex_match[/^#[0-9A-Fa-f]{6}$/]',
            'errors' => [
                'required'    => 'Please select a color.',
                'regex_match' => 'Invalid color format.',
            ],
        ],
    ];
}
