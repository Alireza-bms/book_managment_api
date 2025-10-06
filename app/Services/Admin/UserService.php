<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Services\Core\CacheService;

/**
 * Service class for managing users in the admin panel.
 *
 * Handles CRUD operations, role assignment, and user retrieval.
 * Supports caching for list and individual user queries.
 */
class UserService
{
    protected CacheService $cache;

    /**
     * Constructor.
     *
     * @param CacheService $cache Cache service for storing and retrieving cached data.
     */
    public function __construct(CacheService $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Get paginated list of users with optional eager-loaded relations.
     * The result is cached with a TTL of 60 seconds.
     *
     * @param int $perPage Number of results per page
     * @param array $includes Relations to eager load (e.g., ['roles', 'loans'])
     *
     * @return LengthAwarePaginator
     */
    public function list(int $perPage = 10, array $includes = []): LengthAwarePaginator
    {
        $cacheKey = "users:list:perPage={$perPage}:includes=" . implode(',', $includes);

        return $this->cache->remember($cacheKey, 60, function () use ($perPage, $includes) {
            $query = User::query();
            if (!empty($includes)) {
                $query = $query->with($includes);
            }
            return $query->paginate($perPage);
        });
    }

    /**
     * Find a single user with optional eager-loaded relations.
     * Cached with a TTL of 5 minutes.
     *
     * @param User $user User instance to load
     * @param array $includes Optional relations to eager load
     *
     * @return User
     */
    public function find(User $user, array $includes = []): User
    {
        $cacheKey = "users:{$user->id}:includes=" . implode(',', $includes);

        return $this->cache->remember($cacheKey, 300, function () use ($user, $includes) {
            if (!empty($includes)) {
                $user->load($includes);
            } else {
                $user->load('roles', 'permissions');
            }
            return $user;
        });
    }

    /**
     * Create a new user with optional role assignment.
     * Cache invalidation is handled in Observer.
     *
     * @param array $data User data including name, email, password, and roles
     *
     * @return User
     */
    public function create(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if (!empty($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user;
    }

    /**
     * Update an existing user and optionally sync roles.
     * Cache invalidation is handled in Observer.
     *
     * @param User $user User instance to update
     * @param array $data Data to update including optional roles
     *
     * @return User
     */
    public function update(User $user, array $data): User
    {
        $user->update($data);

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user;
    }

    /**
     * Delete a user from the database.
     * Cache invalidation is handled in Observer.
     *
     * @param User $user User instance to delete
     */
    public function delete(User $user): void
    {
        $user->delete();
    }
}
