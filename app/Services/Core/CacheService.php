<?php

namespace App\Services\Core;

use Illuminate\Support\Facades\Cache;

/**
 * Service for handling caching operations.
 *
 * Provides a wrapper around Laravel's cache system to simplify caching
 * logic and enable pattern-based cache invalidation.
 */
class CacheService
{
    /**
     * Store a value in cache with a specified TTL (time-to-live).
     *
     * @param string   $key      The cache key
     * @param int      $ttl      Time-to-live in seconds
     * @param callable $callback Callback to generate the value if cache is empty
     *
     * @return mixed Cached value or result of the callback
     */
    public function remember(string $key, int $ttl, callable $callback): mixed
    {
        return Cache::remember($key, $ttl, $callback);
    }

    /**
     * Store a value in cache indefinitely.
     *
     * @param string   $key      The cache key
     * @param callable $callback Callback to generate the value if cache is empty
     *
     * @return mixed Cached value or result of the callback
     */
    public function rememberForever(string $key, callable $callback): mixed
    {
        return Cache::rememberForever($key, $callback);
    }

    /**
     * Remove a specific key from the cache.
     *
     * @param string $key The cache key to remove
     *
     * @return void
     */
    public function forget(string $key): void
    {
        Cache::forget($key);
    }

    /**
     * Remove cache keys matching a specific pattern.
     *
     * Useful for clearing cached lists or keys with dynamic parts
     * like "includes" or "perPage" parameters.
     *
     * @param string $pattern The pattern to match cache keys (e.g., 'users:list:*')
     *
     * @return void
     */
    public function forgetPattern(string $pattern): void
    {
        // Get all keys matching the pattern from Redis
        $keys = Cache::getRedis()->keys($pattern);

        foreach ($keys as $key) {
            // Remove cache prefix before forgetting the key
            Cache::forget(str_replace(config('cache.prefix') . ':', '', $key));
        }
    }

    /**
     * Clear all caches related to a specific model.
     *
     * This includes the individual item cache (if $id is provided)
     * and all list caches under the given prefix.
     *
     * @param string   $prefix Cache key prefix for the model (e.g., 'users')
     * @param int|null $id     Optional ID of a single model instance to clear
     *
     * @return void
     */
    public function clearModel(string $prefix, ?int $id = null): void
    {
        if ($id) {
            // Clear the cache for a single item
            $this->forget("{$prefix}:{$id}:*");
        }

        // Clear all list caches
        $this->forgetPattern("{$prefix}:list:*");
    }
}
