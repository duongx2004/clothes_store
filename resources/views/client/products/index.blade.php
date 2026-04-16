@extends('layouts.app')
@section('title', 'Sản phẩm')
@section('content')
<style>
    .page-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }
    .filter-shell {
        position: relative;
        overflow: hidden;
        background: linear-gradient(180deg, #ffffff 0%, #fafbfc 100%);
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 18px;
        padding: 18px;
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.06);
        margin-bottom: 22px;
    }
    .filter-shell::before {
        content: '';
        position: absolute;
        inset: 0 auto auto 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #0d6efd 0%, #4dabf7 100%);
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
        color: #0f172a;
    }
    .filter-description {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 0.92rem;
    }
    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border-radius: 999px;
        background: #eef4ff;
        color: #1d4ed8;
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
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px;
    }
    .filter-shell .form-label {
        margin-bottom: 8px;
        font-size: 0.88rem;
        font-weight: 600;
        color: #334155;
    }
    .filter-shell .form-select {
        min-height: 44px;
        border-radius: 10px;
        border-color: #dbe3ea;
        box-shadow: none;
        padding-left: 12px;
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
        box-shadow: 0 10px 18px rgba(13, 110, 253, 0.18);
    }
    .filter-actions .btn-outline-secondary {
        background: #fff;
        border-color: #cbd5e1;
        color: #334155;
    }
    .product-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    .product-link {
        text-decoration: none;
        color: inherit;
        flex: 0 0 calc(33.333% - 20px);
        max-width: calc(33.333% - 20px);
    }
    .product-card {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.2s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        transform: translateY(-5px);
    }
    .product-image {
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
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
    .brand, .category {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 4px;
    }
    .price {
        color: #e74c3c;
        font-weight: bold;
        font-size: 1.1rem;
        margin-top: 8px;
    }
    .no-results {
        text-align: center;
        width: 100%;
        padding: 50px;
        color: #666;
    }
    .pagination {
        margin-top: 30px;
        justify-content: center;
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
        .product-link {
            flex: 0 0 calc(50% - 20px);
            max-width: calc(50% - 20px);
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
        .product-link {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>

<div class="page-heading">
    <h1 class="mb-0">Sản phẩm</h1>
</div>

<div class="filter-shell">
    <div class="filter-header">
        <div>
            <h2 class="filter-title">Bộ lọc sản phẩm</h2>
            <p class="filter-description">Chọn nhãn hàng và cách sắp xếp giá để tìm sản phẩm nhanh hơn.</p>
        </div>
   
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
                    <div class="price">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                </div>
            </div>
        </a>
    @empty
        <div class="no-results">Không tìm thấy sản phẩm nào</div>
    @endforelse
</div>

<div class="d-flex justify-content-center">
    {{ $products->appends(request()->query())->links() }}
</div>
@endsection