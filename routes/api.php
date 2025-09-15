<?php

use App\Http\Controllers\v1\Auth\AuthController;
use App\Http\Controllers\v1\Library\{AuthorController, BookController, CategoryController, LoanController};

use Illuminate\Support\Facades\Route;

// All endpoints are prefixed with /api/v1/
Route::prefix('v1')->group(function () {
    // Public endpoints for user authentication
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

// Protected endpoints requiring authentication
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        // Book CRUD operations
        Route::apiResource('books', BookController::class);

        // Author CRUD operations
        Route::apiResource('authors', AuthorController::class);

        // Category CRUD operations
        Route::apiResource('categories', CategoryController::class);

        // Loan operations (create and return)
        Route::apiResource('loans', LoanController::class)->only(['store', 'update']);
    });

});



