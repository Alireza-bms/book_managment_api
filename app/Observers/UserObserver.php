<?php

namespace App\Observers;

use App\Models\User;
use App\Traits\FlushesCache;

class UserObserver
{
    use FlushesCache;
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->flushRelatedCache($user);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $this->flushRelatedCache($user);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $this->flushRelatedCache($user);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        $this->flushRelatedCache($user);
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        $this->flushRelatedCache($user);
    }
}
