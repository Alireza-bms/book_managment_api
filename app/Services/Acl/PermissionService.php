<?php

namespace App\Services\Acl;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    /**
     * Retrieve all permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Permission::all();
    }

    /**
     * Find a specific permission by its ID.
     *
     * Throws ModelNotFoundException if not found.
     *
     * @param int $id Permission ID
     * @return Permission
     */
    public function findById(int $id)
    {
        return Permission::findOrFail($id);
    }

    /**
     * Create a new permission.
     *
     * - Uses the "sanctum" guard by default
     *
     * @param array $data Validated input data
     * @return Permission Newly created permission
     */
    public function create(array $data)
    {
        $permission = Permission::create([
            'name' => $data['name'],
            'guard_name' => 'sanctum',
        ]);

        return $permission;
    }

    /**
     * Update an existing permission.
     *
     * @param int   $id   Permission ID
     * @param array $data Validated update data
     * @return Permission Updated permission
     */
    public function update(int $id, array $data)
    {
        $permission = Permission::findOrFail($id);
        $permission->update(['name' => $data['name']]);

        return $permission;
    }

    /**
     * Delete a permission by ID.
     *
     * @param int $id Permission ID
     * @return bool|null True if deleted, false otherwise
     */
    public function delete(int $id)
    {
        $permission = Permission::findOrFail($id);

        return $permission->delete();
    }
}
