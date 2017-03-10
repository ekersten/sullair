<?php
namespace Modules\Core\Entities;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    protected static $fields;
    protected static $name;

    private static $field_defaults = [
        'type' => 'text',
        'list' => false,
        'create' => false,
        'update' => false,
        'searchable' => false,
        'orderable' => false,
        'className' => '',
        'transform' => false,
        'validation' => ''
    ];

    public static function getFields() {
        return self::getFilteredFields();
    }

    public static function getListFields() {
        return self::getFilteredFields('list');
    }

    public static function getCreateFields() {
        return self::getFilteredFields('create');
    }

    public static function getUpdateFields() {
        return self::getFilteredFields('update');
    }

    public static function getTransformFields(){
        return self::getFilteredFields('transform');
    }

    public static function getValidationFields($subset = null){
        return self::getFilteredFields('validation', $subset);
    }

    private static function processField($props) {
        if(isset($props['label']) && strpos($props['label'], 'trans::') >= 0) {
            $props['label'] = trans(str_replace('trans::', '', $props['label']));
        }

        return array_merge(self::$field_defaults, $props);
    }

    private static function getFilteredFields($property = null, $subset= null) {
        $return_fields = [];
        $fields = static::$fields;
        if ($subset !== null) {
            $fields = $subset;
        }
        foreach($fields as $field => $field_props) {
            if(isset($field_props[$property]) && boolval($field_props[$property]) || $property === null) {
                $return_fields[$field] = static::processField($field_props);
            }
        }

        return $return_fields;
    }

}