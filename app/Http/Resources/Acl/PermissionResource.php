<?php

namespace App\Http\Resources\Acl;

use App\Http\Resources\Admin\UserCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Permission;

/** @mixin Permission */
class PermissionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            $this->whenLoaded('roles', fn() => new RoleCollection($this->roles)), // list of roles
            $this->whenLoaded('users', fn() => new UserCollection($this->users())), // list of users
        ];
    }
}
