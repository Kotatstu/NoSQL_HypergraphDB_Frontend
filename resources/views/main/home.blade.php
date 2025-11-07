@extends('layouts.main')

@section('title', 'Trang chủ - TravelGo')

@section('content')
<div class="alert alert-success text-center mt-3">
    Xin chào, <strong>{{ $user['name'] ?? 'Khách' }}</strong>!
</div>

<!-- Banner -->
<div class="mb-5">
    <img src="{{ asset('images/banner.jpg') }}" class="img-fluid rounded shadow-sm" alt="Banner du lịch">
</div>

<!-- Thông báo lỗi -->
@if (session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
@endif

<!-- Danh sách tour -->
<h2 class="mb-4 text-center text-primary fw-bold">🌍 Tour nổi bật</h2>

@if (count($tours) > 0)
    <div class="row">
        @foreach ($tours as $tour)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 border-0">
                    <img src="{{ asset('images/' . ($tour['hinhAnh'] ?? 'default.jpg')) }}" 
                         class="card-img-top" alt="{{ $tour['tenTour'] ?? 'Tour du lịch' }}">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-dark">{{ $tour['tenTour'] ?? 'Chưa có tên' }}</h5>

                        <p class="card-text text-muted small mb-2">
                            <i class="bi bi-geo-alt"></i>
                            {{ $tour['diemKhoiHanh'] ?? 'N/A' }} → {{ $tour['diemDen'] ?? 'N/A' }}
                        </p>

                        <p class="card-text mb-3">{{ $tour['moTa'] ?? 'Không có mô tả' }}</p>

                        <p class="fw-bold text-danger mb-2">
                            {{ number_format($tour['gia'] ?? 0, 0, ',', '.') }}₫
                        </p>

                        <p class="text-secondary small mb-3">
                            <i class="bi bi-clock"></i> {{ $tour['thoiGian'] ?? '' }} |
                            <i class="bi bi-bus-front"></i> {{ $tour['phuongTien'] ?? '' }}
                        </p>

                        <a href="/tours/{{ $tour['id'] ?? 0 }}" class="btn btn-primary mt-auto w-100">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center text-muted py-5">
        <i class="bi bi-emoji-frown fs-1"></i>
        <p>Không tìm thấy tour nào!</p>
    </div>
@endif
@endsection
