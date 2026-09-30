<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CertificationController;
use App\Http\Controllers\Admin\ChatbotFaqController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DemoRequestController;
use App\Http\Controllers\Admin\LedModuleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ThemeSectionController;
use App\Http\Controllers\Store\AccountAuthController;
use App\Http\Controllers\Store\AccountController;
use App\Http\Controllers\Store\BlogController;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\WishlistController;
use App\Http\Controllers\Store\CatalogueController as StoreCatalogueController;
use App\Http\Controllers\Store\ChatbotController;
use App\Http\Controllers\Store\CategoryController as StoreCategoryController;
use App\Http\Controllers\Store\CertificationController as StoreCertificationController;
use App\Http\Controllers\Store\DemoRequestController as StoreDemoRequestController;
use App\Http\Controllers\Store\HomeController;
use App\Http\Controllers\Store\LedWallCalculatorController;
use App\Http\Controllers\Store\LegacyRedirectController;
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

// Glass Displays were called Industrial Displays: keep old links working.
Route::permanentRedirect('/industrial-displays', '/glass-displays');
Route::permanentRedirect('/category/industrial-displays', '/category/glass-displays');
Route::permanentRedirect('/product/yara-industrial-display', '/product/yara-glass-display');

// Renamed / retired product links (one route, since Laravel keeps only one route per URI):
//  - HD TVs were called "HD Ready": /product/yara-32-inch-hd-ready-google-tv -> ...-hd-google-tv
//  - LCD video walls have no fixed models any more (32" to 100", configured per project) -> the LCD page
Route::get('/product/{slug}', function (string $slug) {
    if (preg_match('/^yara-\d+-inch-lcd-video-wall-/', $slug)) {
        return redirect()->route('store.lcdwalls', [], 301);
    }

    return redirect('/product/' . str_replace('-hd-ready-', '-hd-', $slug), 301);
})->where('slug', '(.*-hd-ready-.*|yara-\d+-inch-lcd-video-wall-.*)');

Route::get('/category/{category:slug}', [StoreCategoryController::class, 'show'])
    ->name('store.category');

Route::get('/product/{product:slug}', [StoreProductController::class, 'show'])
    ->name('store.product');

Route::get('/search', [SearchController::class, 'index'])->name('store.search');

Route::get('/search/suggest', [SearchController::class, 'suggest'])->name('store.search.suggest');

Route::get('/about-us', [PageController::class, 'about'])->name('store.about');

Route::get('/centum', [PageController::class, 'centum'])->name('store.centum');

Route::get('/chillers', [PageController::class, 'chillers'])->name('store.chillers');

Route::get('/t-standees', [PageController::class, 'tStandees'])->name('store.tstandees');

Route::get('/a-standees', [PageController::class, 'aStandees'])->name('store.astandees');

Route::get('/anti-glare-tv', [PageController::class, 'antiGlareTv'])->name('store.antiglare');

Route::get('/led-video-walls', [PageController::class, 'ledVideoWalls'])->name('store.ledwalls');

Route::get('/lcd-video-walls', [PageController::class, 'lcdVideoWalls'])->name('store.lcdwalls');

Route::get('/home-audio', [PageController::class, 'homeAudio'])->name('store.homeaudio');

Route::get('/commercial-displays', [PageController::class, 'commercialDisplays'])->name('store.commercialdisplays');

Route::get('/interactive-panels', [PageController::class, 'interactivePanels'])->name('store.interactivepanels');

Route::get('/printing-kiosk', [PageController::class, 'printingKiosk'])->name('store.printingkiosk');

Route::get('/stand-alone-kiosk', [PageController::class, 'standAloneKiosk'])->name('store.standalonekiosk');

Route::get('/table-top-standee', [PageController::class, 'tableTopStandee'])->name('store.tabletopstandee');

Route::get('/glass-displays', [PageController::class, 'glassDisplays'])->name('store.glassdisplays');

Route::get('/commercial-washing-machines', [PageController::class, 'commercialWashers'])->name('store.commercialwashers');

