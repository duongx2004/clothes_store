<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalRevenue = Order::whereIn('status', ['completed', 'processing'])->sum('total_amount');

        $totalBrands = Brand::count();
        $totalCategories = Category::count();

        $pendingOrders = Order::where('status', 'pending')->count();
        $currentMonthRevenue = Order::whereIn('status', ['completed', 'processing'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        $monthlyRevenue = Order::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $chartLabels = $monthlyRevenue->pluck('month');
        $chartData = $monthlyRevenue->pluck('total');

        return view('admin.dashboard', compact(
            'totalProducts', 'totalOrders', 'totalUsers', 'totalRevenue',
            'currentMonthRevenue', 'pendingOrders', 'totalBrands', 'totalCategories',
            'recentOrders', 'chartLabels', 'chartData'
        ));
    }
}