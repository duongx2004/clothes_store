@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div class="row">
    <div class="col-md-6">
        <img src="{{ $product->image ? asset('images/products/'.$product->image) : 'https://via.placeholder.com/500' }}" class="img-fluid" alt="{{ $product->name }}">
    </div>
    <div class="col-md-6">
        <h1>{{ $product->name }}</h1>
        <p class="text-danger fs-3">{{ number_format($product->price) }} VNĐ</p>
        <p>{{ $product->description }}</p>
        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-lg">Thêm vào giỏ hàng</button>
        </form>
    </div>
</div>
@endsection