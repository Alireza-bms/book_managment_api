<?php

use App\CacheProfiles\ApiCacheProfile;
use App\Http\Controllers\v1\Admin\{PermissionController, RoleController, UserController};
use App\Http\Controllers\v1\Auth\AuthController;
use App\Http\Controllers\v1\Library\{AuthorController, BookController, CategoryController, LoanController};
use App\Http\Controllers\v1\User\ProfileController;
use Illuminate\Support\Facades\Route;
use Spatie\ResponseCache\Middlewares\CacheResponse;

Route::prefix('v1')->group(function () {

    // -------------------------
    // Public authentication routes
    // -------------------------
    Route::post('register', [AuthController::class, 'register'])->name('auth.register'); // User registration
    Route::post('login', [AuthController::class, 'login'])->name('auth.login'); // User login

    // -------------------------
    // Protected routes (require auth:sanctum)
    // -------------------------
    Route::middleware('auth:sanctum')->group(function () {

        // -------------------------
        // User profile management
        // -------------------------
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'show'])
                ->name('profile.show')
                ->middleware(CacheResponse::class); // Cache profile data for GET
            Route::put('/', [ProfileController::class, 'update'])->name('profile.update'); // Update profile
            Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword'); // Update password
        });

        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout'); // User logout

        // -------------------------
        // Library domain (Books, Authors, Categories, Loans)
        // -------------------------

        // Books CRUD routes
        Route::get('books', [BookController::class, 'index'])
            ->name('books.index')
            ->middleware(CacheResponse::class); // Cache GET list
        Route::get('books/{book}', [BookController::class, 'show'])
            ->name('books.show')
            ->middleware(CacheResponse::class); // Cache GET single book
        Route::post('books', [BookController::class, 'store'])->name('books.store'); // Create book
        Route::put('books/{book}', [BookController::class, 'update'])->name('books.update'); // Update book
        Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy'); // Delete book

        // Authors CRUD routes
        Route::get('authors', [AuthorController::class, 'index'])
            ->name('authors.index')
            ->middleware(CacheResponse::class); // Cache GET list
        Route::get('authors/{author}', [AuthorController::class, 'show'])
            ->name('authors.show')
            ->middleware(CacheResponse::class); // Cache GET single author
        Route::post('authors', [AuthorController::class, 'store'])->name('authors.store'); // Create author
        Route::put('authors/{author}', [AuthorController::class, 'update'])->name('authors.update'); // Update author
        Route::delete('authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy'); // Delete author

        // Categories CRUD routes
        Route::get('categories', [CategoryController::class, 'index'])
            ->name('categories.index')
            ->middleware(CacheResponse::class); // Cache GET list
        Route::get('categories/{category}', [CategoryController::class, 'show'])
            ->name('categories.show')
            ->middleware(CacheResponse::class); // Cache GET single category
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store'); // Create category
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update'); // Update category
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy'); // Delete category

        // Loans routes
        Route::get('loans', [LoanController::class, 'index'])
            ->name('loans.index')
            ->middleware(CacheResponse::class); // Cache GET list of loans
        Route::get('loans/{loan}', [LoanController::class, 'show'])
            ->name('loans.show')
            ->middleware(CacheResponse::class); // Cache GET single loan
        Route::post('loans', [LoanController::class, 'store'])->name('loans.store'); // Create loan
        Route::post('loans/{loan}/return', [LoanController::class, 'return'])->name('loans.return'); // Return a loan
        Route::post('loans/{loan}/cancel', [LoanController::class, 'cancel'])->name('loans.cancel'); // Cancel a loan

        // -------------------------
        // Admin domain (requires access-admin-panel permission)
        // -------------------------
        Route::prefix('admin')->middleware('can:access-admin-panel')->group(function () {

            // Users management
            Route::apiResource('users', UserController::class)->names([
                'index' => 'admin.users.index',
                'store' => 'admin.users.store',
                'show' => 'admin.users.show',
                'update' => 'admin.users.update',
                'destroy' => 'admin.users.destroy',
            ]);

            // Roles management (no caching)
            Route::apiResource('roles', RoleController::class)->names([
                'index' => 'admin.roles.index',
                'store' => 'admin.roles.store',
                'show' => 'admin.roles.show',
                'update' => 'admin.roles.update',
                'destroy' => 'admin.roles.destroy',
            ]);

            // Permissions management (no caching)
            Route::apiResource('permissions', PermissionController::class)->names([
                'index' => 'admin.permissions.index',
                'store' => 'admin.permissions.store',
                'show' => 'admin.permissions.show',
                'update' => 'admin.permissions.update',
                'destroy' => 'admin.permissions.destroy',
            ]);
        });
    });
});
