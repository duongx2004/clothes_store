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

        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled,refunded'
        ]);

        // Hoàn stock khi hủy (pending -> cancelled)
        if ($newStatus == 'cancelled' && $oldStatus != 'cancelled') {
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        }
        // Hoàn stock và hoàn tiền (completed -> refunded)
        elseif ($newStatus == 'refunded' && $oldStatus == 'completed') {
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
            // (Tùy chọn) ghi nhận thời gian hoàn tiền
            // $order->refunded_at = now();
        }
        // Khôi phục đơn từ cancelled -> khác (trừ stock lại)
        elseif ($oldStatus == 'cancelled' && $newStatus != 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product->stock >= $item->quantity) {
                    $item->product->decrement('stock', $item->quantity);
                } else {
                    return back()->with('error', 'Không thể khôi phục do không đủ tồn kho.');
                }
            }
        }

        $order->status = $newStatus;
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái thành công.');
    }

    public function approveRefund($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status != 'completed' || !$order->refund_requested) {
            return back()->with('error', 'Không thể hoàn tiền cho đơn hàng này.');
        }
        // Hoàn lại tồn kho
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }
        $order->status = 'refunded';
        $order->refund_requested = false;
        // Nếu có cột refunded_at, có thể set ở đây
        $order->save();
        return redirect()->route('admin.orders.index')->with('success', 'Đã hoàn tiền và cập nhật tồn kho.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status != 'cancelled' && $order->status != 'completed') {
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        }
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công.');
    }
}