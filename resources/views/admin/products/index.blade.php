@extends('layouts.app')
@section('title', 'Quản lý sản phẩm')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Sản phẩm</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Thêm sản phẩm</a>
</div>
<table class="table table-bordered">
    <thead>
        <tr><th>ID</th><th>Hình ảnh</th><th>Tên</th><th>Giá</th><th>Danh mục</th><th>Tồn kho</th><th>Thao tác</th></tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>
                @if($product->image)
                    <img src="{{ asset('images/products/'.$product->image) }}" width="50" height="50" style="object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/50" width="50">
                @endif
            </td>
            <td>{{ $product->name }}</td>
            <td>{{ number_format($product->price) }} VNĐ</td>
            <td>{{ $product->category->name ?? 'N/A' }}</td>
            <td>{{ $product->stock }}</td>
            <td>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa sản phẩm?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $products->links() }}
@endsection