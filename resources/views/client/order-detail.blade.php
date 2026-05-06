@extends('layouts.app')
@section('title', 'Chi tiết đơn hàng #' . $order->order_number)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">Đơn hàng #{{ $order->order_number }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Trạng thái:</strong>
                            <span class="badge 
                                @if($order->status == 'pending') bg-warning
                                @elseif($order->status == 'processing') bg-info
                                @elseif($order->status == 'completed') bg-success
                                @elseif($order->status == 'refunded') bg-secondary
                                @else bg-secondary @endif">
                                {{ $order->status == 'refunded' ? 'Hoàn tiền' : ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Phương thức thanh toán:</strong>
                            @if($order->payment_method == 'cod') COD (Thanh toán khi nhận hàng)
                            @elseif($order->payment_method == 'vnpay') VNPay
                            @else {{ ucfirst($order->payment_method) }}
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($order->transaction_id)
                                <strong>Mã giao dịch:</strong> {{ $order->transaction_id }}
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Địa chỉ giao hàng:</strong><br>
                        {{ $order->shipping_address ?: 'Chưa cập nhật' }}
                    </div>
                    <hr>
                    <h5>Chi tiết sản phẩm</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr><th>Sản phẩm</th><th class="text-center">Số lượng</th><th class="text-end">Đơn giá</th><th class="text-end">Thành tiền</th></tr>
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
                <div class="card-footer text-center">
                    <a href="{{ route('client.orders') }}" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
                    @if($order->status == 'pending')
                    <form action="{{ route('client.order.cancel', $order->id) }}" method="POST" class="mt-3" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
                    </form>
                    @endif
                    @if($order->status == 'completed' && !$order->refund_requested)
                    <form action="{{ route('client.refund.request', $order->id) }}" method="POST" class="mt-3" onsubmit="return confirm('Bạn có chắc muốn yêu cầu hoàn tiền cho đơn hàng này?')">
                        @csrf
                        <button type="submit" class="btn btn-warning">Yêu cầu hoàn tiền</button>
                    </form>
                    @elseif($order->refund_requested)
                    <div class="alert alert-info mt-3">Yêu cầu hoàn tiền đã được gửi, đang chờ xử lý.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection