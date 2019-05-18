<?php
/**
 * Created by PhpStorm.
 * User: skato
 * Date: 25/09/17
 * Time: 11.33
 */
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use App\Role;

class RolesTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            'id' => (int) $role->id,
            'name' => $role->name,
            'display_name' => $role->display_name,
            'parent' => $role->parent,
            'dept' => $role->dept,
        ];
    }
}