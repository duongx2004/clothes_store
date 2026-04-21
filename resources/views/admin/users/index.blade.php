@extends('admin.layouts.app')
@section('title', 'Quản lý tài khoản')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Tài khoản</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Thêm tài khoản</a>
</div>
<table class="table table-bordered">
    <thead>
        <tr><th>ID</th><th>Tên</th><th>Email</th><th>Vai trò</th><th>Ngày tạo</th><th>Thao tác</th></tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->role === 'admin')
                    <span class="badge bg-danger">Admin</span>
                @else
                    <span class="badge bg-secondary">Customer</span>
                @endif
            </td>
            <td>{{ $user->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa tài khoản?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $users->links() }}
@endsection