@extends('admin.layouts.app')
@section('title', 'Thêm thương hiệu')
@section('content')
<h1>Thêm thương hiệu</h1>
<form action="{{ route('admin.brands.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Tên thương hiệu</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" 
            value="{{ old('slug', $brand->slug ?? '') }}" required>
        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Tạo thương hiệu</button>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>
</form>
@endsection