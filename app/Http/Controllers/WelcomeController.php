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
        // Featured products: prefer products with active offers, target up to 9 items
        $featuredProducts = Product::with(['category', 'offer', 'images'])
            ->whereNotNull('offer_id')
            ->latest()
            ->take(9)
            ->get();

        // If not enough with offers, backfill with latest products to ensure carousel has multiple slides
        if ($featuredProducts->count() < 6) { // ensure at least 2 slides (3 per slide)
            $needed = 6 - $featuredProducts->count();
            $fallback = Product::with(['category', 'offer', 'images'])
                ->whereNotIn('id', $featuredProducts->pluck('id'))
                ->latest()
                ->take($needed)
                ->get();
            $featuredProducts = $featuredProducts->merge($fallback);
        }

        // Get featured categories (first 4 categories for the categories section)
        $featuredCategories = Category::take(4)->get();

        return view('welcome', compact('featuredProducts', 'featuredCategories'));
    }
}
