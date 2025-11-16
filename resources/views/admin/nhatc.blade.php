@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Danh sách Nhà Tổ Chức</h2>

    {{-- Thông báo thành công / lỗi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            {{-- Nút thêm nhà tổ chức --}}
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.createNhatc') }}" class="btn btn-success">
                    + Thêm Nhà Tổ Chức
                </a>
            </div>

            {{-- Bảng danh sách --}}
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên Nhà Tổ Chức</th>
                        <th>Email</th>
                        <th>Số Điện Thoại</th>
                        <th>Địa Chỉ</th>
                        <th>Chuyên Môn</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($nhatochuc as $ntc)
                        <tr>
                            <td>{{ $ntc['id'] }}</td>
                            <td>{{ $ntc['ten'] }}</td>
                            <td>{{ $ntc['email'] }}</td>
                            <td>{{ $ntc['sdt'] }}</td>
                            <td>{{ $ntc['diaChi'] }}</td>
                            <td>{{ $ntc['moTa'] }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Nút sửa --}}
                                    <a href="{{ route('admin.editNhatc', $ntc['id']) }}" class="btn btn-sm btn-primary">Sửa</a>
                                    
                                    {{-- Nút xoá --}}
                                    <form action="{{ route('admin.deleteNhatc', $ntc['id']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Chưa có nhà tổ chức nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
