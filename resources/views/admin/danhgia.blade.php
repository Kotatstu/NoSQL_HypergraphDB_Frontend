@extends('layouts.admin')

@section('title', 'Danh sách Đánh giá')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-start">Danh sách Đánh giá</h2> {{-- căn trái --}}

    @if ($error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>ID Tour</th>
                            <th>Email Khách hàng</th>
                            <th>Số sao</th>
                            <th>Nội dung</th>
                            <th class="text-center" style="width: 150px;">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($danhgia as $item)
                            <tr>
                                <td>{{ $item['id'] ?? '—' }}</td>
                                <td>{{ $item['tourId'] ?? '—' }}</td>
                                <td>{{ $item['khachHangEmail'] ?? '—' }}</td>

                                <td>
                                    @php
                                        $stars = $item['diemDanhGia'] ?? 0;
                                    @endphp
                                    <span class="badge bg-warning text-dark">{{ $stars }} ⭐</span>
                                </td>

                                <td>{{ $item['binhLuan'] ?? '—' }}</td>

                                <!-- Hành động -->
                                <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <!-- Sửa -->
        <a href="{{ route('admin.editDanhGia', $item['id']) }}" class="btn btn-sm btn-primary">Sửa</a>

        <!-- Xóa -->
        <form action="{{ route('admin.deleteDanhGia', $item['id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này không?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
        </form>
    </div>
</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    Chưa có đánh giá nào
                                </td>
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
        font-size: 0.85rem;
        padding: 0.4em 0.7em;
    }
</style>
@endpush
@endsection
