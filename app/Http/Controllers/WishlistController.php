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
        $wishlistProducts = $user->products()->with(['category', 'offer', 'images'])->get();
        
        return view('admin.wishlist.index', [
            'wishlistProducts' => $wishlistProducts
        ]);
    }

    /**
     * Añade o elimina un producto de la lista de deseos (toggle).
     */
    public function store(string $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $product = Product::findOrFail($id);
        
        // Verificar si ya está en la wishlist
        $isInWishlist = $user->products()->where('product_id', $id)->exists();
        
        if ($isInWishlist) {
            // Eliminar de la wishlist
            $user->products()->detach($id);
            $message = 'Producto eliminado de tu lista de deseos.';
            $inWishlist = false;
        } else {
            // Añadir a la wishlist
            $user->products()->attach($id, ['quantity' => 1]);
            $message = '¡Producto añadido a tu lista de deseos!';
            $inWishlist = true;
        }
        
        // Si es una petición AJAX, devolver JSON
        if (request()->ajax() || request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'inWishlist' => $inWishlist
            ]);
        }
        
        return redirect()->back()->with('success', $message);
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