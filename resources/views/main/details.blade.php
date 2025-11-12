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
            </div>
        </div>
    </div>

    {{-- Form đặt tour --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Đặt tour ngay</h5>
            <form action="{{ route('tour.dat') }}" method="POST">
                @csrf
                <input type="hidden" name="tourId" value="{{ $tour['id'] }}">

                <div class="mb-3">
                    <label class="form-label">Email khách hàng</label>
                    <input type="email" name="khachHangEmail" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số người</label>
                    <input type="number" name="soNguoi" class="form-control" min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày khởi hành</label>
                    <input type="date" name="ngayKhoiHanh" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Đặt tour</button>
            </form>
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

    {{-- Danh giá --}}
    <div class="card mb-5 border-0 shadow-sm">
        <div class="card-body">
            <h4 class="text-primary mb-3">Đánh giá của khách hàng</h4>

            @if(!empty($danhGiaList))
                @foreach($danhGiaList as $dg)
                    <div class="border-bottom mb-3 pb-2">
                        <p class="mb-1 fw-semibold">
                            {{ $dg['nguoiDanhGia']['ten'] ?? $dg['nguoiDanhGia']['email'] ?? 'Ẩn danh' }}
                            <span class="text-warning ms-2">
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

    {{-- Form thêm đánh giá --}}
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body">
            <h4 class="text-primary mb-3">Viết đánh giá của bạn</h4>
            <form id="reviewForm">
                <div class="mb-3">
                    <label class="form-label">Email của bạn</label>
                    <input type="email" class="form-control" id="email" placeholder="Nhập email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Điểm đánh giá (1 - 5)</label>
                    <input type="number" class="form-control" id="diemDanhGia" min="1" max="5" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bình luận</label>
                    <textarea class="form-control" id="binhLuan" rows="3" placeholder="Chia sẻ cảm nhận của bạn..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
            </form>

            <div id="reviewMessage" class="mt-3"></div>
        </div>
    </div>
</div>

{{-- AJAX gửi đánh giá --}}
<script>
document.getElementById('reviewForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const diem = document.getElementById('diemDanhGia').value;
    const binhLuan = document.getElementById('binhLuan').value;

    const response = await fetch("http://localhost:8080/api/tour/{{ $tour['id'] }}/danhgia", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            email: email,
            diemDanhGia: Number(diem),
            binhLuan: binhLuan
        })
    });

    const data = await response.json();
    const msgBox = document.getElementById('reviewMessage');
    msgBox.innerHTML = `<div class="alert alert-${response.ok ? 'success' : 'danger'}">${data.message || 'Đã xảy ra lỗi'}</div>`;

    if (response.ok) {
        document.getElementById('reviewForm').reset();
        setTimeout(() => location.reload(), 1000);
    }
});
</script>
@endsection
