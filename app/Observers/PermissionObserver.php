<?php

namespace App\Observers;

use App\Models\permission;
use App\Models\Role;

class PermissionObserver
{
    /**
     * Handle the permission "created" event.
     */
    public function created(permission $permission): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole?->permissions()->syncWithoutDetaching([$permission->id]);
    }
}
