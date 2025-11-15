@extends('layouts.admin')

@section('title', 'Sửa Tour')

@section('content')
<div class="container mt-4">
    <h2>Sửa Tour</h2>

    <!-- Thông báo lỗi hoặc thành công -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Form sửa tour -->
    <form method="POST" action="{{ route('admin.tour.update', $tour['id']) }}">
        @csrf
        @method('PUT') <!-- Sử dụng PUT để cập nhật -->

        <div class="mb-3">
            <label for="id" class="form-label">Mã Tour</label>
            <input type="text" class="form-control" id="id" name="id" value="{{ old('id', $tour['id']) }}" required readonly>
        </div>

        <div class="mb-3">
            <label for="tenTour" class="form-label">Tên Tour</label>
            <input type="text" class="form-control" id="tenTour" name="tenTour" value="{{ old('tenTour', $tour['tenTour']) }}" required>
        </div>

        <div class="mb-3">
            <label for="gia" class="form-label">Giá</label>
            <input type="number" class="form-control" id="gia" name="gia" value="{{ old('gia', $tour['gia']) }}" required>
        </div>

        <div class="mb-3">
            <label for="thoiGian" class="form-label">Thời gian</label>
            <input type="text" class="form-control" id="thoiGian" name="thoiGian" value="{{ old('thoiGian', $tour['thoiGian']) }}" required>
        </div>

        <div class="mb-3">
            <label for="diemKhoiHanh" class="form-label">Điểm Khởi Hành</label>
            <input type="text" class="form-control" id="diemKhoiHanh" name="diemKhoiHanh" value="{{ old('diemKhoiHanh', $tour['diemKhoiHanh']) }}" required>
        </div>

        <div class="mb-3">
            <label for="diemDen" class="form-label">Điểm Đến</label>
            <input type="text" class="form-control" id="diemDen" name="diemDen" value="{{ old('diemDen', $tour['diemDen']) }}" required>
        </div>

        <div class="mb-3">
            <label for="phuongTien" class="form-label">Phương Tiện</label>
            <input type="text" class="form-control" id="phuongTien" name="phuongTien" value="{{ old('phuongTien', $tour['phuongTien']) }}" required>
        </div>

        <div class="mb-3">
            <label for="hinhAnh" class="form-label">Hình Ảnh</label>
            <input type="text" class="form-control" id="hinhAnh" name="hinhAnh" value="{{ old('hinhAnh', $tour['hinhAnh']) }}" required>
        </div>

        <div class="mb-3">
            <label for="nhaToChucId" class="form-label">Mã Nhà Tổ Chức</label>
            <input type="text" class="form-control" id="nhaToChucId" name="nhaToChucId" value="{{ old('nhaToChucId', $tour['nhaToChucId']) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật Tour</button>
    </form>
</div>
@endsection
