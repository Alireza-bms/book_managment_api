<?php

namespace Database\Seeders\v1;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Seed books using unique ISBN.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'Foundation',
                'isbn' => '978-0-553-80371-0',
                'description' => 'Classic sci-fi novel',
                'category_name' => 'Science',
                'authors' => ['Isaac Asimov'],
                'total_copies' => 5,
                'available_copies' => 5,
                'published_year' => 1951,
            ],
            [
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'isbn' => '978-0-7475-3269-9',
                'description' => 'Fantasy novel',
                'category_name' => 'Fiction',
                'authors' => ['J.K. Rowling'],
                'total_copies' => 3,
                'available_copies' => 3,
                'published_year' => 1997,
            ],
        ];

        foreach ($books as $data) {
            $category = Category::where('name', $data['category_name'])->first();
            $book = Book::updateOrCreate(
                ['isbn' => $data['isbn']], // unique field
                [
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'category_id' => $category->id,
                    'total_copies' => $data['total_copies'],
                    'available_copies' => $data['available_copies'],
                    'published_year' => $data['published_year'],
                ]
            );

            // attach authors
            $authorIds = Author::whereIn('name', $data['authors'])->pluck('id')->toArray();
            $book->authors()->sync($authorIds);
        }
    }
}
