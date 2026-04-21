@extends('layouts.app')

@section('title', 'Trang chủ')

@push('styles')
<style>
    .home-page {
        --text-main: #1a1a1a;
        --text-soft: #565656;
        --line: #e6e6e6;
        --panel: #f6f6f6;
        --accent: #e8d4c0;
        color: var(--text-main);
    }

    .home-panel {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04);
        padding: 1.4rem;
        margin-bottom: 1.3rem;
        animation: fadeRise 0.65s ease both;
    }

    .home-banner {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #ececec;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.07);
    }

    .home-banner .carousel-item {
        height: clamp(250px, 36vw, 390px);
        background: #f3f3f3;
    }

    .home-banner .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .home-banner .carousel-caption {
        background: rgba(0, 0, 0, 0.38);
        border-radius: 12px;
        padding: 0.65rem 0.95rem;
    }

    .home-hero {
        background: radial-gradient(circle at 80% 20%, #efe1d5 0%, #f8f8f8 34%, #fff 100%);
        text-align: center;
    }

    .home-hero h1 {
        font-size: clamp(1.8rem, 2.6vw, 3rem);
        margin-bottom: 0.55rem;
    }

    .home-hero p {
        color: var(--text-soft);
        margin-bottom: 1rem;
    }

    .home-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border-radius: 999px;
        text-decoration: none;
        padding: 0.62rem 1.18rem;
        font-weight: 500;
        transition: transform 0.22s ease, box-shadow 0.22s ease;
    }

    .home-btn-primary {
        background: #1a1a1a;
        color: #fff;
    }

    .home-btn-secondary {
        border: 1px solid #d7d7d7;
        color: #2b2b2b;
        background: #fff;
    }

    .home-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.12);
        color: inherit;
    }

    .home-section-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        gap: 1rem;
    }

    .home-section-head h2 {
        margin-bottom: 0;
        font-size: 1.45rem;
    }

    .home-products {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
    }

    .home-product-card {
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .home-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 25px rgba(0, 0, 0, 0.1);
    }

    .home-product-image {
        height: 200px;
        background: #f7f7f7;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.8rem;
    }

    .home-product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .home-product-body {
        padding: 0.95rem;
    }

    .home-product-title {
        font-size: 1rem;
        margin-bottom: 0.4rem;
        font-weight: 600;
    }

    .home-product-price {
        margin-bottom: 0.8rem;
        color: #1a1a1a;
        font-weight: 700;
    }

    .home-features {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
    }

    .home-feature-card {
        border: 1px solid #e8e8e8;
        border-radius: 14px;
        background: var(--panel);
        padding: 1rem;
        text-align: center;
        transition: transform 0.22s ease, box-shadow 0.22s ease;
    }

    .home-feature-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 22px rgba(0, 0, 0, 0.08);
    }

    .home-feature-card i {
        display: inline-grid;
        place-items: center;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #fff;
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
    }

    .home-feature-card p {
        color: var(--text-soft);
        margin-bottom: 0;
    }

    @keyframes fadeRise {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 991px) {
        .home-products {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .home-features {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .home-products {
            grid-template-columns: 1fr;
        }

        .home-section-head {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@section('content')
@php
    $bannerImages = glob(public_path('images/banner/*.{jpg,jpeg,png,webp,avif}'), GLOB_BRACE);
@endphp
<section class="home-page">
    @if(!empty($bannerImages))
    <section class="home-panel">
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
                            <p class="mb-0">Khám phá thêm sản phẩm mới tại AllainStore</p>
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
    </section>
    @endif

    <section class="home-panel home-hero">
        <h1>Thời trang tối giản, thần thái nổi bật</h1>
        <p>Khám phá các thiết kế mới với chất liệu được chọn lọc và phong cách hiện đại cho mọi ngày.</p>
        <div class="d-flex justify-content-center gap-2 flex-wrap">
            <a href="{{ route('products.index') }}" class="home-btn home-btn-primary"><i class="bi bi-bag"></i>Mua sắm ngay</a>
            <a href="{{ route('about') }}" class="home-btn home-btn-secondary">Câu chuyện thương hiệu</a>
        </div>
    </section>

    <section class="home-panel">
        <div class="home-section-head">
            <h2>Sản phẩm nổi bật</h2>
            <a href="{{ route('products.index') }}" class="home-btn home-btn-secondary">Xem tất cả</a>
        </div>

        <div class="home-products">
            @foreach($featuredProducts as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="home-product-card" aria-label="Xem chi tiết {{ $product->name }}">
                <div class="home-product-image">
                    <img src="{{ $product->image ? asset('images/products/'.$product->image) : 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}" loading="lazy">
                </div>
                <div class="home-product-body">
                    <h3 class="home-product-title">{{ $product->name }}</h3>
                    <p class="home-product-price">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                    <span class="home-btn home-btn-secondary">Xem chi tiết</span>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    <section class="home-panel">
        <div class="home-features">
            <article class="home-feature-card">
                <i class="bi bi-truck"></i>
                <h5>Giao hàng nhanh</h5>
                <p>Miễn phí vận chuyển cho đơn hàng từ 500.000đ.</p>
            </article>
            <article class="home-feature-card">
                <i class="bi bi-arrow-repeat"></i>
                <h5>Đổi trả dễ dàng</h5>
                <p>Hỗ trợ đổi trả trong 30 ngày với quy trình đơn giản.</p>
            </article>
            <article class="home-feature-card">
                <i class="bi bi-shield-lock"></i>
                <h5>Thanh toán an toàn</h5>
                <p>Bảo mật thông tin và giao dịch ở mức cao nhất.</p>
            </article>
        </div>
    </section>
</section>
@endsection