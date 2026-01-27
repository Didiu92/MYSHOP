<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class OfferController extends Controller
{
    /**
     * Show all offers
     */
    public function index(Request $request): View
    {
        $query = Offer::query();
        
        // Búsqueda por nombre, descripción o porcentaje de descuento
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('discount_percentage', 'like', "%{$search}%");
            });
        }
        
        $offers = $query->get();
        $search = $request->input('search', '');
        
        return view('offers.index', compact('offers', 'search'));
    }

    /**
     * Admin: listado de ofertas.
     */
    public function adminIndex(Request $request): View
    {
        $query = Offer::query();
        
        // Búsqueda por nombre, descripción o porcentaje de descuento
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('discount_percentage', 'like', "%{$search}%");
            });
        }
        
        $offers = $query->latest()->get();
        return view('admin.offers.index', compact('offers'));
    }

    /**
     * Admin: formulario de creación.
     */
    public function create(): View
    {
        return view('admin.offers.create');
    }

    /**
     * Admin: guardar nueva oferta.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:offers,name',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        $data['slug'] = Str::slug($data['name']);

        Offer::create($data);

        return redirect()->route('admin.offers.index')->with('success', 'Oferta creada correctamente');
    }

    /**
     * Show products with a specific offer
     */
    public function show(string $id): View
    {
        // Validate ID format
        if (!is_numeric($id) || $id < 1) {
            abort(404, 'ID de oferta inválido');
        }

        $offer = Offer::find($id);

        if (!$offer) {
            abort(404, 'Oferta no encontrada');
        }

        $offerProducts = $offer->products()->with(['category'])->get();

        return view('offers.show', compact('offer', 'offerProducts'));
    }

    /**
     * Admin: formulario de edición.
     */
    public function edit(Offer $offer): View
    {
        return view('admin.offers.edit', compact('offer'));
    }

    /**
     * Admin: actualizar oferta.
     */
    public function update(Request $request, Offer $offer): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:offers,name,' . $offer->id,
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        $data['slug'] = Str::slug($data['name']);

        $offer->update($data);

        return redirect()->route('offers.show', $offer->id)->with('success', 'Oferta actualizada correctamente');
    }

    /**
     * Admin: eliminar oferta.
     */
    public function destroy(Offer $offer): RedirectResponse
    {
        $offer->delete();
        return redirect()->route('admin.offers.index')->with('success', 'Oferta eliminada');
    }
}
