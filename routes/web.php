<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
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
Route::get('/contact', function () {
 return view('contact');
})->name('contact');
// Rutas de categorías (solo lectura)
Route::resource('categories', CategoryController::class)->only(['index', 'show']);
// Rutas de productos (solo lectura)
Route::get('/products-on-sale', [ProductController::class, 'onSale'])->name('products.on-sale');
Route::resource('products', ProductController::class)->only(['index', 'show']);
// Rutas de ofertas (solo lectura)
Route::resource('offers', OfferController::class)->only(['index', 'show']);
// Rutas del carrito de compras (ahora completas)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
// ===========================================
// RUTAS DE USUARIO AUTENTICADO (Breeze)
// ===========================================
Route::middleware('auth')->group(function () {
 // Dashboard
 Route::get('/dashboard', function () {
 return view('dashboard');
 })->name('dashboard');
 // Perfil de usuario
 Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
 Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
 Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

 // Wishlist accesible para usuarios autenticados (no requiere admin)
 Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
 Route::post('/wishlist/{id}', [WishlistController::class, 'store'])->name('wishlist.store');
 Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});
// ===========================================
// RUTA DE LISTADO ADMIN (Solo autenticados, lectura)
// ===========================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products.index');
});

// ===========================================
// RUTAS DE ADMINISTRACIÓN (Protegidas + Solo Admin)
// ===========================================
Route::middleware(['auth', 'admin', 'log.activity'])->prefix('admin')->name('admin.')->group(function () {
    // Rutas de gestión de productos
    Route::resource('products', ProductController::class)->except(['index', 'show']);
});
// Las rutas de autenticación (login, register, etc.) se incluyen desde aquí
require __DIR__.'/auth.php';

