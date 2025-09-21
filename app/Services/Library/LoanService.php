<?php

namespace App\Services\Library;

use App\Models\Loan;
use Illuminate\Support\Facades\DB;

class LoanService
{
    /**
     * List all loans (with optional includes like user, book).
     */
    public function list(int $perPage = 10, array $includes = [])
    {
        return Loan::with($includes)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    /**
     * Show a single loan with optional includes.
     */
    public function show(Loan $loan, array $includes = [])
    {
        return $loan->load($includes);
    }

    /**
     * Create a new loan.
     */
    public function create(array $data): Loan
    {
        return DB::transaction(function () use ($data) {
            $loan = Loan::create([
                'user_id'    => $data['user_id'],
                'book_id'    => $data['book_id'],
                'loaned_at'  => $data['loaned_at'],
                'due_at'     => $data['due_at'],
                'status'     => 'active',
            ]);

            // Reduce available copies of the book
            $loan->book->decrement('available_copies');

            return $loan;
        });
    }

    /**
     * Mark a loan as returned.
     */
    public function return(Loan $loan): Loan
    {
        return DB::transaction(function () use ($loan) {
            $loan->update([
                'status'      => 'returned',
                'returned_at' => now(),
            ]);

            // Increase available copies back
            $loan->book->increment('available_copies');

            return $loan;
        });
    }

    /**
     * Cancel a loan.
     */
    public function cancel(Loan $loan): Loan
    {
        return DB::transaction(function () use ($loan) {
            $loan->update(['status' => 'cancelled']);

            // If it was active, return book copy
            if ($loan->status === 'active') {
                $loan->book->increment('available_copies');
            }

            return $loan;
        });
    }
}
