<?php
namespace App\Observers;

use App\Notifications\NewPermission;
use App\Permission;
use App\Role;

class PermissionsObserver
{
    public function created(Permission $permission)
    {
        $admins = Role::where('name', 'SUPER_ADMIN')->first()->users()->get();
        foreach ($admins as $user) {
            $user->notify(new NewPermission($permission, \Auth::user()));
        }
    }
}
