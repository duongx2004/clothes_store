@extends('layouts.app')
@section('title', 'Sản phẩm')
@section('content')
<style>
    .filter-container {
        margin-left: 14px;
        margin-bottom: 20px;
    }
    .product-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: flex-start;
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
        .product-link {
            flex: 0 0 calc(50% - 20px);
            max-width: calc(50% - 20px);
        }
    }
    @media (max-width: 480px) {
        .product-link {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>

<div class="filter-container">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Bộ lọc
        </button>
        <div class="dropdown-menu p-3" aria-labelledby="filterDropdown" style="min-width: 300px;">
            <form method="GET" action="{{ route('products.index') }}">
                <!-- Giữ lại tham số tìm kiếm nếu có -->
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <div class="mb-3">
                    <label for="filterBrand" class="form-label">Hãng</label>
                    <select class="form-select" id="filterBrand" name="brand">
                        <option value="">Tất cả</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->name }}" {{ request('brand') == $brand->name ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="filterCategory" class="form-label">Danh mục</label>
                    <select class="form-select" id="filterCategory" name="category">
                        <option value="">Tất cả</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Khoảng giá</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="price_min" placeholder="Tối thiểu" value="{{ request('price_min') }}" min="0">
                        <span class="input-group-text">-</span>
                        <input type="number" class="form-control" name="price_max" placeholder="Tối đa" value="{{ request('price_max') }}" min="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="sortBy" class="form-label">Sắp xếp theo</label>
                    <select class="form-select" id="sortBy" name="sort_by">
                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Tên sản phẩm</option>
                        <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Giá</option>
                        <option value="brand_name" {{ request('sort_by') == 'brand_name' ? 'selected' : '' }}>Hãng</option>
                        <option value="category_name" {{ request('sort_by') == 'category_name' ? 'selected' : '' }}>Danh mục</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sortOrder" class="form-label">Thứ tự</label>
                    <select class="form-select" id="sortOrder" name="sort_order">
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Áp dụng</button>
            </form>
        </div>
    </div>
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
    {{ $products->links() }}
</div>
@endsection