@extends('layouts.app')
@section('title', 'Sửa đơn hàng')
@section('content')
<h1>Sửa đơn hàng #{{ $order->order_number }}</h1>
<form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-select">
            @foreach(['pending', 'processing', 'completed', 'cancelled'] as $status)
                <option value="{{ $status }}" @if($order->status == $status) selected @endif>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
@endsection