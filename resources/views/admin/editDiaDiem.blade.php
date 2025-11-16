@extends('layouts.admin')

@section('title', 'Sửa Địa Điểm')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-right">Sửa Địa Điểm</h2>

    <form method="POST" action="{{ route('admin.updateDiaDiem', $diaDiem['id']) }}">
        @csrf
        @method('PUT')

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="form-group mb-3">
                    <label for="tenDiaDiem" class="form-label">Tên Địa Điểm</label>
                    <input type="text" class="form-control" id="tenDiaDiem" name="tenDiaDiem" value="{{ $diaDiem['tenDiaDiem'] }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="moTa" class="form-label">Mô Tả</label>
                    <textarea class="form-control" id="moTa" name="moTa" required>{{ $diaDiem['moTa'] }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="hinhAnh" class="form-label">Hình Ảnh</label>
                    <input type="text" class="form-control" id="hinhAnh" name="hinhAnh" value="{{ $diaDiem['hinhAnh'] }}">
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <a href="{{ route('admin.diadiem') }}" class="btn btn-secondary">Quay lại</a>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
