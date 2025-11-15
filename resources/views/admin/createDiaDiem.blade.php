@extends('layouts.admin')

@section('title', 'Thêm Địa Điểm')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Thêm Địa Điểm</h2>
    <form action="{{ route('admin.storeDiaDiem') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id">ID Địa Điểm:</label>
            <input type="text" class="form-control" id="id" name="id" required>
        </div>
        <div class="form-group">
            <label for="tenDiaDiem">Tên Địa Điểm:</label>
            <input type="text" class="form-control" id="tenDiaDiem" name="tenDiaDiem" required>
        </div>
        <div class="form-group">
            <label for="moTa">Mô Tả:</label>
            <textarea class="form-control" id="moTa" name="moTa" required></textarea>
        </div>
        <div class="form-group">
            <label for="hinhAnh">Hình Ảnh (tùy chọn):</label>
            <input type="text" class="form-control" id="hinhAnh" name="hinhAnh">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Thêm Địa Điểm</button>
        <!-- Nút Quay lại -->
        <a href="{{ route('admin.diadiem') }}" class="btn btn-secondary mt-3">Quay lại</a>
    </form>
</div>
@endsection
