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
            'className' => 'text-center'
        ],
        'name' => [
            'label' => 'trans::admin::roles.name',
            'type' => 'bsText',
            'list' => true,
            'update' => true,
            'searchable' => true,
            'create' => true,
        ],
        'slug' => []
    ];

}
