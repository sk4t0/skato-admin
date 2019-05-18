<?php
/**
 * Created by PhpStorm.
 * User: skato
 * Date: 25/09/17
 * Time: 11.33
 */
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use App\User;

class UsersTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => (int) $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'type' => $user->type,
        ];
    }
}