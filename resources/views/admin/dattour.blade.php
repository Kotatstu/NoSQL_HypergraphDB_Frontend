@extends('layouts.admin')

@section('title', 'Danh sách Đặt Tour')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">Danh sách Đặt Tour</h2> {{-- căn trái --}}

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
                            <th>Email Người dùng</th>
                            <th>ID Tour</th>
                            <th>Số lượng</th>
                            <th>Ngày Đặt</th>
                            <th>Ngày Khởi Hành</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($dattour as $item)
                            <tr>
                                <td>{{ $item['id'] ?? '—' }}</td>
                                <td>{{ $item['khachHangEmail'] ?? '—' }}</td>
                                <td>{{ $item['tourId'] ?? '—' }}</td>
                                <td>{{ $item['soNguoi'] ?? '—' }}</td>

                                <!-- Hiển thị ngày đặt -->
                                <td>
                                    @if(isset($item['ngayDat']))
                                        {{ \Carbon\Carbon::parse($item['ngayDat'])->format('d-m-Y') }}
                                    @else
                                        — 
                                    @endif
                                </td>

                                <!-- Hiển thị ngày khởi hành -->
                                <td>
                                    @if(isset($item['ngayKhoiHanh']))
                                        {{ \Carbon\Carbon::parse($item['ngayKhoiHanh'])->format('d-m-Y') }}
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>
                                    @php
                                        $status = $item['trangThai'] ?? 'Pending';
                                        $badgeClass = match($status) {
                                            'Pending' => 'bg-warning',
                                            'Completed' => 'bg-success',
                                            'Cancelled' => 'bg-danger',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Form to delete -->
                                        <form action="{{ route('admin.deleteDatTour', $item['id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đặt tour này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-3">
                                    Chưa có lượt đặt tour nào
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
