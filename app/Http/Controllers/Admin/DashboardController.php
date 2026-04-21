<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Tổng số sản phẩm
        $totalProducts = Product::count();

        // Tổng số đơn hàng
        $totalOrders = Order::count();

        // Tổng số người dùng (khách hàng + admin)
        $totalUsers = User::count();

        // Doanh thu (chỉ các đơn hàng hoàn thành hoặc đang xử lý)
        $totalRevenue = Order::whereIn('status', ['completed', 'processing'])->sum('total_amount');

        // Đơn hàng gần đây nhất (5 đơn)
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Doanh thu theo tháng (6 tháng gần nhất) cho biểu đồ
        $monthlyRevenue = Order::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereIn('status', ['completed', 'processing'])
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $chartLabels = $monthlyRevenue->pluck('month');
        $chartData = $monthlyRevenue->pluck('total');

        return view('admin.dashboard', compact(
            'totalProducts', 'totalOrders', 'totalUsers', 'totalRevenue',
            'recentOrders', 'chartLabels', 'chartData'
        ));
    }
}