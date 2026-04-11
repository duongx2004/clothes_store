@extends('layouts.app')

@section('title', 'Thông tin cá nhân')

@section('content')
<div class="update-info-container">
    <h2>Cập Nhật Thông Tin</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                   id="username" name="username" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="mb-3">
            <label for="first_name" class="form-label">Họ</label>
            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                   id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Tên</label>
            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                   id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                   id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                   id="address" name="address" value="{{ old('address', $user->address) }}">
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">Thành phố</label>
            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                   id="city" name="city" value="{{ old('city', $user->city) }}">
        </div>

        <div class="mb-3">
            <label for="zip" class="form-label">Mã Zip</label>
            <input type="text" class="form-control @error('zip') is-invalid @enderror" 
                   id="zip" name="zip" value="{{ old('zip', $user->zip) }}">
        </div>

        <button type="submit" class="btn btn-primary w-100">Lưu thay đổi</button>
        <a href="{{ route('change.password.form') }}" class="btn btn-secondary w-100 mt-2">Thay đổi mật khẩu</a>
    </form>
</div>

<style>
    .update-info-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .update-info-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #007bff;
    }
</style>
@endsection