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
    }

    @media (max-width: 576px) {
        .product-meta {
            grid-template-columns: 1fr;
        }

        .product-actions button {
            width: 100%;
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
<<<<<<< HEAD
            <h2>{{ $product->name }}</h2>
            <p><strong>Thương hiệu:</strong> {{ $product->brand->name ?? 'Chưa xác định' }}</p>
            <p><strong>Danh mục:</strong> {{ $product->category->name ?? 'Chưa phân loại' }}</p>
            <p><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }}₫</p>
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
        <h2 class="section-title mb-4">Sản phẩm cùng loại</h2>
        <div class="product-grid">
            @forelse($relatedProducts as $related)
                <a href="{{ route('products.show', $related->slug) }}" class="product-link">
                    <div class="product-card">
                        <div class="product-image">
                            @if($related->image)
                                <img src="{{ asset('images/products/'.$related->image) }}" alt="{{ $related->name }}">
                            @else
                                <img src="https://via.placeholder.com/235" alt="No Image">
                            @endif
                        </div>
                        <div class="product-details">
                            <h3 class="product-title">{{ $related->name }}</h3>
                            <div class="brand-category">
                                <span class="brand">{{ $related->brand->name ?? 'Chưa có thương hiệu' }}</span>
                                <span class="category">{{ $related->category->name ?? 'Chưa có danh mục' }}</span>
                            </div>
                            <div class="price-container">
                                <span class="original-price">{{ number_format($related->price * 1.5, 0, ',', '.') }}₫</span>
                                <span class="discount-price">{{ number_format($related->price, 0, ',', '.') }}₫</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="no-results">Không tìm thấy sản phẩm nào cùng loại</div>
            @endforelse
        </div>
    </div>
</div>
=======
            <h1>{{ $product->name }}</h1>

            <div class="product-meta">
                <div><strong>Thương hiệu:</strong> {{ $product->brand->name ?? 'Chưa xác định' }}</div>
                <div><strong>Danh mục:</strong> {{ $product->category->name ?? 'Chưa phân loại' }}</div>
                <div><strong>Tồn kho:</strong> {{ $product->stock }}</div>
                <div><strong>Mã sản phẩm:</strong> #{{ $product->id }}</div>
            </div>

            <div class="product-price">{{ number_format($product->price, 0, ',', '.') }}₫</div>
            <p class="product-description">{{ $product->description }}</p>

            <div class="quantity-box">
                <label for="quantity-product" class="form-label">Số lượng</label>
                <input id="quantity-product" type="number" class="form-control" min="1" max="{{ $product->stock }}" value="1" {{ $product->stock < 1 ? 'disabled' : '' }}>
            </div>

            <div class="product-actions">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="quantity" value="1" class="quantity-sync">
                    <button type="submit" class="btn btn-dark">
                        <i class="bi bi-cart d-inline-block mx-1"></i>THÊM VÀO GIỎ HÀNG
                    </button>
                </form>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="buy_now" value="1">
                    <input type="hidden" name="quantity" value="1" class="quantity-sync">
                    <button type="submit" class="btn btn-outline-dark">
                        <i class="bi bi-wallet2"></i> MUA NGAY
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
>>>>>>> 1e05f062b1a77963a838c2c5bc47506197b5379d

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

const quantityInput = document.getElementById('quantity-product');
const quantityFields = document.querySelectorAll('.quantity-sync');

if (quantityInput) {
    const syncQuantity = function () {
        quantityFields.forEach(function (field) {
            field.value = quantityInput.value;
        });
    };

    quantityInput.addEventListener('input', syncQuantity);
    syncQuantity();
}
</script>
@endsection
