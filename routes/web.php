<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DemoRequestController;
use App\Http\Controllers\Admin\LedModuleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ThemeSectionController;
use App\Http\Controllers\Store\CatalogueController as StoreCatalogueController;
use App\Http\Controllers\Store\CategoryController as StoreCategoryController;
use App\Http\Controllers\Store\DemoRequestController as StoreDemoRequestController;
use App\Http\Controllers\Store\HomeController;
use App\Http\Controllers\Store\LedWallCalculatorController;
use App\Http\Controllers\Store\PageController;
use App\Http\Controllers\Store\ProductController as StoreProductController;
use App\Http\Controllers\Store\SearchController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Store
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('store.home');

Route::get('/category/{category:slug}', [StoreCategoryController::class, 'show'])
    ->name('store.category');

Route::get('/product/{product:slug}', [StoreProductController::class, 'show'])
    ->name('store.product');

Route::get('/search', [SearchController::class, 'index'])->name('store.search');

Route::get('/search/suggest', [SearchController::class, 'suggest'])->name('store.search.suggest');

Route::get('/about-us', [PageController::class, 'about'])->name('store.about');

Route::get('/e-waste-management', [PageController::class, 'eWaste'])->name('store.e-waste');

Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('store.terms');

Route::get('/warranty-terms', [PageController::class, 'warranty'])->name('store.warranty');

Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('store.privacy');

Route::get('/delivery-and-returns', [PageController::class, 'delivery'])->name('store.delivery');

Route::get('/contact-us', [PageController::class, 'contact'])->name('store.contact');

Route::get('/catalogue', [StoreCatalogueController::class, 'index'])->name('store.catalogue');

Route::get('/led-wall-calculator', [LedWallCalculatorController::class, 'index'])->name('store.led-calculator');

Route::post('/led-wall-calculator/calculate', [LedWallCalculatorController::class, 'calculate'])
    ->middleware('throttle:60,1')
    ->name('store.led-calculator.calculate');

Route::get('/book-a-demo', [StoreDemoRequestController::class, 'create'])->name('store.demo.create');

Route::post('/book-a-demo', [StoreDemoRequestController::class, 'store'])->name('store.demo.store');


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::redirect('/admin', '/admin/dashboard');

Route::prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');


    /*
    |--------------------------------------------------------------------------
    | Protected Admin Area
    |--------------------------------------------------------------------------
    */

    Route::middleware('admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        Route::resource('categories', CategoryController::class)
            ->except(['show']);

        Route::patch(
            'categories/{category}/toggle-status',
            [CategoryController::class, 'toggleStatus']
        )->name('categories.toggle-status');


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        Route::resource('products', ProductController::class);

        Route::delete(
            'products/{product}/images/{image}',
            [ProductController::class, 'destroyImage']
        )->name('products.images.destroy');

        Route::patch(
            'products/{product}/images/{image}/primary',
            [ProductController::class, 'setPrimaryImage']
        )->name('products.images.primary');


        /*
        |--------------------------------------------------------------------------
        | Attributes
        |--------------------------------------------------------------------------
        */

        Route::resource('attributes', AttributeController::class)
            ->except(['show']);

        Route::post(
            'attributes/{attribute}/values',
            [AttributeValueController::class, 'store']
        )->name('attributes.values.store');

        Route::delete(
            'attributes/{attribute}/values/{value}',
            [AttributeValueController::class, 'destroy']
        )->name('attributes.values.destroy');


        /*
        |--------------------------------------------------------------------------
        | Homepage / Theme Sections
        |--------------------------------------------------------------------------
        */

        Route::resource('theme-sections', ThemeSectionController::class);


        /*
        |--------------------------------------------------------------------------
        | Banners
        |--------------------------------------------------------------------------
        */

        Route::resource('banners', BannerController::class)
            ->except(['show']);


        /*
        |--------------------------------------------------------------------------
        | Catalogues
        |--------------------------------------------------------------------------
        */

        Route::resource('catalogues', CatalogueController::class)
            ->except(['show']);


        /*
        |--------------------------------------------------------------------------
        | LED Modules (LED wall calculator)
        |--------------------------------------------------------------------------
        */

        Route::resource('led-modules', LedModuleController::class)
            ->except(['show']);


        /*
        |--------------------------------------------------------------------------
        | Settings
        |--------------------------------------------------------------------------
        */

        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');

        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');


        /*
        |--------------------------------------------------------------------------
        | Demo Requests
        |--------------------------------------------------------------------------
        */

        Route::get('demo-requests', [DemoRequestController::class, 'index'])->name('demo-requests.index');

        Route::patch('demo-requests/{demoRequest}/read', [DemoRequestController::class, 'markRead'])
            ->name('demo-requests.read');

        Route::post('demo-requests/mark-all-read', [DemoRequestController::class, 'markAllRead'])
            ->name('demo-requests.mark-all-read');

        Route::delete('demo-requests/{demoRequest}', [DemoRequestController::class, 'destroy'])
            ->name('demo-requests.destroy');


        /*
        |--------------------------------------------------------------------------
        | Logout
        |--------------------------------------------------------------------------
        */

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');

    });

});