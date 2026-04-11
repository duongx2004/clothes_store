@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card my-5">
                <div class="card-body">
                    <h2 class="text-center mb-4">Đặt lại mật khẩu</h2>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <!-- Token và email ẩn -->
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                        <!-- Mật khẩu mới -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu mới</label>
                            <input type="password" id="password" name="password" 
                                   class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Xác nhận mật khẩu -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                   class="form-control" required>
                        </div>

                        <!-- Checkbox hiện mật khẩu -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="showPasswordCheckbox">
                            <label class="form-check-label" for="showPasswordCheckbox">Hiện mật khẩu</label>
                        </div>

                        <!-- Nút submit -->
                        <button type="submit" class="btn btn-primary w-100">Đặt lại mật khẩu</button>

                        <!-- Thông báo lỗi chung -->
                        @if(session('error'))
                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                        @endif

                        <!-- Thông báo thành công (nếu có) -->
                        @if(session('status'))
                            <div class="alert alert-success mt-3">{{ session('status') }}</div>
                        @endif
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}">Quay lại đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Hiển thị / ẩn mật khẩu cho cả hai trường
    const checkbox = document.getElementById('showPasswordCheckbox');
    const passwordField = document.getElementById('password');
    const confirmField = document.getElementById('password_confirmation');

    checkbox.addEventListener('change', function() {
        const type = this.checked ? 'text' : 'password';
        passwordField.type = type;
        confirmField.type = type;
    });
</script>
@endsection