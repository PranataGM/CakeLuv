<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Simple metrics
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('payment_status', 'pending')->count();
        $totalProducts = Product::count();

        // Getting daily revenue for chart
        $revenueData = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get()
            ->reverse();

        $chartLabels = $revenueData->pluck('date')->toJson();
        $chartData = $revenueData->pluck('total')->toJson();

        // Recent orders
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'pendingOrders', 'totalProducts',
            'chartLabels', 'chartData', 'recentOrders'
        ));
    }
}
