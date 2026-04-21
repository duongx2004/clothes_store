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
        $quantity = max(1, (int) $request->input('quantity', 1));

        if ($product->stock < 1) {
            return back()->with('error', 'Sản phẩm này đã hết hàng');
        }

        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $quantity;
            $cart[$id]['quantity'] = min($newQuantity, $product->stock);
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => min($quantity, $product->stock),
            ];
        }
        session()->put('cart', $cart);

        if ($request->has('buy_now')) {
            return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm, vui lòng kiểm tra giỏ hàng.');
        }
        return back()->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng');
        }

        $action = $request->input('action');
        $quantity = (int) ($cart[$id]['quantity'] ?? 0);

        if ($action === 'increase') {
            if ($quantity >= $product->stock) {
                return redirect()->route('cart.index')->with('error', 'Số lượng đã đạt mức tồn kho hiện có');
            }

            $cart[$id]['quantity'] = $quantity + 1;
        } elseif ($action === 'decrease') {
            if ($quantity <= 1) {
                return redirect()->route('cart.index')->with('error', 'Số lượng tối thiểu là 1');
            }

            $cart[$id]['quantity'] = $quantity - 1;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Đã cập nhật số lượng');
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

<<<<<<< HEAD
        // Kiểm tra tồn kho trước khi tạo đơn
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->route('cart.index')->with('error', "Sản phẩm không tồn tại.");
            }
            if ($product->stock < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', "Sản phẩm {$product->name} chỉ còn {$product->stock} sản phẩm.");
=======
        foreach ($cart as $id => $item) {
            $product = Product::find($id);

            if (!$product) {
                return redirect()->route('cart.index')->with('error', 'Có sản phẩm không còn tồn tại trong hệ thống');
            }

            if ($item['quantity'] > $product->stock) {
                return redirect()->route('cart.index')->with('error', 'Có sản phẩm vượt quá số lượng tồn kho hiện tại');
>>>>>>> 1e05f062b1a77963a838c2c5bc47506197b5379d
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