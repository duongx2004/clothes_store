@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<!-- Hero Banner -->
<div class="hero-banner text-center py-5 bg-light">
    <div class="container">
        <h1 class="display-4">Chào mừng đến AllainStore</h1>
        <p class="lead">Thời trang chất lượng, giá tốt</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Mua sắm ngay</a>
    </div>
</div>

<!-- Sản phẩm nổi bật -->
<div class="container my-5">
    <h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
    <div class="row">
        @foreach($featuredProducts as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="{{ $product->image ? asset('images/products/'.$product->image) : 'https://via.placeholder.com/300' }}" 
                     class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: contain;">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-danger">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Xem tất cả sản phẩm</a>
    </div>
</div>

<!-- Giới thiệu / Điểm nổi bật -->
<div class="bg-light py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <i class="bi bi-truck fs-1"></i>
                <h5>Giao hàng nhanh</h5>
                <p>Miễn phí vận chuyển cho đơn hàng từ 500k</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-arrow-repeat fs-1"></i>
                <h5>Đổi trả dễ dàng</h5>
                <p>Đổi trả trong vòng 30 ngày</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-shield-lock fs-1"></i>
                <h5>Thanh toán an toàn</h5>
                <p>Bảo mật thông tin tuyệt đối</p>
            </div>
        </div>
    </div>
</div>
@endsection