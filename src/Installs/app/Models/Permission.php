<?php
/**
 * Model genrated using SkatoAdmin
 * Help: http://skato-admin.com
 */

namespace App;

use Zizaco\Entrust\EntrustPermission;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends EntrustPermission
{
    use SoftDeletes;
	
	protected $table = 'permissions';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

    protected $fillable = [
        'name', 'display_name'
    ];

	protected $dates = ['deleted_at'];
}
