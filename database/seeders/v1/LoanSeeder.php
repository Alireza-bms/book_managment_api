<?php

namespace Database\Seeders\v1;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    /**
     * Seed loans using unique users/books instead of IDs.
     * Handles status and available_copies properly.
     */
    public function run(): void
    {
        $loans = [
            [
                'user_email' => 'john@example.com',
                'book_isbn' => '978-0-553-80371-0',
                'loaned_at' => Carbon::now()->subDays(2),
                'due_at' => Carbon::now()->addDays(12),
                'status' => 'active',
            ],
            [
                'user_email' => 'admin@example.com',
                'book_isbn' => '978-0-7475-3269-9',
                'loaned_at' => Carbon::now()->subDays(5),
                'due_at' => Carbon::now()->addDays(9),
                'status' => 'active',
            ],
        ];

        foreach ($loans as $data) {
            $user = User::where('email', $data['user_email'])->first();
            $book = Book::where('isbn', $data['book_isbn'])->first();

            if ($book && $book->available_copies > 0) {
                Loan::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'book_id' => $book->id,
                        'loaned_at' => $data['loaned_at'],
                    ],
                    [
                        'due_at' => $data['due_at'],
                        'status' => $data['status'],
                    ]
                );

                $book->decrement('available_copies'); // decrement only if loan created
            }
        }
    }
}
