<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        // Lấy năm được chọn (mặc định năm hiện tại)
        $year = $request->get('year', date('Y'));
        $years = Order::select(DB::raw('YEAR(created_at) as year'))
                      ->distinct()
                      ->orderBy('year', 'desc')
                      ->pluck('year');

        // Lấy doanh thu theo tháng trong năm (chỉ đơn hàng completed hoặc processing? tùy)
        $revenues = Order::select(
                            DB::raw('MONTH(created_at) as month'),
                            DB::raw('SUM(total_amount) as total')
                        )
                        ->whereYear('created_at', $year)
                        ->whereIn('status', ['completed', 'processing']) // chỉ tính đơn thành công
                        ->groupBy('month')
                        ->orderBy('month')
                        ->get();

        // Tạo mảng dữ liệu cho 12 tháng
        $monthlyData = array_fill(1, 12, 0);
        foreach ($revenues as $revenue) {
            $monthlyData[$revenue->month] = $revenue->total;
        }

        // Chuẩn bị dữ liệu cho biểu đồ
        $labels = [];
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = "Tháng $i";
            $data[] = $monthlyData[$i];
        }

        // Tổng doanh thu năm
        $totalRevenue = array_sum($data);

        return view('admin.revenue.index', compact('labels', 'data', 'years', 'year', 'totalRevenue'));
    }
}