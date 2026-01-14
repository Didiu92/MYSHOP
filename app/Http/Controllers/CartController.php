<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Show cart overview
     */
    public function index(): View
    {
        // Por ahora, mostramos el carrito del primer usuario
        // En la Práctica 4 se implementará la autenticación
        $userId = 1; // Usuario por defecto
        $user = User::find($userId);
        $cartProducts = $user->products; // Obtiene productos con datos pivot

        return view('cart.index', [
            'cartProducts' => $cartProducts
        ]);
    }

    /**
     * Store a newly created cart item
     */
    public function store(Request $request)
    {
        // En una aplicación real, aquí se guardaría el producto en el carrito
        // Por ahora, solo redirigimos al carrito con un mensaje
        return redirect()->route('cart.index')
            ->with('success', 'Producto añadido al carrito exitosamente');
    }

    /**
     * Update the specified cart item
     */
    public function update(Request $request, string $id)
    {
        // En una aplicación real, aquí se actualizaría la cantidad del producto en el carrito
        // Por ahora, solo redirigimos al carrito con un mensaje
        return redirect()->route('cart.index')
            ->with('success', 'Cantidad actualizada exitosamente');
    }
}
