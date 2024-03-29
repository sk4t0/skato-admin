<?php
/**
 * Code generated using SkatoAdmin
 * Help: http://skato-admin.com
 * SkatoAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Skato IT Solutions
 * Developer Website: http://skatoitsolutions.com
 */

namespace Skato\SkatoAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleFieldTypes extends Model
{
    protected $table = 'module_field_types';
    
    protected $fillable = [
        "name"
    ];
    
    protected $hidden = [
    
    ];
    
    // ModuleFieldTypes::getFTypes()
    public static function getFTypes()
    {
        $fields = ModuleFieldTypes::all();
        $fields2 = array();
        foreach($fields as $field) {
            $fields2[$field['name']] = $field['id'];
        }
        return $fields2;
    }
    
    // ModuleFieldTypes::getFTypes2()
    public static function getFTypes2()
    {
        $fields = ModuleFieldTypes::all();
        $fields2 = array();
        foreach($fields as $field) {
            $fields2[$field['id']] = $field['name'];
        }
        return $fields2;
    }
}
