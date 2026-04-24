<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Services\VNPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    /**
     * Get cart from database (for logged-in users) or session (for guests)
     */
    private function getCart()
    {
        if (auth()->check()) {
            $dbCart = CartItem::where('user_id', auth()->id())
                ->with('product')
                ->get();
            $cart = [];
            foreach ($dbCart as $item) {
                $cart[$item->product_id] = [
                    'name' => $item->product->name,
                    'price' => $item->price,
                    'image' => $item->product->image,
                    'quantity' => $item->quantity,
                ];
            }
            return $cart;
        }
        return session()->get('cart', []);
    }

    /**
     * Save cart to database for logged-in users
     */
    private function saveCartToDb($cart)
    {
        if (auth()->check()) {
            CartItem::where('user_id', auth()->id())->delete();
            foreach ($cart as $productId => $item) {
                CartItem::create([
                    'user_id' => auth()->id(),
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        }
    }

    public function index()
    {
        $cart = $this->getCart();
        $userAddress = null;

        // Nếu người dùng đã đăng nhập và giỏ hàng có sản phẩm, lấy địa chỉ & thành phố từ user
        if (auth()->check() && !empty($cart)) {
            $user = auth()->user();
            $userAddress = $user->address;
        }

        return view('client.cart.index', compact('cart', 'userAddress'));
    }

    public function add(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
        }

        $product = Product::findOrFail($id);
        $cart = $this->getCart();
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
        
        // Save to session for guests and DB for logged-in users
        session()->put('cart', $cart);
        $this->saveCartToDb($cart);

        if ($request->has('buy_now')) {
            return redirect()->route('checkout.show');
        }
        return back()->with('success', 'Đã thêm vào giỏ hàng');
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ (tăng/giảm)
     * - Tối thiểu = 1
     * - Tối đa = tồn kho hiện tại của sản phẩm
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = $this->getCart();

        if (!isset($cart[$id])) {
            return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng');
        }

        $currentQty = $cart[$id]['quantity'];
        $action = $request->input('action');
        $newQty = $currentQty;

        if ($action === 'increase') {
            $newQty = $currentQty + 1;
            if ($newQty > $product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', "Số lượng không thể vượt quá tồn kho (tối đa {$product->stock})");
            }
        } elseif ($action === 'decrease') {
            $newQty = $currentQty - 1;
            if ($newQty < 1) {
                return redirect()->route('cart.index')
                    ->with('error', 'Số lượng tối thiểu là 1');
            }
        } else {
            // Trường hợp nhập trực tiếp số lượng (nếu có input name="quantity")
            $inputQty = (int) $request->input('quantity', $currentQty);
            $newQty = max(1, min($inputQty, $product->stock));
            if ($newQty == $currentQty) {
                return redirect()->route('cart.index')->with('info', 'Số lượng không thay đổi');
            }
        }

        $cart[$id]['quantity'] = $newQty;
        session()->put('cart', $cart);
        $this->saveCartToDb($cart);

        return redirect()->route('cart.index')->with('success', 'Đã cập nhật số lượng');
    }

    public function remove($id)
    {
        $cart = $this->getCart();
        unset($cart[$id]);
        session()->put('cart', $cart);
        $this->saveCartToDb($cart);
        return redirect()->route('cart.index');
    }

    public function showCheckout()
    {
        $cart = $this->getCart();
        $userAddress = auth()->user()?->address;

        return view('client.cart.index', compact('cart', 'userAddress'));
    }

    public function checkout(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán');
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'in:cod,vnpay'],
            'address' => ['required', 'string', 'max:500'],
        ]);

        $cart = $this->getCart();
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        // Kiểm tra tồn kho lần cuối
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->route('cart.index')->with('error', "Sản phẩm không tồn tại.");
            }
            if ($product->stock < $item['quantity']) {
                return redirect()->route('cart.index')
                    ->with('error', "Sản phẩm {$product->name} chỉ còn {$product->stock} sản phẩm.");
            }
        }

        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $shippingAddress = trim($validated['address']);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'shipping_address' => $shippingAddress,
            'status' => 'pending',
            'payment_method' => $validated['payment_method'],
        ]);

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

        session()->forget('cart');
        CartItem::where('user_id', auth()->id())->delete();

        if ($validated['payment_method'] === 'vnpay') {
            $vnpay = new VNPayService();
            $paymentUrl = $vnpay->createPayment($order);
            if ($paymentUrl) {
                return redirect()->away($paymentUrl);
            } else {
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

        return redirect()->route('thanks')->with('success', 'Đặt hàng thành công!');
    }
}