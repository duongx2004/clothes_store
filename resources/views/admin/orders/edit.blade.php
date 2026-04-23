@extends('admin.layouts.app')
@section('title', 'Chi tiết đơn hàng #' . $order->order_number)
@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Thông tin đơn hàng -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Thông tin đơn hàng</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <strong>Mã đơn:</strong> {{ $order->order_number }}<br>
                        <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br>
                        <strong>Khách hàng:</strong> {{ $order->user->name }} ({{ $order->user->email }})
                    </div>
                    <div class="col-sm-6">
                        <strong>Phương thức:</strong> 
                        @if($order->payment_method == 'cod') COD
                        @elseif($order->payment_method == 'vnpay') VNPay
                        @else {{ ucfirst($order->payment_method) }}
                        @endif
                        <br>
                        <strong>Trạng thái:</strong>
                        <span class="badge 
                            @if($order->status == 'pending') bg-warning
                            @elseif($order->status == 'processing') bg-info
                            @elseif($order->status == 'completed') bg-success
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <strong>Địa chỉ giao hàng:</strong><br>
                        {{ $order->shipping_address ?? 'Chưa cập nhật' }}
                    </div>
                </div>
                @if($order->transaction_id)
                <div class="row mt-2">
                    <div class="col-12">
                        <strong>Mã giao dịch VNPay:</strong> {{ $order->transaction_id }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Sản phẩm đã đặt</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr><th>Sản phẩm</th><th class="text-center">SL</th><th class="text-end">Đơn giá</th><th class="text-end">Thành tiền</th></tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($order->items as $item)
                        @php $lineTotal = $item->price * $item->quantity; $total += $lineTotal; @endphp
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">{{ number_format($item->price, 0, ',', '.') }}₫</td>
                            <td class="text-end">{{ number_format($lineTotal, 0, ',', '.') }}₫</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr><th colspan="3" class="text-end">Tổng cộng</th>
                        <th class="text-end">{{ number_format($total, 0, ',', '.') }}₫</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Form cập nhật trạng thái -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Cập nhật trạng thái</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Chọn trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (Chờ xử lý)</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing (Đang xử lý)</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Hoàn thành)</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Hủy)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                </form>
            </div>
        </div>

        <!-- Hành động nhanh -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Hành động</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary w-100 mb-2">
                    <i class="bi bi-arrow-left"></i> Quay lại danh sách
                </a>
                @if($order->status != 'cancelled')
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" onsubmit="return confirm('Hủy đơn hàng này sẽ hoàn lại tồn kho. Bạn có chắc?')">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-x-circle"></i> Hủy đơn hàng
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection