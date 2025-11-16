@extends('layouts.admin')

@section('title', 'Thống kê doanh thu')

@section('content')
<div class="container py-4">

    <h2 class="fw-bold mb-4 text-success">
        <i class="bi bi-currency-dollar me-2"></i>
        Thống kê doanh thu
    </h2>

    @if(isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    @if(isset($data['totalRevenue']))
        <div class="card mb-4 shadow-sm">
            <div class="card-body text-center">
                <h4 class="card-title">Tổng doanh thu</h4>
                <p class="display-6 text-success fw-bold">
                    {{ number_format($data['totalRevenue'], 0, ',', '.') }} ₫
                </p>
            </div>
        </div>
    @else
        <p class="text-muted">Không có dữ liệu thống kê.</p>
    @endif

    {{-- Nếu muốn thêm bảng chi tiết theo tháng (tuỳ chọn) --}}
    {{-- 
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-success">
                <tr>
                    <th>Tháng</th>
                    <th>Doanh thu (VNĐ)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['monthlyRevenue'] ?? [] as $month => $amount)
                    <tr>
                        <td>{{ $month }}</td>
                        <td>{{ number_format($amount, 0, ',', '.') }} ₫</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    --}}
</div>
@endsection
