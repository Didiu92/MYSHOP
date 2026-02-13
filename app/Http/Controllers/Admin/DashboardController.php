<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Offer;
use App\Models\User;
use App\Services\MetalsApiService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(MetalsApiService $metalsApi): View
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'offers' => Offer::count(),
            'users' => User::count(),
        ];

        $metalPrices = $metalsApi->latestPrices();

        return view('admin.dashboard', compact('stats', 'metalPrices'));
    }
}
