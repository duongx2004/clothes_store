@extends('layouts.app')
@section('title', 'Giỏ hàng')
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
            <textarea name="address" class="form-control" rows="2" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Thanh toán</button>
    </form>
@endif
@endsection