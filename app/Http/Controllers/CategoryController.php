<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Show all categories
     */
    public function index(): View
    {
        $categories = Category::all();
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show products from a specific category
     */
    public function show(string $id): View
    {
        // Validate ID format
        if (!is_numeric($id) || $id < 1) {
            abort(404, 'ID de categoría inválido');
        }

        $category = Category::find($id);

        if (!$category) {
            abort(404, 'Categoría no encontrada');
        }

        $categoryProducts = $category->products()->with(['offer'])->get();

        return view('categories.show', compact('category', 'categoryProducts'));
    }
}
