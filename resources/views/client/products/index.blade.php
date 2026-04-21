@extends('layouts.app')
@section('title', 'Sản phẩm')

@push('styles')
<style>
    .products-page {
        --text-main: #1a1a1a;
        --text-soft: #565656;
        --line: #e6e6e6;
        --panel: #f6f6f6;
        color: var(--text-main);
    }

    .page-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .page-heading h1 {
        margin-bottom: 0;
        font-size: clamp(1.6rem, 2.4vw, 2.2rem);
    }

    .filter-shell {
        position: relative;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 18px;
        padding: 18px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04);
        margin-bottom: 22px;
        animation: fadeRise 0.65s ease both;
    }

    .filter-shell::before {
        content: '';
        position: absolute;
        inset: 0 auto auto 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #1a1a1a 0%, #c6a995 100%);
    }

    .filter-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 16px;
    }

    .filter-title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .filter-description {
        margin: 4px 0 0;
        color: var(--text-soft);
        font-size: 0.92rem;
    }

    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border-radius: 999px;
        background: #f4ece5;
        color: #5a4538;
        font-weight: 600;
        font-size: 0.82rem;
        white-space: nowrap;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 1.1fr 1fr auto;
        gap: 14px;
        align-items: end;
    }

    .filter-field {
        background: #fafafa;
        border: 1px solid #ebebeb;
        border-radius: 14px;
        padding: 12px;
    }

    .filter-shell .form-label {
        margin-bottom: 8px;
        font-size: 0.88rem;
        font-weight: 600;
        color: #3e3e3e;
    }

    .filter-shell .form-select {
        min-height: 44px;
        border-radius: 10px;
        border-color: #d9d9d9;
        box-shadow: none;
        padding-left: 12px;
    }

    .filter-shell .form-select:focus {
        border-color: #b8947b;
        box-shadow: 0 0 0 4px rgba(232, 212, 192, 0.35);
    }

    .filter-shell .btn {
        min-height: 44px;
        border-radius: 10px;
        padding-left: 16px;
        padding-right: 16px;
    }

    .filter-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        align-items: center;
        height: 100%;
    }

    .filter-actions .btn-primary {
        background: #1a1a1a;
        border-color: #1a1a1a;
        box-shadow: 0 10px 18px rgba(0, 0, 0, 0.18);
    }

    .filter-actions .btn-primary:hover {
        background: #000;
        border-color: #000;
    }

    .filter-actions .btn-outline-secondary {
        background: #fff;
        border-color: #cfcfcf;
        color: #3f3f3f;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
    }

    .product-link {
        text-decoration: none;
        color: inherit;
    }

    .product-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #ececec;
        box-shadow: 0 8px 18px rgba(0,0,0,0.05);
        transition: transform 0.23s ease, box-shadow 0.23s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 24px rgba(0,0,0,0.11);
    }

    .product-image {
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f7f7f7;
        padding: 10px;
    }

    .product-image img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    .product-details {
        padding: 15px;
        flex-grow: 1;
    }

    .product-title {
        font-size: 1.1rem;
        margin-bottom: 8px;
        font-weight: bold;
    }

    .brand,
    .category {
        font-size: 0.85rem;
        color: var(--text-soft);
        margin-bottom: 4px;
    }

    /* === Giá và giảm giá === */
    .price-wrapper {
        margin-top: 8px;
    }
    .original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 0.9rem;
        margin-right: 8px;
    }
    .sale-price {
        color: #d9534f;
        font-weight: bold;
        font-size: 1.1rem;
    }
    .discount-badge {
        background: #dc3545;
        color: white;
        border-radius: 20px;
        padding: 2px 6px;
        font-size: 0.7rem;
        font-weight: bold;
        margin-left: 8px;
        display: inline-block;
    }
    .price-only {
        color: #1a1a1a;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .no-results {
        text-align: center;
        width: 100%;
        padding: 50px 20px;
        color: var(--text-soft);
        border: 1px dashed #d4d4d4;
        border-radius: 14px;
        background: #fff;
    }

    @keyframes fadeRise {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 991px) {
        .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .filter-grid {
            grid-template-columns: 1fr 1fr;
        }

        .filter-actions {
            grid-column: 1 / -1;
            justify-content: stretch;
        }

        .filter-actions .btn {
            flex: 1;
        }
    }

    @media (max-width: 480px) {
        .page-heading {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter-shell {
            padding: 14px;
        }

        .filter-header {
            flex-direction: column;
        }

        .filter-badge {
            align-self: flex-start;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }

        .filter-field {
            padding: 10px;
        }

        .filter-actions {
            flex-direction: column;
            gap: 8px;
        }

        .filter-actions .btn {
            width: 100%;
        }

        .product-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<section class="products-page">
    <div class="page-heading">
        <h1>Sản phẩm</h1>
    </div>

    <div class="filter-shell">
        <div class="filter-header">
            <div>
                <h2 class="filter-title">Bộ lọc sản phẩm</h2>
                <p class="filter-description">Chọn nhãn hàng và cách sắp xếp giá để tìm sản phẩm nhanh hơn.</p>
            </div>
            <span class="filter-badge"><i class="bi bi-funnel"></i> Lọc thông minh</span>
        </div>

        <form method="GET" action="{{ route('products.index') }}" class="filter-grid">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <div class="filter-field">
                <label for="brand_id" class="form-label">Nhãn hàng</label>
                <select class="form-select" id="brand_id" name="brand_id">
                    <option value="">Tất cả</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-field">
                <label for="sort_order" class="form-label">Sắp xếp giá</label>
                <select class="form-select" id="sort_order" name="sort_order">
                    <option value="asc" {{ request('sort_by', 'price') === 'price' && request('sort_order', 'asc') === 'asc' ? 'selected' : '' }}>
                        Từ thấp đến cao
                    </option>
                    <option value="desc" {{ request('sort_by', 'price') === 'price' && request('sort_order') === 'desc' ? 'selected' : '' }}>
                        Từ cao đến thấp
                    </option>
                </select>
                <input type="hidden" name="sort_by" value="price">
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary flex-grow-1">Lọc</button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Xóa</a>
            </div>
        </form>
    </div>

    <div class="product-grid">
        @forelse($products as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="product-link">
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ $product->image ? asset('images/products/'.$product->image) : 'https://via.placeholder.com/200' }}" alt="{{ $product->name }}">
                    </div>
                    <div class="product-details">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <div class="brand">Hãng: {{ $product->brand->name ?? 'Chưa có' }}</div>
                        <div class="category">Danh mục: {{ $product->category->name ?? 'Chưa có' }}</div>

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
                                <span class="original-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                <span class="sale-price">{{ number_format($salePrice, 0, ',', '.') }}₫</span>
                                <span class="discount-badge">-{{ $percent }}%</span>
                            </div>
                        @else
                            <div class="price-wrapper">
                                <span class="price-only">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                            </div>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="no-results">Không tìm thấy sản phẩm nào</div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->appends(request()->query())->links() }}
    </div>
</section>
@endsection