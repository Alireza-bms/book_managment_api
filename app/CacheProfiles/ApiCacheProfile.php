<?php

namespace App\CacheProfiles;

use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Spatie\ResponseCache\CacheProfiles\CacheProfile;
use Symfony\Component\HttpFoundation\Response;

class ApiCacheProfile implements CacheProfile
{
    /**
     * Determine if caching is globally enabled.
     *
     * @param Request $request
     * @return bool
     */
    public function enabled(Request $request): bool
    {
        return true; // Always enabled
    }

    /**
     * Decide if this request should be cached.
     *
     * @param Request $request
     * @return bool
     */
    public function shouldCacheRequest(Request $request): bool
    {
        // Only cache GET requests
        if (! $request->isMethod('get')) {
            return false;
        }

        $path = $request->path();

        // Do not cache admin, roles, or permissions routes
        if (str_starts_with($path, 'api/v1/admin') ||
            str_starts_with($path, 'api/v1/roles') ||
            str_starts_with($path, 'api/v1/permissions')) {
            return false;
        }

        return true;
    }

    /**
     * Decide if this response should be cached.
     *
     * @param Response $response
     * @return bool
     */
    public function shouldCacheResponse(Response $response): bool
    {
        // Only cache successful responses (HTTP 200)
        return $response->getStatusCode() === 200;
    }

    /**
     * Set the expiration time for this cache.
     *
     * @param Request $request
     * @return DateTime
     */
    public function cacheRequestUntil(Request $request): DateTime
    {
        // Cache expires 5 minutes from now
        return (new DateTime())->add(new DateInterval('PT5M'));
    }

    /**
     * Optional cache name suffix (can help differentiate cache keys).
     *
     * @param Request $request
     * @return string
     */
    public function useCacheNameSuffix(Request $request): string
    {
        return ''; // Empty means default is used
    }

    /**
     * Return an array of cache tags for this request.
     *
     * @param Request $request
     * @return array
     */
    public function cacheTags(Request $request): array
    {
        $path = $request->path();

        return match (true) {
            // Define tags based on the route prefix
            str_starts_with($path, 'api/v1/books')      => ['books'],
            str_starts_with($path, 'api/v1/authors')    => ['authors'],
            str_starts_with($path, 'api/v1/categories') => ['categories'],
            str_starts_with($path, 'api/v1/loans')      => ['loans'],

            // Default: no tags
            default => [],
        };
    }
}
