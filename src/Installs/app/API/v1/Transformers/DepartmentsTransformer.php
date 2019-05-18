<?php
/**
 * Created by PhpStorm.
 * User: skato
 * Date: 25/09/17
 * Time: 11.33
 */
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use App\Models\Department;

class DepartmentsTransformer extends TransformerAbstract
{
    public function transform(Department $department)
    {
        return [
            'id' => (int) $department->id,
            'name' => $department->name
        ];
    }
}