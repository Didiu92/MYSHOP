<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;


// Ruta principal
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Rutas del carrito
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart', [CartController::class, 'store'])->name('cart.store');
Route::put('cart/{id}', [CartController::class, 'update'])->name('cart.update');

// Rutas de categorías
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

// Contact page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Rutas de ofertas
Route::get('offers', [OfferController::class, 'index'])->name('offers.index');
Route::get('offers/{offer}', [OfferController::class, 'show'])->name('offers.show');

// Rutas de productos en oferta (debe ir antes del resource para evitar conflictos)
Route::get('products-on-sale', [ProductController::class, 'onSale'])->name('products.on-sale');

// Rutas de productos (resource completo)
Route::resource('products', ProductController::class);
