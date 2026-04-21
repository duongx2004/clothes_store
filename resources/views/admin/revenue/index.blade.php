@extends('admin.layouts.app')
@section('title', 'Biểu đồ doanh thu')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Biểu đồ doanh thu</h1>
        </div>
        <div class="col-md-6">
            <form method="GET" action="{{ route('admin.revenue.index') }}" class="float-end">
                <div class="input-group">
                    <select name="year" class="form-select w-auto">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Xem</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Tổng doanh thu năm {{ $year }}</div>
                <div class="card-body">
                    <h4 class="card-title">{{ number_format($totalRevenue, 0, ',', '.') }} ₫</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Doanh thu theo tháng (VNĐ)</div>
                <div class="card-body">
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: @json($data),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + ' ₫';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            let value = context.raw;
                            return label + ': ' + value.toLocaleString('vi-VN') + ' ₫';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush