@extends('admin.layouts.app')
@section('title', 'Import sản phẩm từ CSV')
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Import sản phẩm từ file CSV</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> <strong>Hướng dẫn:</strong>
            <ul class="mb-0 mt-2">
                <li>File CSV phải có các cột: <code>name, slug, description, price, sale_price, discount_percent, stock, category, brand, image_url</code> (có thể thiếu vài cột, nhưng <strong>name, price, stock, category</strong> là bắt buộc).</li>
                <li><code>category</code> và <code>brand</code> là tên (nếu chưa có sẽ tự động tạo).</li>
                <li><code>image_url</code> có thể là đường dẫn ảnh (URL) – hệ thống sẽ tự tải về và lưu vào <code>public/images/products/</code>.</li>
                <li>Mã hóa file: UTF-8 (có thể dùng dấu tiếng Việt).</li>
            </ul>
        </div>

        <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Chọn file CSV</label>
                <input type="file" name="csv_file" class="form-control @error('csv_file') is-invalid @enderror" accept=".csv, .txt" required>
                @error('csv_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Import</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Tải file mẫu</h5>
    </div>
    <div class="card-body">
        <a href="{{ route('admin.products.import') }}?download=sample" class="btn btn-outline-success">Tải file CSV mẫu</a>
    </div>
</div>
@endsection