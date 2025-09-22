<?php

namespace App\Http\Controllers\v1\Library;

use App\Http\Controllers\v1\Controller;
use App\Http\Requests\Library\CategoryStoreRequest;
use App\Http\Requests\Library\CategoryUpdateRequest;
use App\Http\Resources\Library\CategoryCollection;
use App\Http\Resources\Library\CategoryResource;
use App\Models\Category;
use App\Services\Library\CategoryService;
use App\Traits\FilterRequestIncludes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    use FilterRequestIncludes;


    // Allowed relations to include
    protected array $allowedIncludes = ['books'];

    public function __construct(protected CategoryService $categoryService)
    {
    }

    /**
     * Display a paginated list of categories.
     *
     * Supports optional eager loading of relations via ?include=books
     * and applies default ordering by created_at (descending).
     */
    public function index(Request $request): CategoryCollection
    {
        $includes = $this->filterIncludes($request, $this->allowedIncludes);

        $categories = $this->categoryService->list(10, $includes);

        return new CategoryCollection($categories);
    }

    /**
     * Display a single category with optional includes.
     */
    public function show(Request $request, Category $category): CategoryResource
    {
        $includes = $this->filterIncludes($request, $this->allowedIncludes);

        $category = $this->categoryService->show($category, $includes);

        return new CategoryResource($category);
    }

    /**
     * Store a newly created category.
     */
    public function store(CategoryStoreRequest $request): CategoryResource
    {
        $category = $this->categoryService->create($request->validated());
        return new CategoryResource($category);
    }

    /**
     * Update an existing category.
     */
    public function update(CategoryUpdateRequest $request, Category $category): CategoryResource
    {
        $category = $this->categoryService->update($category, $request->validated());
        return new CategoryResource($category);
    }

    /**
     * Delete a category.
     */
    public function destroy(Category $category): Response
    {
        $this->categoryService->delete($category);
        return response()->noContent();
    }
}
