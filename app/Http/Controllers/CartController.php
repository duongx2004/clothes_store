<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\VNPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('client.cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }
        session()->put('cart', $cart);

        if ($request->has('buy_now')) {
            return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm, vui lòng kiểm tra giỏ hàng.');
        }
        return back()->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->route('cart.index');
    }

    public function checkout(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        // Kiểm tra tồn kho trước khi tạo đơn
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->route('cart.index')->with('error', "Sản phẩm không tồn tại.");
            }
            if ($product->stock < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', "Sản phẩm {$product->name} chỉ còn {$product->stock} sản phẩm.");
            }
        }

        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'shipping_address' => $request->address ?? 'Chưa cập nhật',
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // Tạo order items và trừ stock (dùng transaction)
        DB::transaction(function () use ($cart, $order) {
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $product = Product::find($id);
                $product->decrement('stock', $item['quantity']);
            }
        });

        // Xóa giỏ hàng
        session()->forget('cart');

        // Xử lý theo phương thức thanh toán
        if ($request->payment_method === 'vnpay') {
            $vnpay = new VNPayService();
            $paymentUrl = $vnpay->createPayment($order);
            if ($paymentUrl) {
                return redirect()->away($paymentUrl);
            } else {
                // Nếu lỗi, xóa đơn hàng và hoàn stock
                DB::transaction(function () use ($order) {
                    foreach ($order->items as $item) {
                        $product = Product::find($item->product_id);
                        $product->increment('stock', $item->quantity);
                    }
                    $order->delete();
                });
                return redirect()->route('cart.index')->with('error', 'Có lỗi xảy ra khi kết nối VNPay, vui lòng thử lại.');
            }
        }

        // COD
        return redirect()->route('thanks')->with('success', 'Đặt hàng thành công!');
    }
}