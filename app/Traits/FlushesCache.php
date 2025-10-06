<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Trait FlushesCache
 *
 * This trait allows observers to automatically clear
 * specific cache tags related to a model whenever needed.
 *
 * Example usage:
 * - Add `use FlushesCache;` in your observer
 * - Define a static property `$relatedCacheTags` in your model
 *   listing all cache tags that should be flushed on changes.
 */
trait FlushesCache
{
    /**
     * Flush all cache tags related to the given model.
     *
     * @param  Model  $model  The Eloquent model whose related cache should be cleared.
     * @return void
     */
    protected function flushRelatedCache(Model $model): void
    {
        // Get the list of cache tags defined in the model
        // Example: protected static array $relatedCacheTags = ['books', 'authors'];
        $tags = $model::$relatedCacheTags ?? [];

        // If no tags are defined, there’s nothing to flush
        if (empty($tags)) {
            return;
        }

        // Loop through each tag and flush its cached entries
        foreach ($tags as $tag) {
            Cache::tags($tag)->flush();
        }
    }
}
