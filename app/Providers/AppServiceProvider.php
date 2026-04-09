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
    
    public function boot()
    {
        // Disponible dans toutes les vues du header
        View::composer('client.body.header', function ($view) {
            $view->with('headerCategories', 
                Category::where('status', 1)
                        ->withCount(['products' => fn($q) => $q->where('status', 'published')])
                        ->get()
            );
        });
    }
}
