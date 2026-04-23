@extends('admin.layouts.app')
@section('title', 'Sửa sản phẩm')
@section('content')
<h1>Sửa sản phẩm: {{ $product->name }}</h1>
<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Tên sản phẩm</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label>Slug</label>
        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $product->slug) }}" required>
        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $product->description) }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label>Giá gốc (VNĐ)</label>
        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label>Giá khuyến mãi (VNĐ)</label>
        <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
    </div>
    <div class="mb-3">
        <label>Phần trăm giảm (%)</label>
        <input type="number" name="discount_percent" class="form-control" min="0" max="100" value="{{ old('discount_percent', $product->discount_percent) }}">
    </div>
    <div class="mb-3">
        <label>Tồn kho</label>
        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" required>
        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label>Danh mục</label>
        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
            <option value="">-- Chọn danh mục --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label>Thương hiệu</label>
        <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
            <option value="">-- Chọn thương hiệu --</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
            @endforeach
        </select>
        @error('brand_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label>Hình ảnh hiện tại</label><br>
        @if($product->image)
            <img src="{{ asset('images/products/'.$product->image) }}" width="100" class="mb-2">
        @endif
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>
</div>
</form>
@endsection