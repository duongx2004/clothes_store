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
        $year = $request->get('year', date('Y'));
        $years = Order::select(DB::raw('YEAR(created_at) as year'))
                      ->distinct()
                      ->orderBy('year', 'desc')
                      ->pluck('year');

        $revenues = Order::select(
                            DB::raw('MONTH(created_at) as month'),
                            DB::raw('SUM(total_amount) as total')
                        )
                        ->whereYear('created_at', $year)
                        ->where('status', 'completed')
                        ->groupBy('month')
                        ->orderBy('month')
                        ->get();

        $monthlyData = array_fill(1, 12, 0);
        foreach ($revenues as $revenue) {
            $monthlyData[$revenue->month] = $revenue->total;
        }

        $labels = [];
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = "Tháng $i";
            $data[] = $monthlyData[$i];
        }

        $totalRevenue = array_sum($data);

        return view('admin.revenue.index', compact('labels', 'data', 'years', 'year', 'totalRevenue'));
    }
}