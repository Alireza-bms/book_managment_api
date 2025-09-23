<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\v1\Controller;
use App\Http\Requests\Admin\{StoreUserRequest, UpdateUserRequest};
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\Admin\UserCollection;
use App\Models\User;
use App\Services\Admin\UserService;
use App\Traits\FilterRequestIncludes;
use Illuminate\Http\Response;

/**
 * Controller for managing users in the admin panel.
 *
 * Provides endpoints for CRUD operations on users, including role and permission management.
 */
class UserController extends Controller
{
    use FilterRequestIncludes;

    /**
     * Allowed relations to include via query parameter ?include=
     *
     * @var array
     */
    protected array $allowedIncludes = ['roles', 'permissions', 'loans'];

    /**
     * Inject the UserService to handle business logic.
     */
    public function __construct(protected UserService $service) {}

    /**
     * Display a paginated list of users.
     *
     * @return UserCollection
     */
    public function index()
    {
        // Authorize the current user to view the users list
        $this->authorize('admin.users.index');

        // Filter requested relations to prevent loading unwanted data
        $includes = $this->filterIncludes(request(), $this->allowedIncludes);

        // Get paginated users with optional eager-loaded relations
        $users = $this->service->list(10, $includes);

        return new UserCollection($users);
    }

    /**
     * Store a newly created user.
     *
     * @param StoreUserRequest $request
     * @return UserResource
     */
    public function store(StoreUserRequest $request)
    {
        // Authorize the current user to create a new user
        $this->authorize('admin.users.store');

        // Delegate creation to the UserService
        $user = $this->service->create($request->validated());

        return new UserResource($user);
    }

    /**
     * Display a specific user.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        // Authorize the current user to view the requested user
        $this->authorize('admin.users.show');

        // Filter requested relations
        $includes = $this->filterIncludes(request(), $this->allowedIncludes);

        // Load user with requested relations
        $user = $this->service->find($user, $includes);

        return new UserResource($user);
    }

    /**
     * Update an existing user.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Authorize the current user to update the requested user
        $this->authorize('admin.users.update');

        // Delegate update to UserService
        $user = $this->service->update($user, $request->validated());

        return new UserResource($user);
    }

    /**
     * Delete a specific user.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        // Authorize the current user to delete the requested user
        $this->authorize('admin.users.destroy');

        // Delegate deletion to UserService
        $this->service->delete($user);

        // Return 204 No Content
        return response()->noContent();
    }
}
