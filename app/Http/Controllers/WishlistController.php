<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WishlistController extends Controller
{
    /**
     * Muestra la lista de deseos del usuario autenticado.
     */
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $wishlistProducts = $user->products()->with(['category', 'offer'])->get();
        
        return view('admin.wishlist.index', [
            'wishlistProducts' => $wishlistProducts
        ]);
    }

    /**
     * Añade un producto a la lista de deseos.
     */
    public function store(string $id): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $product = Product::findOrFail($id);
        
        // Verificar si ya está en la wishlist
        if ($user->products()->where('product_id', $id)->exists()) {
            return redirect()->back()->with('info', 'Este producto ya está en tu lista de deseos.');
        }
        
        // Añadir a la wishlist
        $user->products()->attach($id, ['quantity' => 1]);
        
        return redirect()->back()->with('success', '¡Producto añadido a tu lista de deseos!');
    }

    /**
     * Elimina un producto de la lista de deseos.
     */
    public function destroy(string $id): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->products()->detach($id);
        
        return redirect()->back()->with('success', 'Producto eliminado de tu lista de deseos.');
    }
}