<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Service class for managing users in the admin panel.
 *
 * Handles CRUD operations, role assignment, and user retrieval.
 */
class UserService
{
    /**
     * Get paginated list of users with optional relations.
     *
     * @param int   $perPage  Number of results per page
     * @param array $includes Relations to eager load (e.g., ['roles', 'loans'])
     *
     * @return LengthAwarePaginator
     */
    public function list(int $perPage = 10, array $includes = []): LengthAwarePaginator
    {
        // Start query on User model ordered by creation date descending
        $query = User::query()->orderByDesc('created_at');

        // Eager-load relations if provided
        if (!empty($includes)) {
            $query->with($includes);
        }

        // Return paginated results
        return $query->paginate($perPage);
    }

    /**
     * Create a new user with optional role assignment.
     *
     * @param array $data User data including name, email, password, and roles
     *
     * @return User
     */
    public function create(array $data): User
    {
        // Create the user; password hashing handled by model casts
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
     * Update an existing user and optionally sync roles.
     *
     * @param User  $user User instance to update
     * @param array $data Data to update including optional roles
     *
     * @return User
     */
    public function update(User $user, array $data): User
    {
        // Update user fields
        $user->update($data);

        // Sync roles if provided
        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user;
    }

    /**
     * Delete a user from the database.
     *
     * @param User $user User instance to delete
     */
    public function delete(User $user): void
    {
        $user->delete();
    }

    /**
     * Find a single user with optional eager-loaded relations.
     *
     * @param User  $user     User instance to load
     * @param array $includes Optional relations to eager load
     *
     * @return User
     */
    public function find(User $user, array $includes = []): User
    {
        // Load requested relations if provided
        if (!empty($includes)) {
            $user->load($includes);
        } else {
            // Default relations to load
            $user->load('roles', 'permissions');
        }

        return $user;
    }
}
