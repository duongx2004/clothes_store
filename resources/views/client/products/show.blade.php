@extends('layouts.app')
@section('title', $product->name)
@push('styles')
<style>
    .product-show-page {
        --text-main: #1a1a1a;
        --text-soft: #575757;
        --line: #e6e6e6;
        --panel: #f6f6f6;
        color: var(--text-main);
    }

    .product-shell {
        display: grid;
        grid-template-columns: 0.95fr 1.05fr;
        gap: 1.4rem;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        padding: 1.35rem;
        animation: riseIn 0.7s ease both;
    }

    .product-left {
        background: var(--panel);
        border: 1px solid #ececec;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 380px;
        padding: 1rem;
    }

    .product-left img {
        max-width: 100%;
        max-height: 360px;
        object-fit: contain;
        cursor: zoom-in;
        transition: transform 0.3s ease;
    }

    .product-left img:hover {
        transform: scale(1.02);
    }

    .product-right h1 {
        font-size: clamp(1.6rem, 2.4vw, 2.2rem);
        margin-bottom: 0.8rem;
    }

    .product-meta {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.6rem;
        margin-bottom: 0.8rem;
    }

    .product-meta div {
        border: 1px solid #ebebeb;
        background: #fafafa;
        border-radius: 10px;
        padding: 0.6rem 0.75rem;
        color: var(--text-soft);
        font-size: 0.92rem;
    }

    .product-price {
        font-size: 1.55rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .product-description {
        color: var(--text-soft);
        line-height: 1.75;
        margin-bottom: 1rem;
    }

    .quantity-box {
        max-width: 160px;
        margin-bottom: 0.95rem;
    }

    .quantity-box .form-control:focus {
        border-color: #b8947b;
        box-shadow: 0 0 0 4px rgba(232, 212, 192, 0.35);
    }

    .product-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
    }

    .product-actions button {
        border-radius: 10px;
        min-width: 180px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .product-actions button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 16px rgba(0, 0, 0, 0.14);
    }

    /* ===== SẢN PHẨM CÙNG LOẠI ===== */
    .product-related {
        margin-top: 3rem;
        padding-top: 1rem;
        border-top: 1px solid var(--line);
    }

    .section-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--text-main);
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }

    .product-link {
        text-decoration: none;
        color: inherit;
    }

    .product-card {
        background: #fff;
        border-radius: 1rem;
        overflow: hidden;
        border: 1px solid #eee;
        transition: all 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    }

    .product-image {
        aspect-ratio: 1 / 1;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .product-details {
        padding: 1rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-title {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .brand-category {
        display: flex;
        justify-content: space-between;
        font-size: 0.7rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .price-container {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: auto;
    }

    .original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 0.8rem;
    }

    .discount-price {
        color: #d9534f;
        font-weight: 700;
        font-size: 1rem;
    }

    .no-results {
        grid-column: 1 / -1;
        text-align: center;
        padding: 2rem;
        color: #6c757d;
        background: #fefefe;
        border-radius: 1rem;
        border: 1px dashed #ccc;
    }

    /* Giá và giảm giá cho sản phẩm chính */
    .price-wrapper {
        margin: 0.5rem 0;
    }
    .original-price-main {
        text-decoration: line-through;
        color: #999;
        font-size: 1.2rem;
        margin-right: 10px;
    }
    .sale-price-main {
        color: #d9534f;
        font-weight: bold;
        font-size: 1.8rem;
    }
    .discount-badge-main {
        background: #dc3545;
        color: white;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 0.9rem;
        font-weight: bold;
        margin-left: 10px;
        display: inline-block;
    }
    .price-only-main {
        color: #1a1a1a;
        font-weight: bold;
        font-size: 1.8rem;
    }

    @keyframes riseIn {
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
        .product-shell {
            grid-template-columns: 1fr;
        }
        .product-left {
            min-height: 300px;
        }
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
    }

    @media (max-width: 576px) {
        .product-meta {
            grid-template-columns: 1fr;
        }
        .product-actions button {
            width: 100%;
        }
        .product-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<section class="product-show-page">
    <div class="product-shell">
        <div class="product-left">
            <img src="{{ $product->image ? asset('images/products/'.$product->image) : 'https://via.placeholder.com/300' }}" 
                 onclick="openFullscreen(this)" alt="{{ $product->name }}">
        </div>
        <div class="product-right">
            <h2>{{ $product->name }}</h2>
            <p><strong>Thương hiệu:</strong> {{ $product->brand->name ?? 'Chưa xác định' }}</p>
            <p><strong>Danh mục:</strong> {{ $product->category->name ?? 'Chưa phân loại' }}</p>

            {{-- Hiển thị giá có giảm giá hoặc không --}}
            @php
                $hasSale = !is_null($product->sale_price) && $product->sale_price > 0;
                $hasDiscountPercent = !is_null($product->discount_percent) && $product->discount_percent > 0;
                $salePrice = null;
                $percent = 0;
                if ($hasSale) {
                    $salePrice = $product->sale_price;
                    $percent = round((1 - $salePrice / $product->price) * 100);
                } elseif ($hasDiscountPercent) {
                    $salePrice = $product->price * (1 - $product->discount_percent / 100);
                    $percent = $product->discount_percent;
                }
            @endphp

            @if($salePrice && $salePrice < $product->price)
                <div class="price-wrapper">
                    <span class="original-price-main">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                    <span class="sale-price-main">{{ number_format($salePrice, 0, ',', '.') }}₫</span>
                    <span class="discount-badge-main">-{{ $percent }}%</span>
                </div>
            @else
                <div class="price-wrapper">
                    <span class="price-only-main">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                </div>
            @endif

            <p><strong>Tồn kho:</strong> {{ $product->stock }}</p>
            <p>{{ $product->description }}</p>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success"><i class="bi bi-cart d-inline-block mx-1"></i> THÊM VÀO GIỎ HÀNG</button>
            </form>
            <a href="{{ route('cart.index') }}" class="btn btn-primary"> MUA NGAY</a>
        </div>
    </div>

    <div class="product-related">
        <h2 class="section-title">Sản phẩm cùng loại</h2>
        <div class="product-grid">
            @forelse($relatedProducts as $related)
                <a href="{{ route('products.show', $related->slug) }}" class="product-link">
                    <div class="product-card">
                        <div class="product-image">
                            @if($related->image)
                                <img src="{{ asset('images/products/'.$related->image) }}" alt="{{ $related->name }}">
                            @else
                                <img src="https://via.placeholder.com/300x300?text=No+Image" alt="No Image">
                            @endif
                        </div>
                        <div class="product-details">
                            <h3 class="product-title">{{ $related->name }}</h3>
                            <div class="brand-category">
                                <span class="brand">{{ $related->brand->name ?? 'Chưa có' }}</span>
                                <span class="category">{{ $related->category->name ?? 'Chưa có' }}</span>
                            </div>
                            <div class="price-container">
                                @php
                                    $relHasSale = !is_null($related->sale_price) && $related->sale_price > 0;
                                    $relHasDiscountPercent = !is_null($related->discount_percent) && $related->discount_percent > 0;
                                    $relSalePrice = null;
                                    if ($relHasSale) {
                                        $relSalePrice = $related->sale_price;
                                    } elseif ($relHasDiscountPercent) {
                                        $relSalePrice = $related->price * (1 - $related->discount_percent / 100);
                                    }
                                @endphp
                                @if($relSalePrice && $relSalePrice < $related->price)
                                    <span class="original-price">{{ number_format($related->price, 0, ',', '.') }}₫</span>
                                    <span class="discount-price">{{ number_format($relSalePrice, 0, ',', '.') }}₫</span>
                                @else
                                    <span class="discount-price">{{ number_format($related->price, 0, ',', '.') }}₫</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="no-results">Không tìm thấy sản phẩm nào cùng loại.</div>
            @endforelse
        </div>
    </div>
</section>

<script>
function openFullscreen(imgElement) {
    var fullscreenDiv = document.createElement('div');
    fullscreenDiv.style.position = 'fixed';
    fullscreenDiv.style.top = '0';
    fullscreenDiv.style.left = '0';
    fullscreenDiv.style.width = '100%';
    fullscreenDiv.style.height = '100%';
    fullscreenDiv.style.backgroundColor = 'rgba(0, 0, 0, 0.9)';
    fullscreenDiv.style.display = 'flex';
    fullscreenDiv.style.justifyContent = 'center';
    fullscreenDiv.style.alignItems = 'center';
    fullscreenDiv.style.zIndex = '1000';
    fullscreenDiv.onclick = function() {
        document.body.removeChild(fullscreenDiv);
    };
    var fullscreenImg = document.createElement('img');
    fullscreenImg.src = imgElement.src;
    fullscreenImg.style.maxWidth = '90%';
    fullscreenImg.style.maxHeight = '90%';
    fullscreenDiv.appendChild(fullscreenImg);
    document.body.appendChild(fullscreenDiv);
}
</script>
@endsection