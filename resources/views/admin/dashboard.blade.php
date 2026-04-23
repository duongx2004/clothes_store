@extends('admin.layouts.app')
@section('title', 'Dashboard')
@push('styles')
<style>
    .stat-card {
        transition: transform 0.2s;
        border-radius: 1rem;
        overflow: hidden;
        cursor: pointer;
    }
    .stat-card:hover {
        transform: translateY(-4px);
    }
    .stat-card .card-body {
        padding: 1.25rem;
    }
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.3;
        position: absolute;
        right: 1rem;
        bottom: 1rem;
    }
    .recent-order-list {
        max-height: 320px;
        overflow-y: auto;
    }
    .recent-order-list .list-group-item {
        border-left: none;
        border-right: none;
    }
    .recent-order-list .list-group-item:first-child {
        border-top: none;
    }
    .chart-container {
        min-height: 300px;
    }
    @media (max-width: 768px) {
        .stat-card .card-body {
            padding: 1rem;
        }
        .stat-icon {
            font-size: 1.8rem;
        }
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <!-- Hàng 1: Thống kê chính -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-primary text-white h-100">
                    <div class="card-body position-relative">
                        <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
                        <h6 class="card-title text-uppercase fw-semibold">Sản phẩm</h6>
                        <h2 class="mt-2 mb-0">{{ number_format($totalProducts) }}</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-success text-white h-100">
                    <div class="card-body position-relative">
                        <div class="stat-icon"><i class="bi bi-cart-check"></i></div>
                        <h6 class="card-title text-uppercase fw-semibold">Đơn hàng</h6>
                        <h2 class="mt-2 mb-0">{{ number_format($totalOrders) }}</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-warning text-white h-100">
                    <div class="card-body position-relative">
                        <div class="stat-icon"><i class="bi bi-people"></i></div>
                        <h6 class="card-title text-uppercase fw-semibold">Người dùng</h6>
                        <h2 class="mt-2 mb-0">{{ number_format($totalUsers) }}</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('admin.revenue.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-danger text-white h-100">
                    <div class="card-body position-relative">
                        <div class="stat-icon"><i class="bi bi-graph-up"></i></div>
                        <h6 class="card-title text-uppercase fw-semibold">Doanh thu</h6>
                        <h2 class="mt-2 mb-0">{{ number_format($totalRevenue, 0, ',', '.') }}₫</h2>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Hàng 2: Thống kê bổ sung (Brand, Category, đơn hàng pending) -->
    <div class="row g-4 mb-4">
        <div class="col-md-4 col-sm-6">
            <a href="{{ route('admin.brands.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-info text-white h-100">
                    <div class="card-body position-relative">
                        <div class="stat-icon"><i class="bi bi-tags"></i></div>
                        <h6 class="card-title text-uppercase fw-semibold">Thương hiệu</h6>
                        <h2 class="mt-2 mb-0">{{ number_format($totalBrands) }}</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-sm-6">
            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                <div class="card stat-card bg-secondary text-white h-100">
                    <div class="card-body position-relative">
                        <div class="stat-icon"><i class="bi bi-folder"></i></div>
                        <h6 class="card-title text-uppercase fw-semibold">Danh mục</h6>
                        <h2 class="mt-2 mb-0">{{ number_format($totalCategories) }}</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-sm-6">
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="text-decoration-none">
                <div class="card stat-card bg-warning text-white h-100">
                    <div class="card-body position-relative">
                        <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
                        <h6 class="card-title text-uppercase fw-semibold">Đơn chờ xử lý</h6>
                        <h2 class="mt-2 mb-0">{{ number_format($pendingOrders) }}</h2>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Biểu đồ doanh thu + Đơn hàng gần đây -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-bar-chart-steps me-1"></i> Doanh thu 6 tháng gần nhất
                </div>
                <div class="card-body chart-container">
                    <canvas id="revenueChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-clock-history me-1"></i> Đơn hàng mới nhất
                </div>
                <div class="card-body p-0">
                    <div class="recent-order-list">
                        <ul class="list-group list-group-flush">
                            @forelse($recentOrders as $order)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $order->order_number }}</strong><br>
                                        <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span><br>
                                        <span class="badge 
                                            @if($order->status == 'pending') bg-warning
                                            @elseif($order->status == 'processing') bg-info
                                            @elseif($order->status == 'completed') bg-success
                                            @else bg-secondary @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted py-4">Chưa có đơn hàng</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: @json($chartData),
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: 'rgb(54, 162, 235)',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw;
                                return context.dataset.label + ': ' + value.toLocaleString('vi-VN') + ' ₫';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN') + ' ₫';
                            }
                        },
                        title: {
                            display: true,
                            text: 'Doanh thu (VNĐ)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tháng'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush