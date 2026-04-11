@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-center text-dark mt-5"></h2>
            <div class="text-center mb-5 text-dark">Chào mừng quay lại!</div>
            <div class="card my-5">
                <form class="card-body cardbody-color p-lg-5" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="text-center">
                        <img src="images/logo/look at this.png" 
                             class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" 
                             width="200px" alt="profile">
                    </div>

                    <div class="mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" 
                               placeholder="Địa chỉ email" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" id="password" placeholder="Mật khẩu" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="showPassword">
                        <label class="form-check-label" for="showPassword">Hiện mật khẩu</label>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-dark px-5 mb-5 w-100">Đăng nhập</button>
                    </div>

                    {{-- Hiển thị lỗi chung (nếu có) --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="form-text text-center mb-5 text-dark">
                        Bạn không có tài khoản? 
                        <a href="{{ route('register') }}" class="text-dark fw-bold">Đăng ký ngay!</a>
                        <br>
                        <a href="{{ route('password.request') }}" class="text-dark fw-bold">Quên mật khẩu?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Hiển thị / ẩn mật khẩu
    document.getElementById('showPassword').addEventListener('change', function() {
        const passwordField = document.getElementById('password');
        passwordField.type = this.checked ? 'text' : 'password';
    });
</script>
@endsection