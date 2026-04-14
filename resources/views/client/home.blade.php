@extends('layouts.app')

@section('title', 'Trang chủ')

@push('styles')
<style>
    .home-banner {
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.14);
        background: #f8f9fa;
    }

    .home-banner .carousel-item {
        height: clamp(270px, 42vw, 430px);
        background: #11141c;
    }

    .home-banner .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
    }

    .home-banner .carousel-caption {
        background: rgba(9, 9, 9, 0.4);
        border-radius: 10px;
        padding: 0.75rem 1rem;
    }

    .home-interactive-btn {
        transition: transform 0.25s ease, box-shadow 0.25s ease, filter 0.25s ease;
    }

    .home-interactive-btn:hover,
    .home-interactive-btn:focus {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.18);
        filter: brightness(1.03);
    }

    .home-product-card {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
        transition: transform 0.28s ease, box-shadow 0.28s ease;
        box-shadow: 0 6px 18px rgba(16, 24, 40, 0.08);
    }

    .home-product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 32px rgba(16, 24, 40, 0.18);
    }

    .home-product-card .card-img-top {
        transition: transform 0.35s ease;
    }

    .home-product-card:hover .card-img-top {
        transform: scale(1.04);
    }

    @media (max-width: 768px) {
        .home-banner .carousel-item {
            height: 270px;
        }

        .home-banner .carousel-item img {
            height: 100%;
        }
    }
</style>
@endpush

@section('content')
@php
    $bannerImages = glob(public_path('images/banner/*.{jpg,jpeg,png,webp,avif}'), GLOB_BRACE);
@endphp

@if(!empty($bannerImages))
<div class="container mb-4">
    <div id="homeBannerCarousel" class="carousel slide carousel-fade home-banner" data-bs-ride="carousel" data-bs-interval="2800" data-bs-pause="hover">
        <div class="carousel-indicators">
            @foreach($bannerImages as $index => $imagePath)
                <button type="button" data-bs-target="#homeBannerCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach($bannerImages as $index => $imagePath)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}">
                        <img src="{{ asset('images/banner/' . basename($imagePath)) }}" alt="Banner {{ $index + 1 }}" loading="lazy">
                    </a>
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="mb-1">Bộ sưu tập nổi bật</h5>
                        <p class="mb-0">Khám phá thêm sản phẩm mới tại cửa hàng</p>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
@endif

<!-- Hero Banner -->
<div class="hero-banner text-center py-5 bg-light">
    <div class="container">
        <h1 class="display-4">Chào mừng đến AllainStore</h1>
        <p class="lead">Thời trang chất lượng, giá tốt</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg home-interactive-btn">Mua sắm ngay</a>
    </div>
</div>

<!-- Sản phẩm nổi bật -->
<div class="container my-5">
    <h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
    <div class="row">
        @foreach($featuredProducts as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100 home-product-card">
                <img src="{{ $product->image ? asset('images/products/'.$product->image) : 'https://via.placeholder.com/300' }}" 
                     class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: contain;">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-danger">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary home-interactive-btn">Xem chi tiết</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('products.index') }}" class="btn btn-secondary home-interactive-btn">Xem tất cả sản phẩm</a>
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