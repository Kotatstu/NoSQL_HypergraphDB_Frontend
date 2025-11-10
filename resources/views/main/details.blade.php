@extends('layouts.main')

@section('title', $tour['tenTour'] ?? 'Chi tiết tour')

@section('content')
<div class="container my-5">
    {{-- Tiêu đề Tour --}}
    <div class="text-center mb-4">
        <h1 class="fw-bold text-primary">{{ $tour['tenTour'] ?? 'Tên tour không xác định' }}</h1>
        <p class="text-muted">{{ $tour['moTa'] ?? '' }}</p>
    </div>

    {{-- Ảnh Tour + Thông tin tổng quan --}}
    <div class="row g-4 align-items-start">
        <div class="col-md-6">
            <img src="{{ asset('images/' . ($tour['hinhAnh'] ?? 'no-image.jpg')) }}" 
                 class="img-fluid rounded shadow" 
                 alt="Ảnh tour">
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-3">
                <h4 class="text-secondary mb-3">Thông tin tour</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Mã tour:</strong> {{ $tour['id'] ?? '---' }}</li>
                    <li class="list-group-item"><strong>Giá tour:</strong> {{ number_format($tour['gia'] ?? 0, 0, ',', '.') }} đ</li>
                    <li class="list-group-item"><strong>Thời gian:</strong> {{ $tour['thoiGian'] ?? '---' }}</li>
                    <li class="list-group-item"><strong>Điểm khởi hành:</strong> {{ $tour['diemKhoiHanh'] ?? '---' }}</li>
                    <li class="list-group-item"><strong>Điểm đến:</strong> {{ $tour['diemDen'] ?? '---' }}</li>
                    <li class="list-group-item"><strong>Phương tiện:</strong> {{ $tour['phuongTien'] ?? '---' }}</li>
                </ul>

                <div class="mt-4 text-center">
                    <button class="btn btn-success btn-lg px-4 py-2" disabled>
                        <i class="bi bi-ticket-perforated"></i> Đặt vé (sắp có)
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Nhà tổ chức --}}
    @if($nhaToChuc)
    <div class="card my-5 border-0 shadow-sm">
        <div class="card-body">
            <h4 class="text-primary mb-3">Nhà tổ chức</h4>
            <p><strong>Tên:</strong> {{ $nhaToChuc['ten'] ?? '' }}</p>
            <p><strong>Email:</strong> {{ $nhaToChuc['email'] ?? '' }}</p>
            <p><strong>Số điện thoại:</strong> {{ $nhaToChuc['sdt'] ?? '' }}</p>
            <p><strong>Địa chỉ:</strong> {{ $nhaToChuc['diaChi'] ?? '' }}</p>
            <p><strong>Mô tả:</strong> {{ $nhaToChuc['moTa'] ?? '' }}</p>
        </div>
    </div>
    @endif

    {{-- Đánh giá --}}
    <div class="card mb-5 border-0 shadow-sm">
        <div class="card-body">
            <h4 class="text-primary mb-3">Đánh giá của khách hàng</h4>

            @if(!empty($danhGiaList))
                @foreach($danhGiaList as $dg)
                    <div class="border-bottom mb-3 pb-2">
                        <p class="mb-1"><strong>{{ $dg['khachHangEmail'] }}</strong> 
                            <span class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $dg['diemDanhGia']) ★ @else ☆ @endif
                                @endfor
                            </span>
                        </p>
                        <p class="mb-0">{{ $dg['binhLuan'] }}</p>
                        <small class="text-muted">{{ $dg['ngayDanhGia'] ?? '' }}</small>
                    </div>
                @endforeach
            @else
                <p class="text-muted fst-italic">Chưa có đánh giá nào cho tour này.</p>
            @endif
        </div>
    </div>
</div>
@endsection
