@extends('layouts.app')

@section('title', 'Đổi mật khẩu')

@section('content')
<div class="change-password-container">
    <h2>Đổi Mật Khẩu</h2>

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

    <form method="POST" action="{{ route('change.password.update') }}">
        @csrf

        <div class="mb-3">
            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
            <div class="input-group">
                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                       id="current_password" name="current_password" required>
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">Mật khẩu mới</label>
            <div class="input-group">
                <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                       id="new_password" name="new_password" required>
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
            <div class="input-group">
                <input type="password" class="form-control" 
                       id="new_password_confirmation" name="new_password_confirmation" required>
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password_confirmation')">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Đổi mật khẩu</button>
    </form>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

<style>
    .change-password-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .change-password-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #007bff;
    }
</style>
@endsection