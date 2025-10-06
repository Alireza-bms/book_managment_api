<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\v1\Controller;
use App\Http\Resources\Acl\PermissionCollection;
use App\Http\Requests\Admin\{StorePermissionRequest, UpdatePermissionRequest};
use App\Services\Acl\PermissionService;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function __construct(protected PermissionService $permissionService)
    {
    }

    /**
     * Display a list of all permissions
     */
    public function index(): PermissionCollection
    {
        // Check permission for listing permissions
        $this->authorize('admin.permissions.index');

        $permissions = $this->permissionService->getAll();
        return new PermissionCollection($permissions);
    }

    /**
     * Store a newly created permission
     */
    public function store(StorePermissionRequest $request): JsonResponse
    {
        // Check permission for creating a new permission
        $this->authorize('admin.permissions.store');

        // Create new permission using service layer
        $permission = $this->permissionService->create($request->validated());

        return response()->json($permission, 201);
    }

    /**
     * Display a specific permission (Route Model Binding)
     */
    public function show(Permission $permission): JsonResponse
    {
        // Check permission for viewing a permission
        $this->authorize('admin.permissions.show');

        return response()->json($permission);
    }

    /**
     * Update a specific permission (Route Model Binding)
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): JsonResponse
    {
        // Check permission for updating a permission
        $this->authorize('admin.permissions.update');

        // Update permission via service layer
        $updatedPermission = $this->permissionService->update($permission->id, $request->validated());

        return response()->json($updatedPermission);
    }

    /**
     * Remove a specific permission (Route Model Binding)
     */
    public function destroy(Permission $permission): JsonResponse
    {
        // Check permission for deleting a permission
        $this->authorize('admin.permissions.destroy');

        $this->permissionService->delete($permission->id);

        return response()->json(null, 204);
    }
}
