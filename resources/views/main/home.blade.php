@extends('layouts.main')

@section('title', 'Trang chủ')

@push('styles')
<style>
    .banner {
        background: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-shadow: 0px 2px 6px rgba(0,0,0,0.6);
    }
    .banner h1 {
        font-size: 3rem;
        font-weight: bold;
    }
    .search-box {
        margin-top: -40px;
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .tour-card img {
        height: 200px;
        object-fit: cover;
        border-radius: 0.5rem 0.5rem 0 0;
    }
</style>
@endpush

@section('content')

    <!-- Banner -->
    <div class="banner text-center">
        <div>
            <h1>Khám phá thế giới cùng TravelGo</h1>
            <p>Chọn tour yêu thích, đặt ngay hôm nay!</p>
        </div>
    </div>

    <!-- Search -->
    <div class="container search-box mt-3">
        <form action="" method="GET" class="row g-2">
            <div class="col-md-11">
                <input type="text" name="to" class="form-control" placeholder="Điểm đến">
            </div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-primary">Tìm</button>
            </div>
        </form>
    </div>


    <!-- Danh sách tour -->
    <div class="container mt-5">
        <h2 class="mb-4 text-center fw-bold text-primary">Tour nổi bật</h2>
        <div class="row">
            @forelse($tours as $tour)
                <div class="col-md-4 mb-4">
                    <div class="card tour-card h-100 shadow-sm">
                        <img src="{{ $tour['anhDaiDien'] ?? 'images/default.jpg' }}" 
                             class="card-img-top" alt="{{ $tour['tenTour'] }}">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">{{ $tour['tenTour'] }}</h5>
                            <p class="card-text text-muted mb-2">
                                <i class="bi bi-geo-alt"></i> {{ $tour['diemDen'] ?? 'Chưa cập nhật' }}
                            </p>
                            <p class="text-danger fw-bold">
                                {{ number_format($tour['gia'], 0, ',', '.') }} VNĐ
                            </p>
                            <a href="{{ route('tours.show', $tour['id']) }}" class="btn btn-outline-primary w-100">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Hiện chưa có tour nào để hiển thị.</p>
            @endforelse
        </div>
    </div>

@endsection
