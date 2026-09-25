<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\DemoRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('layouts.store', function ($view) {
            $view->with('navCategories', Category::active()
                ->topLevel()
                ->with(['children' => function ($query) {
                    $query->active()->orderBy('sort_order')->orderBy('name');
                }])
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get());

            $view->with('siteLogo', Setting::current()->logo);
        });

        View::composer('admin.layouts.app', function ($view) {
            $view->with('unreadDemoRequestsCount', DemoRequest::unread()->count());
        });
    }
}
