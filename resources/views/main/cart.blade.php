@extends('layouts.main')

@section('title', 'Hoá Đơn')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">
        <i class="bi bi-receipt-cutoff me-2"></i> Hóa đơn đã thanh toán
    </h2>

    @if(isset($paid) && count($paid) > 0)
    <div class="card shadow-sm mt-3">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã Hóa Đơn</th>
                        <th>Mã Đặt Tour</th>
                        <th>Số Người</th>
                        <th>Ngày Thanh Toán</th>
                        <th>Số Tiền</th>
                        <th>Phương Thức</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($paid as $bill)
                    <tr>
                        <td class="fw-bold">{{ $bill['hoaDonId'] }}</td>
                        <td>{{ $bill['datTourId'] }}</td>
                        <td>{{ $bill['soNguoi'] }}</td>
                        <td>{{ $bill['ngayThanhToan'] }}</td>
                        <td class="fw-bold text-success">
                            {{ number_format($bill['tongTien']) }}đ
                        </td>
                        <td>{{ $bill['phuongThuc'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="alert alert-light border mt-3">
            Bạn chưa có hóa đơn nào.
        </div>
    @endif
</div>
@endsection
