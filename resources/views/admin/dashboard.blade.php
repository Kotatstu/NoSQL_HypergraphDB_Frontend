@extends('layouts.admin')

@section('title', 'Bảng điều khiển quản trị')

@section('content')
<div class="admin-dashboard py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h1 class="fw-bold text-dark mb-2 display-5">Bảng điều khiển quản trị</h1>
            <p class="text-muted fs-5">Theo dõi và quản lý toàn bộ hệ thống tour du lịch</p>
        </div>

        <div class="row g-4 justify-content-center">

           @php
$cards = [
    ['icon' => 'user-cog', 'title' => 'Người dùng', 'desc' => 'Quản lý danh sách và quyền truy cập', 'color' => 'primary', 'route' => route('admin.users')],
    ['icon' => 'users', 'title' => 'Thành viên nhóm', 'desc' => 'Quản lý thành viên và phân quyền nhóm', 'color' => 'secondary', 'route' => route('admin.members')],
    ['icon' => 'building', 'title' => 'Nhà tổ chức', 'desc' => 'Quản lý danh sách tổ chức tour', 'color' => 'success', 'route' => route('admin.nhatc')],
    ['icon' => 'map-pin', 'title' => 'Tour', 'desc' => 'Quản lý tour và chi tiết', 'color' => 'warning', 'route' => route('admin.tours')],
    ['icon' => 'globe', 'title' => 'Địa điểm', 'desc' => 'Quản lý các điểm đến du lịch', 'color' => 'info', 'route' => route('admin.diadiem')],
    ['icon' => 'shopping-cart', 'title' => 'Đặt tour', 'desc' => 'Quản lý booking và trạng thái', 'color' => 'danger', 'route' => route('admin.dattour')],
    ['icon' => 'credit-card', 'title' => 'Hóa đơn', 'desc' => 'Quản lý thanh toán và đối soát', 'color' => 'pink', 'route' => route('admin.hoadon')],
    ['icon' => 'star', 'title' => 'Đánh giá', 'desc' => 'Xem và quản lý đánh giá khách hàng', 'color' => 'dark', 'route' => route('admin.danhgia')],
    ['icon' => 'bar-chart-2', 'title' => 'Thống kê', 'desc' => 'Xem báo cáo và số liệu thống kê', 'color' => 'purple', 'route' => route('admin.statistical')],
    ['icon' => 'user', 'title' => 'Hồ sơ', 'desc' => 'Cập nhật và chỉnh sửa thông tin cá nhân', 'color' => 'info', 'route' => route('main.info')],
];
@endphp

            @foreach ($cards as $card)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                    <div class="dashboard-card card-glass bg-gradient-{{ $card['color'] }} w-100">
                        <div class="card-inner text-center text-white d-flex flex-column justify-content-between h-100">
                            <div>
                                <div class="icon-wrapper mb-3">
                                    <i data-lucide="{{ $card['icon'] }}" class="lucide-icon"></i>
                                </div>
                                <h5 class="fw-bold">{{ $card['title'] }}</h5>
                                <p class="opacity-75 small mb-3">{{ $card['desc'] }}</p>
                            </div>
                            <a href="{{ $card['route'] }}" class="btn btn-light fw-semibold px-4 shadow-sm rounded-pill mt-3">Truy cập</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        background-color: #ffffff !important;
        font-family: 'Poppins', sans-serif;
        color: #212529;
    }

    .admin-dashboard {
        min-height: calc(100vh - 140px);
        background-color: #ffffff;
    }

    .card-glass {
        position: relative;
        overflow: hidden;
        border-radius: 1.2rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: none;
        display: flex;
        flex-direction: column;
    }

    .card-glass:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.15);
    }

    .card-inner {
        padding: 2rem 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .lucide-icon {
        width: 48px;
        height: 48px;
        stroke-width: 1.8;
    }

    .bg-gradient-primary { background: linear-gradient(135deg, #007bff, #00c6ff); }
    .bg-gradient-success { background: linear-gradient(135deg, #28a745, #7bdcb5); }
    .bg-gradient-warning { background: linear-gradient(135deg, #ffc107, #ff8b00); }
    .bg-gradient-info { background: linear-gradient(135deg, #17a2b8, #5bc0de); }
    .bg-gradient-danger { background: linear-gradient(135deg, #dc3545, #ff758c); }
    .bg-gradient-secondary { background: linear-gradient(135deg, #6c757d, #adb5bd); }
    .bg-gradient-dark { background: linear-gradient(135deg, #212529, #495057); }
    .bg-gradient-pink { background: linear-gradient(135deg, #e83e8c, #ff7eb9); }
    .bg-gradient-purple { background: linear-gradient(135deg, #6f42c1, #a775e3); } /* màu mới cho Thống kê */

    .btn {
        transition: 0.3s ease;
    }

    .btn:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endpush
@endsection
