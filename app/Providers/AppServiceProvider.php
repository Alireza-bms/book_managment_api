<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\User;
use App\Observers\AuthorObserver;
use App\Observers\BookObserver;
use App\Observers\CategoryObserver;
use App\Observers\LoanObserver;
use App\Observers\UserObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        Author::observe(AuthorObserver::class);
        Book::observe(BookObserver::class);
        Category::observe(CategoryObserver::class);
        Loan::observe(LoanObserver::class);
        User::observe(UserObserver::class);
    }
}
