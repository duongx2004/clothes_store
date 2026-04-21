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

<script>
// Hàm phóng to ảnh (giữ lại vì là tiện ích, không liên quan logic Laravel)
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
