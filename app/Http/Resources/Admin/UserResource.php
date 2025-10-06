<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Acl\PermissionCollection;
use App\Http\Resources\Acl\RoleCollection;
use App\Http\Resources\Library\LoanCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * This resource is intended for admin panel usage.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,

            // Use ::make() to safely handle null or unloaded relations
            'loans' => LoanCollection::make($this->whenLoaded('loans')),
            'roles' => RoleCollection::make($this->whenLoaded('roles')),

            // Permissions are fetched dynamically via Spatie, not eager loaded
            'permissions' => PermissionCollection::make($this->getAllPermissions()),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

    }
}
