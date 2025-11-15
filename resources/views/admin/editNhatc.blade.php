@extends('layouts.admin')

@section('title', 'Sửa Nhà Tổ Chức')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Sửa Nhà Tổ Chức</h2>

    <form method="POST" action="{{ route('admin.updateNhatc', $nhatochuc['id']) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="ten">Tên Nhà Tổ Chức</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{ $nhatochuc['ten'] }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $nhatochuc['email'] }}" required>
        </div>

        <div class="form-group">
            <label for="sdt">Số Điện Thoại</label>
            <input type="text" class="form-control" id="sdt" name="sdt" value="{{ $nhatochuc['sdt'] }}" required>
        </div>

        <div class="form-group">
            <label for="diaChi">Địa Chỉ</label>
            <input type="text" class="form-control" id="diaChi" name="diaChi" value="{{ $nhatochuc['diaChi'] }}" required>
        </div>

        <div class="form-group">
            <label for="moTa">Mô Tả</label>
            <textarea class="form-control" id="moTa" name="moTa" required>{{ $nhatochuc['moTa'] }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>
    </form>

    <div class="d-flex justify-content-start mt-3">
        <a href="{{ route('admin.nhatc') }}" class="btn btn-secondary">Quay lại</a>
    </div>
</div>
@endsection
