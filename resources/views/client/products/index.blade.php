@extends('layouts.app')
@section('title', 'Sản phẩm')
@section('content')
<h1 class="mb-4">Sản phẩm</h1>
<div class="row">
    @foreach($products as $product)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="text-center p-3" style="height: 250px; display: flex; align-items: center; justify-content: center;">
                <img src="{{ $product->image ? asset('images/products/'.$product->image) : 'https://via.placeholder.com/300' }}" 
                     class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;" alt="{{ $product->name }}">
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text text-danger fw-bold">{{ number_format($product->price) }} VNĐ</p>
                <div class="mt-auto">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success"><i class="bi bi-cart d-inline-block mx-1"></i> THÊM VÀO GIỎ HÀNG</button>
                    </form>
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary"><i class="bi bi-eye d-inline-block mx-1"></i> Xem chi tiết</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
{{ $products->appends(['search' => request('search')])->links() }}
@endsection