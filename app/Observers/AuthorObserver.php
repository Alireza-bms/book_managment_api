<?php

namespace App\Observers;

use App\Models\Author;
use App\Traits\FlushesCache;

class AuthorObserver
{
    use FlushesCache;
    /**
     * Handle the Author "created" event.
     */
    public function created(Author $author): void
    {
        $this->flushRelatedCache($author);
    }

    /**
     * Handle the Author "updated" event.
     */
    public function updated(Author $author): void
    {
        $this->flushRelatedCache($author);
    }

    /**
     * Handle the Author "deleted" event.
     */
    public function deleted(Author $author): void
    {
        $this->flushRelatedCache($author);
    }

    /**
     * Handle the Author "restored" event.
     */
    public function restored(Author $author): void
    {
        $this->flushRelatedCache($author);
    }

    /**
     * Handle the Author "force deleted" event.
     */
    public function forceDeleted(Author $author): void
    {
        $this->flushRelatedCache($author);
    }
}
