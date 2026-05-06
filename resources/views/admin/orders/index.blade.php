@extends('admin.layouts.app')
@section('title', 'Quản lý đơn hàng')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Đơn hàng</h1>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Mã đơn</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Yêu cầu hoàn tiền</th>
            <th>Ngày đặt</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->user->name }}<br><small>{{ $order->user->email }}</small></td>
            <td>{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
            <td>
                <span class="badge 
                    @if($order->status == 'pending') bg-warning
                    @elseif($order->status == 'processing') bg-info
                    @elseif($order->status == 'completed') bg-success
                    @elseif($order->status == 'refunded') bg-secondary
                    @else bg-dark @endif">
                    {{ $order->status == 'refunded' ? 'Hoàn tiền' : ucfirst($order->status) }}
                </span>
            </td>
            <td>
                @if($order->refund_requested && $order->status == 'completed')
                    <span class="badge bg-warning">Đang yêu cầu</span>
                @else
                    —
                @endif
            </td>
            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa đơn hàng này?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $orders->links() }}
@endsection