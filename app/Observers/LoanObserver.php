<?php

namespace App\Observers;

use App\Models\Loan;
use App\Traits\FlushesCache;
use Illuminate\Support\Facades\Cache;

class LoanObserver
{
    use FlushesCache;
    /**
     * Handle the Loan "created" event.
     */
    public function created(Loan $loan): void
    {
        $this->flushRelatedCache($loan);
    }

    /**
     * Handle the Loan "updated" event.
     */
    public function updated(Loan $loan): void
    {
        $this->flushRelatedCache($loan);
    }

    /**
     * Handle the Loan "deleted" event.
     */
    public function deleted(Loan $loan): void
    {
        $this->flushRelatedCache($loan);
    }

    /**
     * Handle the Loan "restored" event.
     */
    public function restored(Loan $loan): void
    {
        $this->flushRelatedCache($loan);
    }

    /**
     * Handle the Loan "force deleted" event.
     */
    public function forceDeleted(Loan $loan): void
    {
        $this->flushRelatedCache($loan);
    }
}
