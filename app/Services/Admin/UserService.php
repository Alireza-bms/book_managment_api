<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    /**
     * Get paginated list of users with their roles.
     *
     * @param int $perPage Number of results per page
     * @return LengthAwarePaginator
     */
    public function list(int $perPage = 10): LengthAwarePaginator
    {
        return User::with('roles')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    /**
     * Create a new user with optional role assignment.
     *
     * @param array $data User data (name, email, password, roles?)
     * @return User
     */
    public function create(array $data): User
    {
        // Create user (password automatically hashed via User model casts)
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);

        // Assign roles if provided
        if (!empty($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user;
    }

    /**
     * Update user details and optionally sync roles.
     *
     * @param User  $user Existing user model
     * @param array $data Updated data
     * @return User
     */
    public function update(User $user, array $data): User
    {
        // Update basic user attributes
        $user->update($data);

        // Sync roles if provided
        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user;
    }

    /**
     * Delete a user from database.
     *
     * @param User $user
     * @return void
     */
    public function delete(User $user): void
    {
        $user->delete();
    }

    /**
     * Find a single user with roles and permissions loaded.
     *
     * @param User $user
     * @return User
     */
    public function find(User $user): User
    {
        return $user->load('roles', 'permissions');
    }
}
