<?php

namespace Modules\Admin\Entities;



use Modules\Core\Entities\BaseModel;

class Role extends BaseModel
{
    protected static $fields = [
        'id' => [
            'label' => 'ID',
            'type' => '',
            'list' => true,
            'create' => false,
            'update' => false,
        ],
        'name' => [
            'label' => 'trans::admin::roles.name',
            'type' => 'bsText',
            'list' => true,
            'create' => false,
            'update' => true,
        ],
        'slug' => [
            'list' => false,
            'create' => false,
            'update' => false,
        ]
    ];

}
