<?php

namespace App\Http\Controllers\v1\User;

use App\Http\Controllers\v1\Controller;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Resources\User\ProfileResource;
use App\Services\User\ProfileService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controller for managing authenticated user's profile.
 *
 * Provides endpoints to view, update profile information, and change password.
 */
class ProfileController extends Controller
{
    /**
     * Profile service instance for business logic.
     */
    public function __construct(private readonly ProfileService $service) {}

    /**
     * Show authenticated user's profile.
     *
     * Loads the count of loans for the user.
     *
     * @param Request $request
     * @return ProfileResource
     */
    public function show(Request $request)
    {
        // Get currently authenticated user with loan count
        $user = $request->user()->loadCount('loans');

        return new ProfileResource($user);
    }

    /**
     * Update authenticated user's profile information.
     *
     * @param UpdateProfileRequest $request
     * @return ProfileResource
     */
    public function update(UpdateProfileRequest $request)
    {
        // Delegate profile update logic to ProfileService
        $user = $this->service->updateProfile($request->user(), $request->validated());

        return new ProfileResource($user);
    }

    /**
     * Update authenticated user's password.
     *
     * @param UpdatePasswordRequest $request
     * @return JsonResponse
     *
     * @throws Exception If current password is invalid or update fails
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        // Delegate password update logic to ProfileService
        $this->service->updatePassword(
            $request->user(),
            $request->current_password,
            $request->new_password
        );

        return response()->json(['message' => 'Password updated successfully']);
    }
}
