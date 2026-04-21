@extends('admin.layouts.app')
@section('title', 'Quản lý sản phẩm')
@section('content')
<h1>Thêm sản phẩm</h1>
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Tên sản phẩm</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control" rows="3" required></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Giá (VNĐ)</label>
        <input type="number" name="price" class="form-control" step="1000" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Giá khuyến mãi (VNĐ)</label>
        <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price ?? '') }}" step="1000">
        <small class="text-muted">Để trống nếu không giảm giá.</small>
    </div>

    <div class="mb-3">
        <label class="form-label">Phần trăm giảm (%)</label>
        <input type="number" name="discount_percent" class="form-control" value="{{ old('discount_percent', $product->discount_percent ?? '') }}" min="0" max="100">
        <small class="text-muted">Ưu tiên: nếu có giá khuyến mãi, sẽ dùng giá đó; nếu không thì tính theo %.</small>
    </div>
    <div class="mb-3">
        <label class="form-label">Tồn kho</label>
        <input type="number" name="stock" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Danh mục</label>
        <select name="category_id" class="form-control" required>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Hình ảnh</label>
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
</form>
@endsection