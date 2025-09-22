<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\v1\Controller;
use App\Http\Requests\Admin\{StoreRoleRequest, UpdateRoleRequest};
use App\Services\Acl\RoleService;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct(protected RoleService $roleService)
    {
    }

    /**
     * Display a list of all roles
     */
    public function index(): JsonResponse
    {
        // Check permission for listing roles
        $this->authorize('admin.roles.index');

        return response()->json($this->roleService->getAll());
    }

    /**
     * Store a newly created role
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        // Check permission for creating a role
        $this->authorize('admin.roles.store');

        // Use service to create role + permissions
        $role = $this->roleService->create($request->validated());

        // Return role with its permissions
        return response()->json($role->load('permissions'), 201);
    }

    /**
     * Display a specific role (Route Model Binding)
     */
    public function show(Role $role): JsonResponse
    {
        // Check permission for viewing a role
        $this->authorize('admin.roles.show');

        // Load related permissions for better API response
        return response()->json($role->load('permissions'));
    }

    /**
     * Update a specific role (Route Model Binding)
     */
    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        // Check permission for updating a role
        $this->authorize('admin.roles.update');

        // Use service to update role
        $updatedRole = $this->roleService->update($role->id, $request->validated());

        return response()->json($updatedRole->load('permissions'));
    }

    /**
     * Remove a specific role (Route Model Binding)
     */
    public function destroy(Role $role): JsonResponse
    {
        // Check permission for deleting a role
        $this->authorize('admin.roles.destroy');

        $this->roleService->delete($role->id);

        return response()->json(null, 204);
    }
}
