<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends EntrustRole
{
    use SoftDeletes;
	
	protected $table = 'roles';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

    protected $fillable = [
        'name', 'display_name', 'parent', 'dept'
    ];

	protected $dates = ['deleted_at'];
}
