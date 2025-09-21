<?php

namespace App\Http\Resources\Admin;

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
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->whenLoaded('roles', fn() => $this->roles->pluck('name')), // list of role names
            'permissions' => $this->whenLoaded('permissions', fn() => $this->permissions->pluck('name')), // list of permission names
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
