<?php

namespace App\Services\Library;

use App\Models\Loan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

class LoanService
{
    /**
     * Retrieve a paginated list of loans.
     *
     * Supports eager loading of relations (e.g. user, book).
     *
     * @param int   $perPage  Number of items per page
     * @param array $includes Relations to eager load
     * @return LengthAwarePaginator
     */
    public function list(int $perPage = 10, array $includes = []): LengthAwarePaginator
    {
        return Loan::with($includes)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    /**
     * Retrieve a single loan with optional eager-loaded relations.
     *
     * @param Loan  $loan     Loan model instance
     * @param array $includes Relations to eager load
     * @return Loan
     */
    public function show(Loan $loan, array $includes = []): Loan
    {
        return $loan->load($includes);
    }

    /**
     * Create a new loan transaction.
     *
     * - Inserts a new loan record with "active" status
     * - Decrements available copies of the borrowed book
     *
     * @param array $data Validated input data
     * @return Loan Newly created Loan instance
     * @throws Throwable
     */
    public function create(array $data): Loan
    {
        return DB::transaction(function () use ($data) {
            // Create loan record
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
     *
     * - Updates loan status to "returned"
     * - Sets returned_at timestamp
     * - Increments available copies of the book
     *
     * @param Loan $loan Loan model instance
     * @return Loan Updated loan instance
     * @throws Throwable
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
     *
     * - Updates loan status to "cancelled"
     * - If the loan was still active, restores the book copy
     *
     * @param Loan $loan Loan model instance
     * @return Loan Updated loan instance
     * @throws Throwable
     */
    public function cancel(Loan $loan): Loan
    {
        return DB::transaction(function () use ($loan) {
            $loan->update(['status' => 'cancelled']);

            // If it was active, return the book copy to stock
            if ($loan->status === 'active') {
                $loan->book->increment('available_copies');
            }

            return $loan;
        });
    }
}
