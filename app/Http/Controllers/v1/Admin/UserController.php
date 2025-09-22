<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\v1\Controller;
use Illuminate\Http\Response;
use App\Http\Requests\Admin\{StoreUserRequest, UpdateUserRequest};
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\Admin\UserCollection;
use App\Models\User;
use App\Services\Admin\UserService;

class UserController extends Controller
{
    /**
     * Inject UserService into the controller.
     */
    public function __construct(protected UserService $service) {}

    /**
     * Display a paginated list of users.
     *
     * @return UserCollection
     */
    public function index()
    {
        $this->authorize('admin.users.index');

        $users = $this->service->list(10);

        return new UserCollection($users);
    }

    /**
     * Store a newly created user in storage.
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
     * Display the specified user.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        $this->authorize('admin.users.show');

        $user = $this->service->find($user);

        return new UserResource($user);
    }

    /**
     * Update the specified user in storage.
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
     * Remove the specified user from storage.
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
