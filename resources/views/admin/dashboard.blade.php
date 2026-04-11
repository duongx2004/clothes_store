@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
<h1 class="h2">Dashboard</h1>
<p>Chào mừng admin, {{ auth()->user()->name }}!</p>
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Sản phẩm</div>
            <div class="card-body">
                <h5 class="card-title">{{ \App\Models\Product::count() }}</h5>
                <p class="card-text">Tổng số sản phẩm</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Đơn hàng</div>
            <div class="card-body">
                <h5 class="card-title">{{ \App\Models\Order::count() }}</h5>
                <p class="card-text">Tổng số đơn hàng</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">Khách hàng</div>
            <div class="card-body">
                <h5 class="card-title">{{ \App\Models\User::where('role', 'customer')->count() }}</h5>
                <p class="card-text">Số khách hàng</p>
            </div>
        </div>
    </div>
</div>
@endsection