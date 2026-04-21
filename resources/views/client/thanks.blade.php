@extends('layouts.app')

@section('title', 'Cảm ơn')

@section('content')
<div class="container text-center py-5">
    <div class="mb-4">
        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
    </div>
    <h1 class="mb-3">Cảm ơn bạn đã đặt hàng!</h1>
    <p class="lead">Đơn hàng của bạn đã được ghi nhận. Chúng tôi sẽ liên hệ để xác nhận trong thời gian sớm nhất.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
    <a href="{{ route('client.orders') }}" class="btn btn-outline-secondary mt-3">Xem đơn hàng của tôi</a>
</div>
@endsection