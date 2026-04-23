@extends('admin.layouts.app')
@section('title', 'Quản lý thương hiệu')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Thương hiệu</h1>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">+ Thêm thương hiệu</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr><th>ID</th><th>Tên thương hiệu</th><th>Slug</th><th>Ngày tạo</th><th>Thao tác</th></tr>
    </thead>
    <tbody>
        @foreach($brands as $brand)
        <tr>
            <td>{{ $brand->id }}</td>
            <td>{{ $brand->name }}</td>
            <td>{{ $brand->slug }}</td> 
            <td>{{ $brand->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa thương hiệu này?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $brands->links() }}
@endsection