<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use App\Models\Category;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::with(['category', 'offer'])->get();
        return view('products.index', ['products' => $products]);
    }

    /**
     * Display only products that have an active offer
     */
    public function onSale(): View
    {
        $products = Product::with(['category', 'offer'])
            ->whereNotNull('offer_id')
            ->get();
        return view('products.index', ['products' => $products]);
    }

       /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create(): View
    {
        // Cargar todas las categorías y ofertas para los selectores del formulario
        $categories = Category::all();
        $offers = Offer::all();
        
        return view('admin.products.create', compact('categories', 'offers'));
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        // PASO 1: Validar todos los datos del formulario, incluyendo la imagen
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price' => 'required|numeric|min:0|max:999999.99',
            'category_id' => 'required|exists:categories,id',
            'offer_id' => 'nullable|exists:offers,id',
        ], [
            'name.required' => 'El nombre del producto es obligatorio.',
            'name.unique' => 'Ya existe un producto con ese nombre.',
            'description.required' => 'La descripción es obligatoria.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, webp.',
            'image.max' => 'La imagen no debe superar los 2MB.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'category_id.required' => 'Debes seleccionar una categoría.',
            'category_id.exists' => 'La categoría seleccionada no es válida.',
            'offer_id.exists' => 'La oferta seleccionada no es válida.',
        ]);

        // PASO 2: Procesar la imagen si fue subida
        if ($request->hasFile('image')) {
            // Guardar en el disco 'public' dentro de la carpeta 'products'
            // Laravel genera automáticamente un nombre único para evitar colisiones
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // PASO 3: Crear el producto con los datos validados
        Product::create($validated);

        // PASO 4: Redirigir con mensaje de éxito
        return redirect()
            ->route('admin.products.index')
            ->with('success', '¡Producto creado exitosamente!');
    }

    /**
     * Muestra la lista de productos en el panel de administración.
     */
public function adminIndex(): View
{
    $products = Product::with(['category', 'offer'])->latest()->get();
    return view('admin.products.index', compact('products'));
}

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        // Validate ID format
        if (!is_numeric($id) || $id < 1) {
            abort(404, 'ID de producto inválido');
        }

        $product = Product::with(['category', 'offer'])->find($id);

        if (!$product) {
            abort(404, 'Producto no encontrado');
        }

        $category = $product->category;

        return view('products.show', compact('product', 'category'));
    }

    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function edit(Product $product): View
    {
        // Cargar todas las categorías y ofertas para los selectores del formulario
        $categories = Category::all();
        $offers = Offer::all();
        
        return view('admin.products.edit', compact('product', 'categories', 'offers'));
    }

    /**
     * Actualiza un producto existente en la base de datos.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        // PASO 1: Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price' => 'required|numeric|min:0|max:999999.99',
            'category_id' => 'required|exists:categories,id',
            'offer_id' => 'nullable|exists:offers,id',
        ]);

        // PASO 2: Manejar la subida de la nueva imagen
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe para no acumular archivos
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Guardar la nueva imagen y obtener su ruta
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // PASO 3: Actualizar el producto con los datos validados
        $product->update($validated);

        // PASO 4: Redirigir con mensaje de éxito
        return redirect()
            ->route('admin.products.index')
            ->with('success', '¡Producto actualizado exitosamente!');
    }

     /**
     * Elimina un producto de la base de datos.
     */
    public function destroy(Product $product): RedirectResponse
    {
        // PASO 1: Eliminar la imagen asociada si existe
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // PASO 2: Eliminar el producto de la base de datos
        $product->delete();

        // PASO 3: Redirigir con mensaje de éxito
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    
}
