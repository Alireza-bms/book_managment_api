<?php

namespace App\Http\Controllers\v1\Library;

use App\Http\Controllers\v1\Controller;
use App\Http\Requests\Library\BookStoreRequest;
use App\Http\Requests\Library\BookUpdateRequest;
use App\Http\Resources\Library\BookCollection;
use App\Http\Resources\Library\BookResource;
use App\Models\Book;
use App\Services\Library\BookService;
use App\Traits\FilterRequestIncludes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    use FilterRequestIncludes;

    // List of allowed relations that can be included from client request
    protected array $allowedIncludes = ['category', 'authors'];

    public function __construct(protected BookService $bookService)
    {
    }

    /**
     * Display a paginated list of books.
     *
     * Supports optional eager loading of relations via ?include=category,authors
     * and applies default ordering by created_at (descending).
     *
     * @param Request $request Incoming HTTP request
     * @return BookCollection Paginated collection of books with optional includes
     */
    public function index(Request $request)
    {
        // Parse includes from the request using the reusable trait
        $includes = $this->filterIncludes($request, $this->allowedIncludes);

        // Fetch paginated books from the service (includes + ordering handled inside service)
        $books = $this->bookService->list(10, $includes);

        // Return paginated books wrapped in a Resource Collection
        return new BookCollection($books);
    }

    /**
     * Display a single book.
     *
     * Optionally eager loads relations requested by client.
     *
     * @param Request $request Incoming HTTP request
     * @param Book $book The book instance (from route-model binding)
     * @return BookResource
     */
    public function show(Request $request, Book $book)
    {
        // Parse includes from the request
        $includes = $this->filterIncludes($request, $this->allowedIncludes);

        // Delegate to service to optionally load relations
        $book = $this->bookService->show($book, $includes);

        return new BookResource($book);
    }

    /**
     * Store a newly created book.
     *
     * @param BookStoreRequest $request Validated book data
     * @return BookResource
     */
    public function store(BookStoreRequest $request)
    {
        $book = $this->bookService->create($request->validated());
        return new BookResource($book);
    }

    /**
     * Update an existing book.
     *
     * @param BookUpdateRequest $request Validated update data
     * @param Book $book The book to update
     * @return BookResource
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        $book = $this->bookService->update($book, $request->validated());
        return new BookResource($book);
    }

    /**
     * Delete a book.
     *
     * @param Book $book The book to delete
     * @return Response
     */
    public function destroy(Book $book)
    {
        $this->bookService->delete($book);
        return response()->noContent();
    }
}
