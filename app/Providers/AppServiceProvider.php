<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
        // Pasar categorías con productos a la vista del portfolio
        View::composer('partials.portfolio', function ($view) {
            $categories = Category::with('products')->orderBy('name')->get();
            $view->with('categories', $categories);
        });
    }
}
