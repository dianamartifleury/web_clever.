<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Importación de controladores
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\{
    ContactFormController,
    AdminController,
    ProductController,
    Auth\AuthenticatedSessionController,
    AiChatController,
    CustomerMetadataController,
    CookieEventController,
    ProfileController
};

/*
|--------------------------------------------------------------------------
| 🌍 RUTAS PÚBLICAS SIN IDIOMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $categories = Category::all();
    return view('index', compact('categories'));
})->name('home.nolocale');

Route::get('/contact', [ContactFormController::class, 'create'])
    ->name('contact.form.nolocale');

Route::post('/contact', [ContactFormController::class, 'store'])
    ->name('contact.store.nolocale');

Route::view('/portfolio', 'portfolio-details');
Route::view('/service', 'service-details');
Route::view('/starter', 'starter-page');
Route::view('/privacy-policy', 'partials.privacy-policy')->name('privacy-policy');

Route::get('/portfolio', [ProductController::class, 'portfolio'])->name('portfolio');

Route::get('/products', [ProductController::class, 'indexPublic'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'showPublic'])->name('products.show');

Route::post('/ai-chat/ask', [AiChatController::class, 'ask'])->name('ai-chat.ask');

/*
|--------------------------------------------------------------------------
| 🧩 METADATA / COOKIES (Públicas)
|--------------------------------------------------------------------------
*/
Route::post('/metadata/consent', [CustomerMetadataController::class, 'storeConsent'])->name('metadata.consent');
Route::post('/metadata/trace', [CustomerMetadataController::class, 'storeTrace'])->name('metadata.trace');
Route::post('/cookie-events', [CookieEventController::class, 'store'])->name('cookie.events');
Route::post('/check-visitor-blocked', [CustomerMetadataController::class, 'checkBlocked'])
    ->name('metadata.check_blocked');

/*
|--------------------------------------------------------------------------
| 🌐 RUTAS MULTI-IDIOMA (Frontend)
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => 'es|en|it|fr']
], function () {

    // Home multi-idioma
    Route::get('/', function ($locale) {
        App::setLocale($locale);
        $categories = Category::all();
        return view('index', compact('categories'));
    })->name('home');

    Route::get('/portfolio', fn($locale) => view('portfolio-details'))->name('portfolio.locale');
    Route::get('/service', fn($locale) => view('service-details'))->name('service.locale');
    Route::get('/starter', fn($locale) => view('starter-page'))->name('starter.locale');

    // Contacto multi-idioma
    Route::get('/contact', function ($locale) {
        App::setLocale($locale);
        return app()->call([ContactFormController::class, 'create']);
    })->name('contact.form.locale');

    Route::post('/contact', function ($locale) {
        App::setLocale($locale);
        return app()->call([ContactFormController::class, 'store']);
    })->name('contact.store.locale');

    // Chat AI multi-idioma
    Route::post('/ai-chat/ask', function ($locale, \Illuminate\Http\Request $request) {
        App::setLocale($locale);
        return app()->call([AiChatController::class, 'ask'], ['request' => $request]);
    })->name('ai-chat.ask.locale');

    // Metadata frontend multi-idioma
    Route::get('/admin/metadata', [AdminController::class, 'showMetadata'])
        ->name('customers.metadata.locale');
});

/*
|--------------------------------------------------------------------------
| 🔐 RUTAS PROTEGIDAS (Dashboard / Administración)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Clientes
    Route::get('/admin/clientes', [AdminController::class, 'index'])->name('customers.index');
    Route::get('/admin/clientes/filtrar', [AdminController::class, 'filter'])->name('customers.filter');
    Route::get('/admin/clientes/exportar', [AdminController::class, 'exportExcel'])->name('customers.export');
    Route::get('/customers/{customer}', [AdminController::class, 'show'])->name('customers.show');
    Route::get('/admin/metadata', [AdminController::class, 'showMetadata'])->name('customers.metadata');

    // Productos
    Route::get('/dashboard/products', [ProductController::class, 'index'])->name('dashboard.products');
    Route::get('/dashboard/products/create', [ProductController::class, 'create'])->name('dashboard.products.create');
    Route::post('/dashboard/products', [ProductController::class, 'store'])->name('dashboard.products.store');
    Route::get('/dashboard/products/{product}', [ProductController::class, 'show'])->name('dashboard.products.show');
    Route::patch('/dashboard/products/{product}', [ProductController::class, 'update'])->name('dashboard.products.update');
    Route::get('/dashboard/products/{product}/delete', [ProductController::class, 'confirmDelete'])->name('dashboard.products.confirmDelete');
    Route::patch('/dashboard/products/{product}/stock', [ProductController::class, 'updateStock'])->name('dashboard.products.updateStock');
    Route::delete('/dashboard/products/{product}', [ProductController::class, 'destroy'])->name('dashboard.products.destroy');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Cambio de idioma simple
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', function ($locale) {
    $available = ['en', 'es', 'fr', 'it'];
    if (in_array($locale, $available)) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
  

