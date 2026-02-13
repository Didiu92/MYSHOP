<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DashboardApiController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// ===========================================
// RUTAS PÚBLICAS (Sin autenticación requerida)
// ===========================================
// Welcome page - shows home page with featured content
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
// Contact page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
// Currency selector (public)
Route::post('/currency', [CurrencyController::class, 'set'])->name('currency.set');
// Dashboard API (admin + worker)
Route::middleware(['auth', 'worker'])->prefix('api/admin')->name('api.admin.')->group(function () {
    Route::get('/dashboard/overview', [DashboardApiController::class, 'overview'])->name('dashboard.overview');
});
// Rutas de categorías (solo lectura)
Route::resource('categories', CategoryController::class)->only(['index', 'show']);
// Rutas de productos (solo lectura)
Route::get('/products-on-sale', [ProductController::class, 'onSale'])->name('products.on-sale');
Route::resource('products', ProductController::class)->only(['index', 'show']);
// Rutas de ofertas (solo lectura)
Route::resource('offers', OfferController::class)->only(['index', 'show']);
// ===========================================
// RUTAS DE USUARIO AUTENTICADO (Breeze)
// ===========================================
Route::middleware('auth')->group(function () {
 // Perfil de usuario
 Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
 Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
 Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

 // Wishlist accesible para usuarios autenticados (no requiere admin)
 Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
 Route::post('/wishlist/{id}', [WishlistController::class, 'store'])->name('wishlist.store');
 Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

 // Carrito de compras (requiere login)
 Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
 Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
 Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
 Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
 Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
 Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});
// ===========================================
// RUTAS DE TRABAJADORES (Lectura, dashboard)
// ===========================================
Route::middleware(['auth', 'worker'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/estadisticas', [DashboardController::class, 'statistics'])->name('dashboard.stats');

    // Listados de solo lectura para staff
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products.index');
    Route::get('/categories', [CategoryController::class, 'adminIndex'])->name('categories.index');
    Route::get('/offers', [OfferController::class, 'adminIndex'])->name('offers.index');
});

// ===========================================
// RUTAS DE ADMINISTRACIÓN (Protegidas + Solo Admin)
// ===========================================
Route::middleware(['auth', 'admin', 'log.activity'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users/check-email', [AdminUserController::class, 'checkEmail'])->name('users.check-email');
    // Rutas de gestión de productos
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    Route::post('products/{product}/reorder-images', [ProductController::class, 'reorderImages'])->name('products.reorder-images');

    // Categorías
    Route::resource('categories', CategoryController::class)->except(['index', 'show']);

    // Ofertas
    Route::resource('offers', OfferController::class)->except(['index', 'show']);

    // Usuarios
    Route::resource('users', AdminUserController::class);
});
// Las rutas de autenticación (login, register, etc.) se incluyen desde aquí
require __DIR__.'/auth.php';

