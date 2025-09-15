<?php

namespace Database\Seeders\v1;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loans = include database_path('data/v1/loans.php');

        foreach ($loans as $loan) {
            $loanRecord = Loan::create([
                'user_id' => $loan['user_id'],
                'book_id' => $loan['book_id'],
                'loaned_at' => $loan['loaned_at'] ?? now(),
                'due_at' => $loan['due_at'] ?? now()->addDays(7),
                'returned_at' => $loan['returned_at'] ?? null,
            ]);

            $book = Book::find($loan['book_id']);

            if ($book) {
                // Decrease available copies when loan is created
                $book->decrement('available_copies');

                // If the loan is returned, increase available copies back
                if (!empty($loan['returned_at'])) {
                    $book->increment('available_copies');
                }
            }
        }
    }
}
