<?php

namespace App\Observers;

use App\Models\Category;
use App\Traits\FlushesCache;

class CategoryObserver
{
    use FlushesCache;
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $this->flushRelatedCache($category);
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->flushRelatedCache($category);
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $this->flushRelatedCache($category);
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        $this->flushRelatedCache($category);
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        $this->flushRelatedCache($category);
    }
}
