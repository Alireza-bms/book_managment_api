<?php

namespace App\Services\Library;

use App\Models\Author;

class AuthorService
{
    /**
     * Get a paginated list of authors with optional includes.
     *
     * @param int $perPage
     * @param array $includes
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list(int $perPage = 10, array $includes = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Author::query()->orderByDesc('created_at');

        if (!empty($includes)) {
            $query->with($includes);
        }

        return $query->paginate($perPage);
    }

    /**
     * Load allowed relations for a single author.
     *
     * @param Author $author
     * @param array $includes
     * @return Author
     */
    public function show(Author $author, array $includes = []): Author
    {
        if (!empty($includes)) {
            $author->load($includes);
        }

        return $author;
    }

    /**
     * Create a new author record.
     *
     * @param array $data
     * @return Author
     */
    public function create(array $data): Author
    {
        return Author::create($data);
    }

    /**
     * Update an existing author record.
     *
     * @param Author $author
     * @param array $data
     * @return Author
     */
    public function update(Author $author, array $data): Author
    {
        $author->update($data);
        return $author;
    }

    /**
     * Delete an author record.
     *
     * @param Author $author
     * @return void
     */
    public function delete(Author $author): void
    {
        $author->delete();
    }
}