Route::get('/digital-podium', [PageController::class, 'digitalPodium'])->name('store.digitalpodium');

Route::get('/e-waste-management', [PageController::class, 'eWaste'])->name('store.e-waste');

Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('store.terms');

Route::get('/warranty-terms', [PageController::class, 'warranty'])->name('store.warranty');

Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('store.privacy');

Route::get('/delivery-and-returns', [PageController::class, 'delivery'])->name('store.delivery');

Route::get('/contact-us', [PageController::class, 'contact'])->name('store.contact');

Route::get('/catalogue', [StoreCatalogueController::class, 'index'])->name('store.catalogue');

Route::get('/certifications', [StoreCertificationController::class, 'index'])->name('store.certifications');

Route::get('/certifications/{certification}/download', [StoreCertificationController::class, 'download'])->name('store.certifications.download');

Route::get('/blog', [BlogController::class, 'index'])->name('store.blog.index');

Route::post('/chatbot/message', [ChatbotController::class, 'message'])
    ->middleware('throttle:30,1')
    ->name('store.chatbot.message');

Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('store.blog.show');

Route::get('/led-wall-calculator', [LedWallCalculatorController::class, 'index'])->name('store.led-calculator');

Route::post('/led-wall-calculator/calculate', [LedWallCalculatorController::class, 'calculate'])
    ->middleware('throttle:60,1')
    ->name('store.led-calculator.calculate');

Route::get('/book-a-demo', [StoreDemoRequestController::class, 'create'])->name('store.demo.create');

Route::post('/book-a-demo', [StoreDemoRequestController::class, 'store'])->name('store.demo.store');


/*
|--------------------------------------------------------------------------
| Customer accounts, wishlist and cart
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AccountAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AccountAuthController::class, 'login'])->middleware('throttle:10,1')->name('login.submit');
    Route::get('/register', [AccountAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AccountAuthController::class, 'register'])->middleware('throttle:10,1')->name('register.submit');
    Route::get('/forgot-password', [AccountAuthController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [AccountAuthController::class, 'sendReset'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/reset-password/{token}', [AccountAuthController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password', [AccountAuthController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AccountAuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::put('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/merge', [WishlistController::class, 'merge'])->name('wishlist.merge');
    Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/{product}/to-cart', [CartController::class, 'fromWishlist'])->name('wishlist.to-cart');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/mini', [CartController::class, 'mini'])->name('cart.mini');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->middleware('throttle:60,1')->name('cart.add');
Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/{item}/save-for-later', [CartController::class, 'saveForLater'])->name('cart.save-for-later');
Route::post('/cart/{item}/move-to-cart', [CartController::class, 'moveToCart'])->name('cart.move-to-cart');


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
        | Testimonials
        |--------------------------------------------------------------------------
        */

        Route::resource('testimonials', TestimonialController::class)
            ->except(['show']);


        /*
        |--------------------------------------------------------------------------
        | Blog
        |--------------------------------------------------------------------------
        */

        Route::post('posts/upload-image', [PostController::class, 'uploadImage'])
            ->name('posts.upload-image');

        Route::resource('posts', PostController::class)
            ->except(['show']);


        /*
        |--------------------------------------------------------------------------
        | Chatbot (knowledge base)
        |--------------------------------------------------------------------------
        */

        Route::delete('chatbot/unanswered', [ChatbotFaqController::class, 'dismissLog'])
            ->name('chatbot.dismiss-log');

        Route::resource('chatbot', ChatbotFaqController::class)
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
        | Certifications (downloadable certificates)
        |--------------------------------------------------------------------------
        */

        Route::resource('certifications', CertificationController::class)
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

/*
|--------------------------------------------------------------------------
| Old website addresses (must stay last)
|--------------------------------------------------------------------------
|
| Links from Google and the previous site (e.g. /32-hd-smart-led-tv2) are sent to
| their new page with a 301. See config/legacy_redirects.php.
*/

Route::fallback(LegacyRedirectController::class);
