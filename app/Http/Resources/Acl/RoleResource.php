<?php

namespace App\Http\Resources\Acl;

use App\Http\Resources\Admin\UserCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

/**
 * RoleResource - transforms a Role model for API responses.
 *
 * @mixin Role
 */
class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,

            // Only include permissions when viewing roles directly
            'permissions' => $this->when(
                $request->routeIs('admin.roles.*') && $this->relationLoaded('permissions'),
                fn() => new PermissionCollection($this->permissions)
            ),

            // Only include users if they are eager loaded
            'users'       => $this->whenLoaded(
                'users',
                fn() => new UserCollection($this->users)
            ),

            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
