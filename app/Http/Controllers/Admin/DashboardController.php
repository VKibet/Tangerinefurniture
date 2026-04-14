<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
            'low_stock_products' => Product::where('stock_quantity', '<', 10)->count(),
            'featured_products' => Product::where('is_featured', true)->count(),
        ];

        $recent_products = Product::latest()->take(5)->get();
        $recent_users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_products', 'recent_users'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        // TODO: Implement settings update
        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }
} 