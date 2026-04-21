<?php

namespace App\Http\Controllers;

use App\Services\VNPayService;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function vnpayReturn(Request $request)
    {
        $vnpay = new VNPayService();
        $result = $vnpay->handleReturn($request);
        $order = Order::where('order_number', $request->vnp_TxnRef)->first();

        if ($order && $result['success']) {
            // Kiểm tra nếu stock chưa được trừ (trường hợp thanh toán thành công nhưng trước đó chưa trừ)
            // Thực tế trong CartController đã trừ, nhưng để chắc chắn:
            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    // Chỉ trừ nếu stock hiện tại >= số lượng (đề phòng trừ 2 lần)
                    if ($product && $product->stock >= $item->quantity) {
                        $product->decrement('stock', $item->quantity);
                    }
                }
            });

            $order->status = 'processing';
            $order->transaction_id = $result['transaction_id'] ?? null;
            $order->save();

            return redirect()->route('thanks')->with('success', $result['message']);
        } elseif ($order) {
            // Thanh toán thất bại: hoàn lại stock (nếu đã bị trừ ở CartController)
            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            });
            $order->status = 'cancelled';
            $order->save();
            return redirect()->route('cart.index')->with('error', $result['message']);
        }
        return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng');
    }
}