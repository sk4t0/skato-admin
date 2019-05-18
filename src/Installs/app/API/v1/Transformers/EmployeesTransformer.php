<?php
/**
 * Created by PhpStorm.
 * User: skato
 * Date: 25/09/17
 * Time: 11.33
 */
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use App\Models\Employee;

class EmployeesTransformer extends TransformerAbstract
{
    public function transform(Employee $employee)
    {
        return [
            'id' => (int) $employee->id,
            'name' => $employee->name,
            'designation' => $employee->name,
            'mobile' => $employee->mobile,
            'email' => $employee->email,
            'dept' => $employee->dept,
        ];
    }
}