<?php

namespace App\Http\Controllers\v1\Library;

use App\Http\Controllers\v1\Controller;
use App\Http\Requests\Library\AuthorStoreRequest;
use App\Http\Requests\Library\AuthorUpdateRequest;
use App\Http\Resources\Library\AuthorCollection;
use App\Http\Resources\Library\AuthorResource;
use App\Models\Author;
use App\Services\Library\AuthorService;
use App\Traits\FilterRequestIncludes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    use FilterRequestIncludes;

    // List of allowed relations that can be included from client request
    protected array $allowedIncludes = ['books'];

    public function __construct(protected AuthorService $authorService)
    {
    }

    /**
     * Display a paginated list of authors.
     *
     * Supports optional eager loading of relations via ?include=books
     * and applies default ordering by created_at (descending).
     *
     * @param Request $request Incoming HTTP request
     * @return AuthorCollection Paginated collection of authors with optional includes
     */
    public function index(Request $request)
    {
        // Parse includes from the request using the reusable trait
        $includes = $this->filterIncludes($request, $this->allowedIncludes);

        // Fetch paginated authors from the service
        $authors = $this->authorService->list(10, $includes);

        // Return paginated authors wrapped in a Resource Collection
        return new AuthorCollection($authors);
    }

    /**
     * Display a single author.
     *
     * Optionally eager loads relations requested by client.
     *
     * @param Request $request Incoming HTTP request
     * @param Author $author The author instance (from route-model binding)
     * @return AuthorResource
     */
    public function show(Request $request, Author $author)
    {
        // Parse includes from the request
        $includes = $this->filterIncludes($request, $this->allowedIncludes);

        // Delegate to service to optionally load relations
        $author = $this->authorService->show($author, $includes);

        return new AuthorResource($author);
    }

    /**
     * Store a newly created author.
     *
     * @param AuthorStoreRequest $request Validated author data
     * @return AuthorResource
     */
    public function store(AuthorStoreRequest $request)
    {
        $author = $this->authorService->create($request->validated());
        return new AuthorResource($author);
    }

    /**
     * Update an existing author.
     *
     * @param AuthorUpdateRequest $request Validated update data
     * @param Author $author The author to update
     * @return AuthorResource
     */
    public function update(AuthorUpdateRequest $request, Author $author)
    {
        $author = $this->authorService->update($author, $request->validated());
        return new AuthorResource($author);
    }

    /**
     * Delete an author.
     *
     * @param Author $author The author to delete
     * @return Response
     */
    public function destroy(Author $author)
    {
        $this->authorService->delete($author);
        return response()->noContent();
    }
}
