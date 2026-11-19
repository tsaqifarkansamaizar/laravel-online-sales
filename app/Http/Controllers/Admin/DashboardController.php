<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('grand_total');
        $recentOrders = Order::with('user')->latest('ordered_at')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'pendingOrders',
            'totalOrders',
            'totalRevenue',
            'recentOrders'
        ));
    }
}