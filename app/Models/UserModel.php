<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;
use App\Entities\User;

class UserModel extends ShieldUserModel
{
    /**
     * Return type for this model.
     *
     * @var string
     */
    protected $returnType = User::class;

    /**
     * Additional allowed fields for the user model.
     *
     * @var array<string>
     */
    protected $allowedFields = [
        'username',
        'status',
        'status_message',
        'active',
        'last_active',
        'avatar',
        'role',
    ];
}
