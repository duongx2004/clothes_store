@extends('layouts.app')

@section('title', 'Đăng ký tài khoản')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card my-5">
                <div class="card-body px-lg-8" style="background-color: #ebf2fa;">
                    <h2 class="text-center mb-4">Tạo tài khoản</h2>

                    <!-- Profile Image -->
                    <div class="text-center mb-4">
                        <img src="images/logo/look at this.png" 
                             class="img-fluid profile-image-pic img-thumbnail rounded-circle"
                             width="200px" alt="profile">
                    </div>

                    <!-- Form Start -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- First Name & Last Name -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tên</label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                       value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Họ</label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                       value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                   value="{{ old('username') }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required>
                                <span class="input-group-text">@</span>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}" pattern="[0-9]{10}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                   value="{{ old('address') }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- City & Zip -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Thành phố</label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                       value="{{ old('city') }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mã Zip</label>
                                <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror"
                                       value="{{ old('zip') }}" pattern="[0-9]{5}" required>
                                @error('zip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password & Confirm -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <!-- Show password checkbox -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="showPassword">
                            <label class="form-check-label" for="showPassword">Hiện mật khẩu</label>
                        </div>

                        <!-- Submit -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Tạo tài khoản</button>
                        </div>

                        <!-- Link to login -->
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-dark">Đã có tài khoản? Đăng nhập</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Show/hide password
    document.getElementById('showPassword').addEventListener('change', function() {
        const passwordField = document.getElementById('password');
        const confirmField = document.getElementById('password_confirmation');
        const type = this.checked ? 'text' : 'password';
        passwordField.type = type;
        confirmField.type = type;
    });
</script>
@endsection