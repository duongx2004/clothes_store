@extends('layouts.app')
@section('title', 'Giỏ hàng')

@push('styles')
<style>
    .cart-page {
        --text-main: #1a1a1a;
        --text-soft: #595959;
        --line: #e6e6e6;
        --panel: #f7f7f7;
        color: var(--text-main);
    }

    .cart-panel {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 18px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04);
        padding: 1.2rem;
        margin-bottom: 1.2rem;
        animation: riseIn 0.65s ease both;
    }

    .cart-title {
        font-size: clamp(1.6rem, 2.3vw, 2.2rem);
        margin-bottom: 1rem;
    }

    .cart-table-wrap {
        overflow-x: auto;
    }

    .cart-table {
        min-width: 860px;
        margin-bottom: 0;
        vertical-align: middle;
    }

    .cart-table thead th {
        background: #f4f4f4;
        color: #3d3d3d;
        border-bottom: 1px solid #dbdbdb;
        white-space: nowrap;
    }

    .cart-thumb {
        width: 72px;
        height: 72px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #e7e7e7;
        background: #f8f8f8;
    }

    .qty-box {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border: 1px solid #e4e4e4;
        border-radius: 999px;
        padding: 0.25rem 0.45rem;
        background: var(--panel);
    }

    .qty-box .btn {
        border-radius: 999px;
        width: 28px;
        height: 28px;
        padding: 0;
        line-height: 1;
    }

    .checkout-form .form-control:focus {
        border-color: #b8947b;
        box-shadow: 0 0 0 4px rgba(232, 212, 192, 0.35);
    }

    .checkout-btn {
        background: #1a1a1a;
        border-color: #1a1a1a;
        border-radius: 10px;
        padding: 0.55rem 1rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .checkout-btn:hover {
        background: #000;
        border-color: #000;
        transform: translateY(-2px);
        box-shadow: 0 10px 18px rgba(0, 0, 0, 0.14);
    }

    .empty-cart {
        border: 1px dashed #d8d8d8;
        background: #fff;
        border-radius: 14px;
        color: var(--text-soft);
    }

    @keyframes riseIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 767px) {
        .cart-panel {
            padding: 1rem;
        }
    }
</style>
@endpush

@section('content')
<h1>Giỏ hàng</h1>
@if(empty($cart))
    <div class="alert alert-info">Giỏ hàng trống.</div>
@else
    <table class="table">
        <thead>
            <tr><th>Hình ảnh</th><th>Sản phẩm</th><th>Giá</th><th>Số lượng</th><th>Thành tiền</th><th></th></tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cart as $id => $item)
                @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                <tr>
                    <td>
                        @if(!empty($item['image']))
                            <img src="{{ asset('images/products/'.$item['image']) }}" width="60" height="60" style="object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/60" width="60">
                        @endif
                    </td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ number_format($item['price']) }} VNĐ</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($subtotal) }} VNĐ</td>
                    <td>
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <tr class="table-active">
                <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                <td class="fw-bold">{{ number_format($total) }} VNĐ</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <form action="{{ route('checkout') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Phương thức thanh toán</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod" checked>
                <label class="form-check-label" for="payment_cod">
                    Thanh toán khi nhận hàng (COD)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="payment_vnpay" value="vnpay">
                <label class="form-check-label" for="payment_vnpay">
                    Thanh toán qua VNPay (Thẻ ATM/Visa/Master/JCB)
                </label>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ giao hàng</label>
            <textarea name="address" class="form-control" rows="2" required>{{ old('address', $userAddress) }}</textarea>
        </div>


        <button type="submit" class="btn btn-primary">Thanh toán</button>
    </form>
@endif
@endsection