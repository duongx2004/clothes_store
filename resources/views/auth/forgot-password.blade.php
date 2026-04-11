@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')
<div class="rp-container" style="padding: 20px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mt-5" style="margin-top: 3rem !important;">Quên mật khẩu</h2>

            <form method="POST" action="{{ route('password.email') }}" class="mt-4" style="margin-top: 1.5rem;">
                @csrf

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="email" style="display: block; margin-bottom: 0.5rem;">Email:</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required autofocus
                           style="border-radius: 0.375rem; padding: 0.375rem 0.75rem; border: 1px solid #ced4da;">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block"
                        style="background-color: #0d6efd; color: white; border: none; padding: 0.375rem 0.75rem; border-radius: 0.375rem; width: 100%;">
                    Gửi link đặt lại mật khẩu
                </button>

                {{-- Thông báo thành công --}}
                @if (session('status'))
                    <div class="alert alert-success mt-3">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Thông báo lỗi chung --}}
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}">Quay lại đăng nhập</a>
            </div>
        </div>
    </div>
</div>
@endsection