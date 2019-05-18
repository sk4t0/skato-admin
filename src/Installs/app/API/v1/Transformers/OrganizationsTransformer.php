<?php
/**
 * Created by PhpStorm.
 * User: skato
 * Date: 25/09/17
 * Time: 11.33
 */
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use App\Models\Organization;

class OrganizationsTransformer extends TransformerAbstract
{
    public function transform(Organization $organization)
    {
        return [
            'id' => (int) $organization->id,
            'name' => $organization->name,
            'profile_image' => $organization->profile_image,
            'phone' => $organization->phone,
            'email' => $organization->email,
            'website' => $organization->website,
            'assigned_to' => $organization->assigned_to,
            'city' => $organization->city,
        ];
    }
}