<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Services\VNPayService;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cod,vnpay',
            'address' => 'required'
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng trống');
        }

        // Tạo order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => uniqid('DH'),
            'total_amount' => collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']),
            'shipping_address' => $request->address,
            'status' => 'pending',
            'payment_method' => $request->payment_method
        ]);

        // Lưu item + trừ kho
        DB::transaction(function () use ($cart, $order) {
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                $product = Product::find($id);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }
        });

        // COD
        if ($request->payment_method == 'cod') {
            session()->forget('cart');
            return redirect()->route('thanks')->with('success', 'Đặt hàng thành công!');
        }

        // VNPay
        if ($request->payment_method == 'vnpay') {
            $vnpay = new VNPayService();
            $url = $vnpay->createPayment($order);
            return redirect($url);
        }

        return back()->with('error', 'Lỗi thanh toán');
    }

    public function vnpayReturn(Request $request)
    {
        $vnpay = new VNPayService();
        $result = $vnpay->handleReturn($request);

        $order = Order::where('order_number', $request->vnp_TxnRef)->first();

        if ($order && $result['success']) {
            $order->update([
                'status' => 'completed',
                'transaction_id' => $result['transaction_id'] ?? null
            ]);

            session()->forget('cart');

            return redirect()->route('thanks')->with('success', 'Thanh toán thành công!');
        }

        if ($order) {
            // hoàn kho
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }

            $order->update(['status' => 'cancelled']);
        }

        return redirect()->route('cart.index')->with('error', 'Thanh toán thất bại');
    }
}