<?php

namespace App\Traits;

use Illuminate\Http\Request;

/**
 * Trait FiltersRequestIncludes
 *
 * Provides a reusable method to parse the "include" query parameter
 * from the request and filter it against an allowed whitelist.
 * This keeps the Service layer independent of client input.
 */
trait FilterRequestIncludes
{
    /**
     * Parse and whitelist requested includes from the HTTP request.
     *
     * @param Request $request Incoming HTTP request
     * @param array $allowedIncludes List of allowed relation names
     * @return array Whitelisted relation names safe for eager loading
     */
    protected function filterIncludes(Request $request, array $allowedIncludes = []): array
    {
        $includes = $request->query('include')
            ? array_filter(array_map('trim', explode(',', $request->query('include'))))
            : [];

        return array_intersect($includes, $allowedIncludes);
    }
}
