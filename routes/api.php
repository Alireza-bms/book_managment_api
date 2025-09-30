<?php

use App\Http\Controllers\v1\Admin\{PermissionController, RoleController, UserController};
use App\Http\Controllers\v1\Auth\AuthController;
use App\Http\Controllers\v1\Library\{AuthorController, BookController, CategoryController, LoanController};
use App\Http\Controllers\v1\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // -------------------------
    // Authentication (public)
    // -------------------------
    Route::post('register', [AuthController::class, 'register'])->name('auth.register'); // Register new user
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');           // Login user

    // -------------------------
    // Protected routes (require auth:sanctum)
    // -------------------------
    Route::middleware('auth:sanctum')->group(function () {

        // -------------------------
        // User profile management
        // -------------------------
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'show'])->name('profile.show');             // Show authenticated user profile
            Route::put('/', [ProfileController::class, 'update'])->name('profile.update');         // Update profile info
            Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword'); // Update password
        });

        // Logout
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

        // -------------------------
        // Library domain
        // -------------------------

        // Books CRUD
        Route::apiResource('books', BookController::class)->names([
            'index' => 'books.index',
            'store' => 'books.store',
            'show' => 'books.show',
            'update' => 'books.update',
            'destroy' => 'books.destroy',
        ]);

        // Authors CRUD
        Route::apiResource('authors', AuthorController::class)->names([
            'index' => 'authors.index',
            'store' => 'authors.store',
            'show' => 'authors.show',
            'update' => 'authors.update',
            'destroy' => 'authors.destroy',
        ]);

        // Categories CRUD
        Route::apiResource('categories', CategoryController::class)->names([
            'index' => 'categories.index',
            'store' => 'categories.store',
            'show' => 'categories.show',
            'update' => 'categories.update',
            'destroy' => 'categories.destroy',
        ]);

        // Loans: borrow, return, cancel
        Route::prefix('loans')->group(function () {
            Route::get('/', [LoanController::class, 'index'])->name('loans.index'); // List all loans
            Route::get('{loan}', [LoanController::class, 'show'])->name('loans.show'); // Show specific loan
            Route::post('/', [LoanController::class, 'store'])->name('loans.store'); // Borrow a book
            Route::post('{loan}/return', [LoanController::class, 'return'])->name('loans.return'); // Return a borrowed book
            Route::post('{loan}/cancel', [LoanController::class, 'cancel'])->name('loans.cancel'); // Cancel an active loan
        });


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

            // Roles management
            Route::apiResource('roles', RoleController::class)->names([
                'index' => 'admin.roles.index',
                'store' => 'admin.roles.store',
                'show' => 'admin.roles.show',
                'update' => 'admin.roles.update',
                'destroy' => 'admin.roles.destroy',
            ]);

            // Permissions management
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
