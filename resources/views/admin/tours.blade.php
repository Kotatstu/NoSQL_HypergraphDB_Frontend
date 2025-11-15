@extends('layouts.admin')

@section('title', 'Danh sách Tour')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">Danh sách Tour</h2>

    @if ($error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span class="fw-bold">Tất cả Tour</span>
            <!-- Link Thêm Tour dẫn đến route tạo mới tour -->
            <a href="{{ route('admin.createTour') }}" class="btn btn-light btn-sm">Thêm Tour</a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên Tour</th>
                            <th>Giá</th>
                            <th>Thời gian</th>
                            <th>Điểm khởi hành</th>
                            <th>Điểm đến</th>
                            <th>Nhà tổ chức</th>
                            <th>Phương tiện</th>  <!-- Thêm cột phương tiện -->
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tours as $tour)
                            <tr>
                                <td>{{ $tour['id'] ?? '—' }}</td>
                                <td>{{ $tour['tenTour'] ?? 'Chưa có tên' }}</td>

                                <td>
                                    <span class="badge bg-success">
                                        {{ number_format($tour['gia'] ?? 0, 0, ',', '.') }} đ
                                    </span>
                                </td>

                                <td>{{ $tour['thoiGian'] ?? '—' }}</td>
                                <td>{{ $tour['diemKhoiHanh'] ?? '—' }}</td>
                                <td>{{ $tour['diemDen'] ?? '—' }}</td>
                                <td>{{ $tour['nhaToChucId'] ?? '—' }}</td>

                                <!-- Thêm cột Phương tiện -->
                                <td>{{ $tour['phuongTien'] ?? '—' }}</td> <!-- Hiển thị phương tiện -->

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Cập nhật các hành động Sửa và Xóa -->
                                        <a href="{{ route('admin.editTour', $tour['id']) }}" class="btn btn-sm btn-primary">Sửa</a>

                                        <!-- Nút Xóa -->
                                        <form action="{{ route('admin.deleteTour', $tour['id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tour này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-3">Chưa có tour nào</td> <!-- Chỉnh lại số cột -->
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: #f1f7ff;
    }

    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.7em;
    }

    .card-header a.btn {
        font-size: 0.85rem;
    }
</style>
@endpush
@endsection
