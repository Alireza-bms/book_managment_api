<?php

namespace App\Services\Acl;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * Get all roles with their permissions.
     *
     * @return Collection
     */
    public function getAll()
    {
        // Fetch all roles and eager load their permissions
        return Role::with('permissions')->get();
    }

    /**
     * Create a new role with optional permissions.
     *
     * @param  array  $data  Role data (expects 'name' and optionally 'permissions')
     * @return Role
     */
    public function create(array $data): Role
    {
        // Create role with sanctum guard
        $role = Role::create([
            'name' => $data['name'],
            'guard_name' => 'sanctum',
        ]);

        // Attach permissions if provided
        if (!empty($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role;
    }

    /**
     * Update an existing role by ID.
     *
     * - Updates role name
     * - Syncs permissions (overwrites old with new)
     *
     * @param  int    $id    Role ID
     * @param  array  $data  Role data (expects 'name' and optionally 'permissions')
     * @return Role
     */
    public function update(int $id, array $data): Role
    {
        // Find role or fail
        $role = Role::findOrFail($id);

        // Update name
        $role->update(['name' => $data['name']]);

        // Sync new permissions if provided (empty = remove all)
        $role->syncPermissions($data['permissions'] ?? []);

        return $role;
    }

    /**
     * Delete a role by ID.
     *
     * @param  int  $id  Role ID
     * @return bool|null True if deleted, false otherwise
     */
    public function delete(int $id): ?bool
    {
        // Find role or fail and delete it
        $role = Role::findOrFail($id);
        return $role->delete();
    }
}
