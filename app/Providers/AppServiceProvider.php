<?php

namespace App\Providers;

use App\Http\Controllers\Admin\SettingController;
use App\Models\Category;
use App\Models\DemoRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
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

            $logo = Setting::current()->logo;
            $lightLogo = $logo ? SettingController::lightVariantPath($logo) : null;

            // The white version is made when the logo is uploaded in Settings. If it's missing (logo uploaded
            // before that existed, or storage copied without it), make it now, once, instead of showing the
            // dark-on-white logo in the dark header.
            if ($lightLogo && ! Storage::disk('public')->exists($lightLogo) && Storage::disk('public')->exists($logo)) {
                SettingController::makeLightVariant($logo);
            }

            $view->with('siteLogo', $logo);

            // White version for the dark header/footer; falls back to the normal logo.
            $view->with('siteLogoLight', $lightLogo && Storage::disk('public')->exists($lightLogo) ? $lightLogo : null);

            // Shop boot data for resources/js/shop.js
            $view->with('shopBoot', [
                'auth' => auth()->check(),
                'name' => auth()->user()?->name,
                'wishlist' => auth()->check() ? auth()->user()->wishlistItems()->pluck('product_id') : [],
                'cartCount' => app(\App\Services\Cart::class)->count(),
                'toast' => session('toast'),
                'routes' => [
                    'login' => route('login', ['redirect' => '/' . ltrim(request()->path(), '/')]),
                    'wishlist' => route('wishlist.toggle', '__ID__'),
                    'wishlistMerge' => route('wishlist.merge'),
                    'wishlistPage' => route('wishlist.index'),
                    'cartAdd' => route('cart.add', '__ID__'),
                    'cartMini' => route('cart.mini'),
                    'cartItem' => route('cart.update', '__ID__'),
                    'cartPage' => route('cart.index'),
                ],
            ]);
        });

        View::composer('admin.layouts.app', function ($view) {
            $view->with('unreadDemoRequestsCount', DemoRequest::unread()->count());
        });
    }
}
