<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;
	
	protected $table = 'organizations';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profile_image', 'name', 'email', 'phone', 'website', 'assigned_to', 'city'
    ];

	protected $dates = ['deleted_at'];
}
