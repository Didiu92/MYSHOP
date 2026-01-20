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
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'offer']);
        
        // Búsqueda por nombre, descripción o categoría
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($catQuery) use ($search) {
                      $catQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filtro por categoría
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }
        
        // Filtro por oferta
        if ($request->filled('has_offer')) {
            if ($request->input('has_offer') === 'yes') {
                $query->whereNotNull('offer_id');
            } elseif ($request->input('has_offer') === 'no') {
                $query->whereNull('offer_id');
            }
        }
        
        // Ordenamiento
        $sortBy = $request->input('sort_by', '');
        switch ($sortBy) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc'); // Por defecto, más recientes primero
                break;
        }
        
        $products = $query->get();
        
        // Filtro por rango de precio (aplicando sobre el precio final después de ofertas)
        if ($request->filled('price_min') || $request->filled('price_max')) {
            $priceMinFilter = $request->filled('price_min') ? (float)$request->input('price_min') : 0;
            $priceMaxFilter = $request->filled('price_max') ? (float)$request->input('price_max') : PHP_FLOAT_MAX;
            
            $products = $products->filter(function ($product) use ($priceMinFilter, $priceMaxFilter) {
                $finalPrice = $product->final_price;
                return $finalPrice >= $priceMinFilter && $finalPrice <= $priceMaxFilter;
            });
        }
        $search = $request->input('search', '');
        $category = $request->input('category', '');
        $hasOffer = $request->input('has_offer', '');
        $priceMin = $request->input('price_min', '');
        $priceMax = $request->input('price_max', '');
        $sortBy = $request->input('sort_by', '');
        
        // Obtener todas las categorías para el filtro
        $categories = Category::all();
        
        return view('products.index', compact('products', 'search', 'category', 'hasOffer', 'priceMin', 'priceMax', 'categories', 'sortBy'));
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
