@extends('layouts.admin')

@section('title', 'Thêm Tour Mới')

@section('content')
<div class="container mt-4">
    <h2>Thêm Tour Mới</h2>

    <!-- Thông báo lỗi hoặc thành công -->
    <div id="alert" class="alert d-none"></div>

    <!-- Form thêm tour -->
    <form method="POST" action="{{ route('admin.tour.store') }}">
        @csrf  <!-- CSRF Token -->

        <div class="mb-3">
            <label for="id" class="form-label">Mã Tour</label>
            <input type="text" class="form-control" id="id" name="id" placeholder="VD: T001" required>
        </div>

        <div class="mb-3">
            <label for="tenTour" class="form-label">Tên Tour</label>
            <input type="text" class="form-control" id="tenTour" name="tenTour" required>
        </div>

        <div class="mb-3">
            <label for="gia" class="form-label">Giá</label>
            <input type="number" class="form-control" id="gia" name="gia" required>
        </div>

        <div class="mb-3">
            <label for="thoiGian" class="form-label">Thời gian</label>
            <input type="text" class="form-control" id="thoiGian" name="thoiGian" required>
        </div>

        <div class="mb-3">
            <label for="diemKhoiHanh" class="form-label">Điểm Khởi Hành</label>
            <input type="text" class="form-control" id="diemKhoiHanh" name="diemKhoiHanh" required>
        </div>

        <div class="mb-3">
            <label for="diemDen" class="form-label">Điểm Đến</label>
            <input type="text" class="form-control" id="diemDen" name="diemDen" required>
        </div>

        <div class="mb-3">
            <label for="phuongTien" class="form-label">Phương Tiện</label>
            <input type="text" class="form-control" id="phuongTien" name="phuongTien" required>
        </div>

        <div class="mb-3">
            <label for="hinhAnh" class="form-label">Hình Ảnh</label>
            <input type="text" class="form-control" id="hinhAnh" name="hinhAnh" required>
        </div>

        <div class="mb-3">
            <label for="nhaToChucId" class="form-label">Mã Nhà Tổ Chức</label>
            <input type="text" class="form-control" id="nhaToChucId" name="nhaToChucId" required>
        </div>

        <button type="submit" class="btn btn-primary">Thêm Tour</button>
    </form>
</div>

@endsection
