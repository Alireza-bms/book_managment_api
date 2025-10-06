<?php

namespace App\Observers;

use App\Models\Book;
use App\Traits\FlushesCache;

class BookObserver
{
    use FlushesCache;
    /**
     * Handle the Book "created" event.
     */
    public function created(Book $book): void
    {
        $this->flushRelatedCache($book);
    }

    /**
     * Handle the Book "updated" event.
     */
    public function updated(Book $book): void
    {
        $this->flushRelatedCache($book);
    }

    /**
     * Handle the Book "deleted" event.
     */
    public function deleted(Book $book): void
    {
        $this->flushRelatedCache($book);
    }

    /**
     * Handle the Book "restored" event.
     */
    public function restored(Book $book): void
    {
        $this->flushRelatedCache($book);
    }

    /**
     * Handle the Book "force deleted" event.
     */
    public function forceDeleted(Book $book): void
    {
        $this->flushRelatedCache($book);
    }
}
