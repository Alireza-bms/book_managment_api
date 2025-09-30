<?php

namespace App\Http\Controllers\v1\Library;

use App\Http\Controllers\v1\Controller;
use App\Http\Requests\Library\LoanStoreRequest;
use App\Http\Resources\Library\LoanCollection;
use App\Http\Resources\Library\LoanResource;
use App\Models\Loan;
use App\Services\Library\LoanService;
use App\Traits\FilterRequestIncludes;
use Illuminate\Http\Request;
use Throwable;

/**
 * Controller for managing book loans in the library.
 *
 * Handles listing, viewing, creating, returning and canceling loans.
 */
class LoanController extends Controller
{
    use FilterRequestIncludes;

    /**
     * Defines which relationships are allowed to be included in the API response.
     */
    protected array $allowedIncludes = ['user', 'book'];

    /**
     * Inject LoanService via dependency injection.
     */
    public function __construct(protected LoanService $loanService)
    {
    }

    /**
     * Display a paginated list of loans.
     *
     * @param Request $request
     * @return LoanCollection
     */
    public function index(Request $request)
    {
        // Filter requested "includes" against allowed includes
        $includes = $this->filterIncludes($request, $this->allowedIncludes);

        // Get paginated loans with optional relationships
        $loans = $this->loanService->list(10, $includes);

        return new LoanCollection($loans);
    }

    /**
     * Display a specific loan with optional includes.
     *
     * @param Request $request
     * @param Loan $loan
     * @return LoanResource
     */
    public function show(Request $request, Loan $loan)
    {
        $includes = $this->filterIncludes($request, $this->allowedIncludes);

        $loan = $this->loanService->show($loan, $includes);

        return new LoanResource($loan);
    }

    /**
     * Store a newly created loan.
     *
     * @param LoanStoreRequest $request
     * @return LoanResource
     * @throws Throwable
     */
    public function store(LoanStoreRequest $request)
    {
        $loan = $this->loanService->create($request->validated());

        return new LoanResource($loan);
    }

    /**
     * Mark a loan as returned.
     *
     * @param Loan $loan
     * @return LoanResource
     * @throws Throwable
     */
    public function return(Loan $loan)
    {
        $loan = $this->loanService->return($loan);

        return new LoanResource($loan);
    }

    /**
     * Cancel a loan request.
     *
     * @param Loan $loan
     * @return LoanResource
     * @throws Throwable
     */
    public function cancel(Loan $loan)
    {
        $loan = $this->loanService->cancel($loan);

        return new LoanResource($loan);
    }
}
