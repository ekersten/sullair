<?php

namespace Modules\Admin\Entities;

use Modules\Core\Entities\BaseModel;

class User extends BaseModel
{
    protected static $fields = [
        'id' => [
            'label' => 'ID',
            'type' => '',
            'list' => true,
            'className' => 'text-center'
        ],
        'first_name' => [
            'label' => 'trans::admin::users.first_name',
            'type' => 'bsText',
            'list' => true,
            'update' => true,
            'searchable' => true,
            'orderable' => true,
            'create' => true,
            'validation' => 'required'
        ],
        'last_name' => [
            'label' => 'trans::admin::users.last_name',
            'type' => 'bsText',
            'list' => true,
            'update' => true,
            'searchable' => true,
            'orderable' => true,
            'create' => true,
            'validation' => 'required'
        ],
        'email' => [
            'label' => 'trans::admin::users.email',
            'type' => 'bsText',
            'update' => true,
            'create' => true,
            'validation' => 'required|email'
        ],
        'password' => [
            'label' => 'trans::admin::users.password',
            'type' => 'bsPassword',
            'update' => true,
            'create' => true,
            'validation' => 'required'
        ],
        'last_login' => [
            'label' => 'trans::admin::users.last_login',
            'type' => 'bsText',
            'list' => true,
            'transform' => 'timeAgo',
        ]
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }
}
