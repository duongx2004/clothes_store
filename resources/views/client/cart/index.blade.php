@extends('layouts.app')
@section('title', 'Giỏ hàng')
@section('content')
<h1>Giỏ hàng</h1>
@if(empty($cart))
    <p>Giỏ hàng trống.</p>
@else
        <table class="table">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cart as $id => $item)
                @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                <tr>
                    <td>
                        @if(!empty($item['image']))
                            <img src="{{ asset('images/products/'.$item['image']) }}" class="cart-product-img" alt="{{ $item['name'] }}">
                        @else
                            <img src="https://via.placeholder.com/60" class="cart-product-img">
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
            <tr>
                <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                <td><strong>{{ number_format($total) }} VNĐ</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <form action="{{ route('checkout') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Địa chỉ giao hàng</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Thanh toán</button>
    </form>
@endif
@endsection