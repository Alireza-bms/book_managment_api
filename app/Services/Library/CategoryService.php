<?php

namespace App\Services\Library;

use App\Models\Category;

class CategoryService
{
    /**
     * Get a paginated list of categories with optional includes.
     */
    public function list(int $perPage = 10, array $includes = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Category::query()->orderByDesc('created_at');

        if (!empty($includes)) {
            $query->with($includes);
        }

        return $query->paginate($perPage);
    }

    /**
     * Show a single category with optional includes.
     */
    public function show(Category $category, array $includes = []): Category
    {
        if (!empty($includes)) {
            $category->load($includes);
        }

        return $category;
    }

    /**
     * Create a new category.
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Update an existing category.
     */
    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    /**
     * Delete a category.
     */
    public function delete(Category $category): void
    {
        $category->delete();
    }
}
