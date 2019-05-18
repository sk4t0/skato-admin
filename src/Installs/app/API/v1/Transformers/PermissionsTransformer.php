<?php
/**
 * Created by PhpStorm.
 * User: skato
 * Date: 25/09/17
 * Time: 11.33
 */
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use App\Permission;

class PermissionsTransformer extends TransformerAbstract
{
    public function transform(Permission $permission)
    {
        return [
            'id' => (int) $permission->id,
            'name' => $permission->name,
            'display_name' => $permission->display_name,
        ];
    }
}