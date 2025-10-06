<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\v1\Controller;
use Illuminate\Support\Facades\Auth;
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
 * Response caching is handled globally by Spatie\ResponseCache, so no manual caching is needed.
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
    public function __construct(protected UserService $service)
    {
    }

    /**
     * Display a paginated list of users with optional eager-loaded relations.
     *
     * Caching is automatically handled by Spatie ResponseCache middleware.
     *
     * @return UserCollection
     */
    public function index(): UserCollection
    {
        $this->authorize('admin.users.index');

        $includes = $this->filterIncludes(request(), $this->allowedIncludes);

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
        $this->authorize('admin.users.store');

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
        $this->authorize('admin.users.show');

        $includes = $this->filterIncludes(request(), $this->allowedIncludes);

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
        $this->authorize('admin.users.update');

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
        $this->authorize('admin.users.destroy');

        $this->service->delete($user);

        return response()->noContent();
    }
}
