@extends('layouts.app')
@section('title', $product->name)
@section('content')
<style>
    .main-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .product-container {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 40px 0;
        width: 75%;
    }
    .product-left img {
        width: 300px;
        height: auto;
        border: 2px solid #f85639;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
        cursor: pointer;
    }
    .product-right {
        padding-left: 30px;
        text-align: left;
        margin-right: 100px;
    }
    .product-right h2 {
        font-size: 2rem;
        margin-bottom: 20px;
        color: rgb(0, 116, 211);
    }
    .product-right button {
        flex-grow: 1;
        margin: 0 0 8px 8px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .product-right button:hover {
        background-color: rgba(248, 86, 57, 0.8);
        transform: scale(1.05);
    }
    .product-related {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 40px 0;
    }
    .product-related .section-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: rgb(0, 116, 211);
    }
    .product-grid {
        display: flex;
        justify-content: center;
        gap: 10px;
        padding: 0 29px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .product-link {
        display: block;
        text-decoration: none;
        color: inherit;
    }
    .product-card {
        width: 235px;
        height: 250px;
        display: flex;
        flex-direction: column;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        box-sizing: border-box;
    }
    .product-card:hover {
        transform: translateY(-2px);
    }
    .product-image {
        width: 100%;
        height: 150px;
        overflow: hidden;
        background: #f8f9fa;
    }
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
    }
    .product-details {
        flex-grow: 1;
        padding: 0.75rem;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .product-title {
        font-size: 1rem;
        margin-bottom: 0.25rem;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .brand-category {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.5rem;
    }
    .price-container {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 0.9rem;
    }
    .discount-price {
        color: #e74c3c;
        font-weight: bold;
        font-size: 1.1rem;
    }
    .no-results {
        text-align: center;
        padding: 2rem;
        color: #666;
    }
</style>

<div class="main-container">
    <div class="product-container">
        <div class="product-left">
            <img src="{{ $product->image ? asset('images/products/'.$product->image) : 'https://via.placeholder.com/300' }}" 
                 onclick="openFullscreen(this)" alt="{{ $product->name }}">
        </div>
        <div class="product-right">
            <h2>{{ $product->name }}</h2>
            <p><strong>Thương hiệu:</strong> AllainStore</p>
            <p><strong>Danh mục:</strong> {{ $product->category->name ?? 'Chưa phân loại' }}</p>
            <p><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }}₫</p>
            <p><strong>Tồn kho:</strong> {{ $product->stock }}</p>
            <p>{{ $product->description }}</p>
            <button type="button" class="btn btn-primary" onclick="addToCart({{ $product->id }})">
                <i class="bi bi-cart d-inline-block mx-1"></i> THÊM VÀO GIỎ HÀNG
            </button>
            <button type="button" class="btn btn-success" onclick="buyNow({{ $product->id }})">
                <i class="bi bi-wallet2"></i> MUA NGAY
            </button>
        </div>
    </div>

    {{-- <div class="product-related">
        <h2 class="section-title mb-4">Sản phẩm cùng loại</h2>
        <div class="product-grid">
            @forelse($relatedProducts as $related)
                <a href="{{ route('products.show', $related->slug) }}" class="product-link">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ $related->image ? asset('images/products/'.$related->image) : 'https://via.placeholder.com/235' }}" 
                                 alt="{{ $related->name }}">
                        </div>
                        <div class="product-details">
                            <h3 class="product-title">{{ $related->name }}</h3>
                            <div class="brand-category">
                                <span class="brand">AllainStore</span>
                                <span class="category">{{ $related->category->name ?? '' }}</span>
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
</div> --}}

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

function showAlert(message, type) {
    const alertDiv = document.createElement("div");
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.role = "alert";
    alertDiv.innerHTML = message + 
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    alertDiv.style.position = "fixed";
    alertDiv.style.top = "20px";
    alertDiv.style.left = "35%";
    alertDiv.style.zIndex = "1050";
    document.body.appendChild(alertDiv);
    setTimeout(() => {
        alertDiv.classList.remove("show");
        alertDiv.classList.add("hide");
        setTimeout(() => { 
            if (document.body.contains(alertDiv)) document.body.removeChild(alertDiv); 
        }, 500);
    }, 3000);
}

function showError(message) {
    showAlert(message, "danger");
}

function showSuccess(message) {
    showAlert(message, "success");
}

function addToCart(productId) {
    fetch("{{ route('cart.add', '') }}/" + productId, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess("Sản phẩm đã được thêm vào giỏ hàng!");
        } else {
            showError("Có lỗi xảy ra: " + (data.error || "Không xác định"));
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showError("Đã xảy ra lỗi khi thêm sản phẩm.");
    });
}

function buyNow(productId) {
    fetch("{{ route('cart.add', '') }}/" + productId, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess("Sản phẩm đã được thêm vào giỏ hàng!");
            setTimeout(() => { 
                window.location.href = "{{ route('cart.index') }}"; 
            }, 1500);
        } else {
            showError("Có lỗi xảy ra: " + (data.error || "Không xác định"));
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showError("Đã xảy ra lỗi khi thêm sản phẩm.");
    });
}
</script>
@endsection