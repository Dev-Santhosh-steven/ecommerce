<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ThemeSectionController;
use App\Http\Controllers\Store\CategoryController as StoreCategoryController;
use App\Http\Controllers\Store\HomeController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Store
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('store.home');

Route::get('/category/{category:slug}', [StoreCategoryController::class, 'show'])
    ->name('store.category');


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
        | Logout
        |--------------------------------------------------------------------------
        */

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');

    });

});