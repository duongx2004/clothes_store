@extends('admin.layouts.app')
@section('title', 'Quản lý danh mục')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Danh mục sản phẩm</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Thêm danh mục</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr><th>ID</th><th>Tên danh mục</th><th>Slug</th><th>Ngày tạo</th><th>Thao tác</th></tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>{{ $category->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa danh mục này?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $categories->links() }}
@endsection