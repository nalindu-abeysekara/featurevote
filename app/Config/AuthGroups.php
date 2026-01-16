<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * Default user group.
     */
    public string $defaultGroup = 'user';

    /**
     * User groups.
     *
     * @var array<string, array<string, string>>
     */
    public array $groups = [
        'admin' => [
            'title'       => 'Admin',
            'description' => 'Full administrative access to the application.',
        ],
        'user' => [
            'title'       => 'User',
            'description' => 'Regular user with standard access.',
        ],
    ];

    /**
     * Permissions.
     *
     * @var array<string, string>
     */
    public array $permissions = [
        'admin.access'        => 'Can access admin panel',
        'admin.settings'      => 'Can modify application settings',
        'requests.create'     => 'Can create feature requests',
        'requests.edit.own'   => 'Can edit own feature requests',
        'requests.edit.any'   => 'Can edit any feature request',
        'requests.delete.own' => 'Can delete own feature requests',
        'requests.delete.any' => 'Can delete any feature request',
        'requests.moderate'   => 'Can moderate feature requests (change status, respond)',
        'requests.merge'      => 'Can merge duplicate feature requests',
        'comments.create'     => 'Can create comments',
        'comments.edit.own'   => 'Can edit own comments',
        'comments.edit.any'   => 'Can edit any comment',
        'comments.delete.own' => 'Can delete own comments',
        'comments.delete.any' => 'Can delete any comment',
        'users.manage'        => 'Can manage users',
        'categories.manage'   => 'Can manage categories',
        'votes.cast'          => 'Can vote on feature requests',
    ];

    /**
     * Matrix of permissions for each group.
     *
     * @var array<string, array<string>>
     */
    public array $matrix = [
        'admin' => [
            'admin.access',
            'admin.settings',
            'requests.create',
            'requests.edit.own',
            'requests.edit.any',
            'requests.delete.own',
            'requests.delete.any',
            'requests.moderate',
            'requests.merge',
            'comments.create',
            'comments.edit.own',
            'comments.edit.any',
            'comments.delete.own',
            'comments.delete.any',
            'users.manage',
            'categories.manage',
            'votes.cast',
        ],
        'user' => [
            'requests.create',
            'requests.edit.own',
            'requests.delete.own',
            'comments.create',
            'comments.edit.own',
            'comments.delete.own',
            'votes.cast',
        ],
    ];
}
