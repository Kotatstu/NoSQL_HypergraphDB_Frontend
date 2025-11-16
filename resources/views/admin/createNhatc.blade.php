@extends('layouts.admin')

@section('title', 'Thêm Nhà Tổ Chức Mới')

@section('content')
<div class="container mt-4">
    <h2>Thêm Nhà Tổ Chức Mới</h2>

    <!-- Thông báo lỗi hoặc thành công -->
    <div id="alert" class="alert d-none"></div>

    <!-- Form thêm nhà tổ chức -->
    <form method="POST" action="{{ route('admin.nhatc.store') }}">
        @csrf  <!-- CSRF Token -->

        <div class="mb-3">
            <label for="id" class="form-label">Mã Nhà Tổ Chức (ID)</label>
            <input type="text" class="form-control" id="id" name="id" placeholder="VD: NTC004" required>
        </div>

        <div class="mb-3">
            <label for="ten" class="form-label">Tên Nhà Tổ Chức</label>
            <input type="text" class="form-control" id="ten" name="ten" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="sdt" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="sdt" name="sdt" required>
        </div>

        <div class="mb-3">
            <label for="diaChi" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="diaChi" name="diaChi" required>
        </div>

        <div class="mb-3">
            <label for="moTa" class="form-label">Mô tả</label>
            <textarea class="form-control" id="moTa" name="moTa" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Thêm Nhà Tổ Chức</button>
    </form>

    <!-- Nút quay lại -->
    <a href="{{ route('admin.nhatc') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>

@endsection
