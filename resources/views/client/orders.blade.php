@extends('layouts.app')
@section('title', 'Đơn hàng của tôi')
@section('content')
<h1>Đơn hàng của tôi</h1>
@if($orders->isEmpty())
    <div class="alert alert-info">Chưa có đơn hàng nào.</div>
@else
    <table class="table">
        <thead>
            <tr><th>Mã đơn</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th></tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>{{ number_format($order->total_amount) }} VNĐ</td>
                <td>{{ ucfirst($order->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection