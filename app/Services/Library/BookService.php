<?php

namespace App\Services\Library;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookService
{
    /**
     * Get a paginated list of books with optional includes.
     *
     * Applies default ordering by created_at (descending).
     *
     * @param int $perPage Number of books per page (default 10)
     * @param array $includes Relations to eager load (validated before passing)
     * @return LengthAwarePaginator Paginated list of books
     */
    public function list(int $perPage = 10, array $includes = []): LengthAwarePaginator
    {
        // Start a query on the Book model
        $query = Book::query();

        // Eager load allowed relations if provided
        if (!empty($includes)) {
            $query->with($includes);
        }

        // Apply default ordering by created_at DESC
        $query->orderByDesc('created_at');

        // Paginate results
        return $query->paginate($perPage);
    }

    /**
     * Load allowed relations for a single book.
     *
     * @param Book $book The book instance to load relations for
     * @param array $includes List of relations to eager load
     * @return Book The book instance with requested relations loaded
     */
    public function show(Book $book, array $includes = []): Book
    {
        if (!empty($includes)) {
            $book->load($includes);
        }

        return $book;
    }

    /**
     * Create a new book record.
     *
     * @param array $data Validated book data
     * @return Book The created book instance
     */
    public function create(array $data): Book
    {
        return Book::create($data);
    }

    /**
     * Update an existing book record.
     *
     * @param Book $book The book to update
     * @param array $data Validated data to update
     * @return Book The updated book instance
     */
    public function update(Book $book, array $data): Book
    {
        $book->update($data);
        return $book;
    }

    /**
     * Delete a book record.
     *
     * @param Book $book The book to delete
     * @return void
     */
    public function delete(Book $book): void
    {
        $book->delete();
    }
}
