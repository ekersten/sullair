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
        ],
        'name' => [
            'label' => 'trans::admin::roles.name',
            'type' => 'bsText',
            'list' => true,
            'update' => true,
        ],
        'slug' => []
    ];

}
