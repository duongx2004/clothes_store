<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function edit($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Xử lý hoàn / trừ tồn kho khi hủy hoặc khôi phục đơn hàng
        if ($newStatus == 'cancelled' && $oldStatus != 'cancelled') {
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
        } elseif ($oldStatus == 'cancelled' && $newStatus != 'cancelled') {
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product && $product->stock >= $item->quantity) {
                    $product->decrement('stock', $item->quantity);
                } else {
                    return redirect()->back()->with('error', "Không thể khôi phục đơn hàng vì sản phẩm không đủ tồn kho.");
                }
            }
        }

        $order->status = $newStatus;
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        // Nếu đơn hàng chưa hoàn thành, hoàn lại tồn kho trước khi xóa
        if ($order->status != 'cancelled' && $order->status != 'completed') {
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
        }
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công.');
    }
}