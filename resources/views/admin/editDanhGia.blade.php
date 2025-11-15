@extends('layouts.admin')

@section('title', 'Sửa Đánh Giá')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Sửa Đánh Giá</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form sửa đánh giá -->
    <form action="{{ route('admin.updateDanhGia', $danhGia['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="khachHangEmail">Email Khách Hàng</label>
            <input type="email" id="khachHangEmail" name="khachHangEmail" class="form-control" value="{{ old('khachHangEmail', $danhGia['khachHangEmail']) }}" required>
        </div>

        <div class="form-group">
            <label for="tourId">ID Tour</label>
            <input type="text" id="tourId" name="tourId" class="form-control" value="{{ old('tourId', $danhGia['tourId']) }}" required>
        </div>

        <div class="form-group">
            <label for="diemDanhGia">Điểm Đánh Giá</label>
            <input type="number" id="diemDanhGia" name="diemDanhGia" class="form-control" value="{{ old('diemDanhGia', $danhGia['diemDanhGia']) }}" min="1" max="5" required>
        </div>

        <div class="form-group">
            <label for="binhLuan">Bình Luận</label>
            <textarea id="binhLuan" name="binhLuan" class="form-control" rows="4" required>{{ old('binhLuan', $danhGia['binhLuan']) }}</textarea>
        </div>

        <div class="form-group">
            <label for="ngayDanhGia">Ngày Đánh Giá</label>
            <input type="datetime-local" id="ngayDanhGia" name="ngayDanhGia" class="form-control" value="{{ old('ngayDanhGia', \Carbon\Carbon::parse($danhGia['ngayDanhGia'])->format('Y-m-d\TH:i')) }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Cập Nhật Đánh Giá</button>
    </form>
</div>
@endsection
