@extends('layouts.app')
@section('title', 'Quản lý đơn hàng')
@section('content')
<h1>Quản lý đơn hàng</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã đơn</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->user->name }}</td>
            <td>{{ number_format($order->total_amount) }} VNĐ</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Sửa</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $orders->links() }}
@endsection