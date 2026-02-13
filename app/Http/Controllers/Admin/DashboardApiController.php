<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardApiController extends Controller
{
    public function overview(): JsonResponse
    {
        $summary = [
            'products_total' => Product::count(),
            'categories_total' => Category::count(),
            'offers_total' => Offer::count(),
            'users_total' => User::count(),
            'favorites_total' => DB::table('product_user')->count(),
        ];

        $topFavorites = Product::query()
            ->withCount('users')
            ->orderByDesc('users_count')
            ->limit(5)
            ->get(['id', 'name'])
            ->map(fn (Product $product) => [
                'id' => $product->id,
                'name' => $product->name,
                'favorites' => $product->users_count,
            ]);

        $topViewed = Product::query()
            ->orderByDesc('views')
            ->limit(5)
            ->get(['id', 'name', 'views'])
            ->map(fn (Product $product) => [
                'id' => $product->id,
                'name' => $product->name,
                'views' => $product->views,
            ]);

        return response()->json([
            'summary' => $summary,
            'top_favorites' => $topFavorites,
            'top_viewed' => $topViewed,
            'generated_at' => now()->toIso8601String(),
        ]);
    }
}
