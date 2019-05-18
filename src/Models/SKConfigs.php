<?php
/**
 * Code generated using SkatoAdmin
 * Help: http://skato-admin.com
 * SkatoAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Dwij IT Solutions
 * Developer Website: http://skatoitsolutions.com
 */

namespace Skato\SkatoAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Exception;
use Log;
use DB;
use Skato\SkatoAdmin\Helpers\skHelper;

/**
 * Class SKConfigs
 * @package Skato\SkatoAdmin\Models
 *
 * Config Class looks after SkatoAdmin configurations.
 * Check details on http://skato-admin.com/docs
 */
class SKConfigs extends Model
{
    protected $table = 'sk_configs';
    
    protected $fillable = [
        "key", "value"
    ];
    
    protected $hidden = [
    
    ];
    
    /**
     * Get configuration string value by using key such as 'sitename'
     *
     * SKConfigs::getByKey('sitename');
     *
     * @param $key key string of configuration
     * @return bool value of configuration
     */
    public static function getByKey($key)
    {
        $row = SKConfigs::where('key', $key)->first();
        if(isset($row->value)) {
            return $row->value;
        } else {
            return false;
        }
    }
    
    /**
     * Get all configuration as object
     *
     * SKConfigs::getAll();
     *
     * @return object
     */
    public static function getAll()
    {
        $configs = array();
        $configs_db = SKConfigs::all();
        foreach($configs_db as $row) {
            $configs[$row->key] = $row->value;
        }
        return (object)$configs;
    }
}
