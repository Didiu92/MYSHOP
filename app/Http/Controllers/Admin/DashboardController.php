<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Offer;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'offers' => Offer::count(),
            'users' => User::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
