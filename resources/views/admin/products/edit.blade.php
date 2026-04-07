@extends('layouts.app')
@section('title', 'Sửa sản phẩm')
@section('content')
<h1>Sửa sản phẩm: {{ $product->name }}</h1>
<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Tên sản phẩm</label>
        <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Slug</label>
        <input type="text" name="slug" value="{{ $product->slug }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
    </div>
    <div class="mb-3">
        <label>Giá</label>
        <input type="number" name="price" value="{{ $product->price }}" class="form-control" step="1000" required>
    </div>
    <div class="mb-3">
        <label>Tồn kho</label>
        <input type="number" name="stock" value="{{ $product->stock }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Danh mục</label>
        <select name="category_id" class="form-control" required>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @if($cat->id==$product->category_id) selected @endif>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Hình ảnh hiện tại</label><br>
        @if($product->image)
            <img src="{{ asset('images/products/'.$product->image) }}" width="100" height="100" style="object-fit: cover;">
        @else
            <span>Chưa có ảnh</span>
        @endif
    </div>
    <div class="mb-3">
        <label>Thay đổi ảnh mới</label>
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
@endsection