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
        ],
        'last_name' => [
            'label' => 'trans::admin::users.last_name',
            'type' => 'bsText',
            'list' => true,
            'update' => true,
            'searchable' => true,
            'orderable' => true,
            'create' => true,
        ],
        'password' => [
            'label' => 'trans::admin::users.password',
            'type' => 'bsPassword',
            'update' => true,
            'create' => true
        ],
        'last_login' => [
            'label' => 'trans::admin::users.last_login',
            'type' => 'bsText',
            'list' => true,
            'transform' => 'timeAgo',
        ]
    ];
}
