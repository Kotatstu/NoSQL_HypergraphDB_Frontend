@extends('layouts.admin')

@section('title', 'Chỉnh sửa Hóa đơn')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-start">Chỉnh sửa Hóa đơn #{{ $hoadon['id'] }}</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.updateHoaDon', $hoadon['id']) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="datTourId" class="form-label">ID Đặt Tour</label>
                    <input type="text" class="form-control" id="datTourId" name="datTourId" value="{{ old('datTourId', $hoadon['datTourId']) }}" required>
                </div>

                <div class="mb-3">
                    <label for="tongTien" class="form-label">Tổng tiền (VND)</label>
                    <input type="number" class="form-control" id="tongTien" name="tongTien" value="{{ old('tongTien', $hoadon['tongTien']) }}" required>
                </div>

                <div class="mb-3">
                    <label for="phuongThucThanhToan" class="form-label">Phương thức thanh toán</label>
                    <input type="text" class="form-control" id="phuongThucThanhToan" name="phuongThucThanhToan" value="{{ old('phuongThucThanhToan', $hoadon['phuongThucThanhToan']) }}" required>
                </div>

                <div class="mb-3">
                    <label for="trangThaiThanhToan" class="form-label">Trạng thái thanh toán</label>
                    <select class="form-select" id="trangThaiThanhToan" name="trangThaiThanhToan" required>
                        <option value="Pending" {{ $hoadon['trangThaiThanhToan'] == 'Pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                        <option value="Paid" {{ $hoadon['trangThaiThanhToan'] == 'Paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="Cancelled" {{ $hoadon['trangThaiThanhToan'] == 'Cancelled' ? 'selected' : '' }}>Hủy bỏ</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="ngayThanhToan" class="form-label">Ngày thanh toán</label>
                    <input type="date" class="form-control" id="ngayThanhToan" name="ngayThanhToan" 
                        value="{{ old('ngayThanhToan', \Carbon\Carbon::parse($hoadon['ngayThanhToan'])->format('Y-m-d')) }}" required>
                </div>

                <div class="mb-3">
                    <label for="gioThanhToan" class="form-label">Giờ thanh toán</label>
                    <input type="time" class="form-control" id="gioThanhToan" name="gioThanhToan" 
                        value="{{ old('gioThanhToan', \Carbon\Carbon::parse($hoadon['ngayThanhToan'])->format('H:i')) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>

            <!-- Nút quay lại -->
            <a href="{{ route('admin.hoadon') }}" class="btn btn-secondary mt-3">Quay lại</a>
        </div>
    </div>
</div>
@endsection
