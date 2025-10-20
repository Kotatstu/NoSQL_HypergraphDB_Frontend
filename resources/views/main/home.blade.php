@extends('layouts.main')

@section('title', 'Trang chủ - TravelGo')

@section('content')
    <!-- ✅ Thông tin người dùng -->
    <div class="alert alert-success text-center">
        Xin chào, <strong>{{ $user['name'] ?? 'Khách' }}</strong>!
    </div>
    <!-- Banner -->
    <div class="mb-5">
        <img src="{{ asset('images/banner.jpg') }}" class="img-fluid rounded" alt="Banner du lịch">
    </div>

    <!-- Danh sách tour nổi bật -->
    <h2 class="mb-4 text-center text-primary">Tour nổi bật</h2>

    <div class="row">
        @foreach ($tours as $tour)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <img src="{{ asset('images/' . $tour['image']) }}" class="card-img-top" alt="{{ $tour['name'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $tour['name'] }}</h5>
                        <p class="card-text">{{ $tour['description'] }}</p>
                        <p class="fw-bold text-danger">{{ number_format($tour['price'], 0, ',', '.') }}₫</p>
                        <a href="/tours/{{ $tour['id'] }}" class="btn btn-primary w-100">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
