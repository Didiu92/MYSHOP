<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    /**
     * Show the welcome page with featured content
     */
    public function index(): View
    {
        // Get featured products (first 3 products with offers for the featured section)
        $featuredProducts = Product::with(['category', 'offer', 'images'])
            ->whereNotNull('offer_id')
            ->take(3)
            ->get();

        // Get featured categories (first 4 categories for the categories section)
        $featuredCategories = Category::take(4)->get();

        return view('welcome', compact('featuredProducts', 'featuredCategories'));
    }
}
