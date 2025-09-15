<?php

namespace Database\Seeders\v1;

use App\Models\Book;        // مدل Book که جدول books رو نمایندگی می‌کنه
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load book data from external PHP file
        $books = include database_path('data/v1/books.php');

        foreach ($books as $bookData) {
            // Extract authors IDs if exists, then remove from bookData
            $authors = $bookData['authors'] ?? [];
            unset($bookData['authors']); // authors نباید مستقیم تو جدول books ذخیره بشه

            // Merge with default values to ensure all necessary columns exist
            $bookData = array_merge([
                'title'            => null,
                'isbn'             => null,
                'published_year'   => null,
                'category_id'      => null,
                'total_copies'     => 1,
                'available_copies' => 1,
                'description'      => null
            ], $bookData);

            // Create a new Book record
            $book = Book::create($bookData);

            // Attach authors to the book via pivot table (many-to-many relationship)
            if (!empty($authors)) {
                $book->authors()->attach($authors);
            }
        }
    }
}
