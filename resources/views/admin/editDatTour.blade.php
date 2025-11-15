@extends('layouts.admin')

@section('title', 'Sửa Đặt Tour')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Sửa Đặt Tour</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form sửa đặt tour -->
    <form action="{{ route('admin.updateDatTour', $datTour['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="khachHangEmail">Email Khách Hàng</label>
            <input type="email" id="khachHangEmail" name="khachHangEmail" class="form-control" value="{{ old('khachHangEmail', $datTour['khachHangEmail']) }}" required>
        </div>

        <div class="form-group">
            <label for="tourId">ID Tour</label>
            <input type="text" id="tourId" name="tourId" class="form-control" value="{{ old('tourId', $datTour['tourId']) }}" required>
        </div>

        <div class="form-group">
            <label for="soNguoi">Số Người</label>
            <input type="number" id="soNguoi" name="soNguoi" class="form-control" value="{{ old('soNguoi', $datTour['soNguoi']) }}" required>
        </div>

        <div class="form-group">
            <label for="ngayDat">Ngày Đặt</label>
            <input type="datetime-local" id="ngayDat" name="ngayDat" class="form-control" value="{{ old('ngayDat', \Carbon\Carbon::parse($datTour['ngayDat'])->format('Y-m-d\TH:i')) }}" required>
        </div>

        <div class="form-group">
            <label for="ngayKhoiHanh">Ngày Khởi Hành</label>
            <input type="datetime-local" id="ngayKhoiHanh" name="ngayKhoiHanh" class="form-control" value="{{ old('ngayKhoiHanh', \Carbon\Carbon::parse($datTour['ngayKhoiHanh'])->format('Y-m-d\TH:i')) }}" required>
        </div>

        <div class="form-group">
            <label for="trangThai">Trạng Thái</label>
            <select id="trangThai" name="trangThai" class="form-control">
                <option value="Đã xác nhận" {{ $datTour['trangThai'] == 'Đã xác nhận' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="Chờ xác nhận" {{ $datTour['trangThai'] == 'Chờ xác nhận' ? 'selected' : '' }}>Chờ xác nhận</option>
                <option value="Hủy" {{ $datTour['trangThai'] == 'Hủy' ? 'selected' : '' }}>Hủy</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Cập Nhật Đặt Tour</button>
        
        <!-- Nút Quay lại -->
        <a href="{{ route('admin.dattour') }}" class="btn btn-secondary mt-3">Quay Lại</a>
    </form>
</div>
@endsection
