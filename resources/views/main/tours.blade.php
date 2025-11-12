@extends('layouts.main')

@section('title', 'Tour đã đặt của tôi')

@section('content')
<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Tour đã đặt của {{ $user['name'] ?? 'Người dùng' }}</h2>
        <p class="text-muted">Email: {{ $user['email'] }}</p>
    </div>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    {{-- Danh sách tour --}}
    @if(!empty($tours))
        <div class="row">
            @foreach($tours as $tour)
                @php $status = strtolower($tour['trangThai']); @endphp

                <div class="col-md-4 mb-4">
                    <div class="card shadow border-0 h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary fw-bold">Mã tour: {{ $tour['tourId'] }}</h5>
                            <p><strong>Số người:</strong> {{ $tour['soNguoi'] }}</p>
                            <p><strong>Ngày đặt:</strong> {{ $tour['ngayDat'] }}</p>
                            <p><strong>Ngày khởi hành:</strong> {{ $tour['ngayKhoiHanh'] }}</p>
                            <p class="mb-3">
                                <strong>Trạng thái:</strong>
                                @if($status === 'paid')
                                    <span class="badge bg-success">Đã thanh toán</span>
                                @elseif($status === 'pending')
                                    <span class="badge bg-warning text-dark">Chờ thanh toán</span>
                                @elseif($status === 'cancelled')
                                    <span class="badge bg-danger">Đã hủy</span>
                                @else
                                    <span class="badge bg-secondary">Không xác định</span>
                                @endif
                            </p>

                            {{-- Nút thao tác --}}
                            @if($status === 'pending')
                                <div class="mt-auto d-flex justify-content-between">
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#payModal{{ $tour['id'] }}">
                                        <i class="bi bi-wallet2"></i> Thanh toán
                                    </button>

                                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $tour['id'] }}">
                                        <i class="bi bi-x-circle"></i> Hủy
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Modal Thanh toán --}}
                <div class="modal fade" id="payModal{{ $tour['id'] }}" tabindex="-1" aria-labelledby="payModalLabel{{ $tour['id'] }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="payModalLabel{{ $tour['id'] }}">
                                    <i class="bi bi-credit-card"></i> Xác nhận thanh toán
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Bạn muốn thanh toán tour <strong>{{ $tour['tourId'] }}</strong> bằng phương thức nào?</p>

                                <form method="POST" action="{{ route('user.tour.pay', $tour['id']) }}">
                                    @csrf
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="phuongThucThanhToan" id="momo{{ $tour['id'] }}" value="MoMo" checked>
                                        <label class="form-check-label" for="momo{{ $tour['id'] }}">
                                            <i class="bi bi-phone"></i> Ví MoMo
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="phuongThucThanhToan" id="card{{ $tour['id'] }}" value="Card">
                                        <label class="form-check-label" for="card{{ $tour['id'] }}">
                                            <i class="bi bi-credit-card-2-front"></i> Thẻ ngân hàng
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="phuongThucThanhToan" id="cash{{ $tour['id'] }}" value="Cash">
                                        <label class="form-check-label" for="cash{{ $tour['id'] }}">
                                            <i class="bi bi-cash-stack"></i> Tiền mặt
                                        </label>
                                    </div>
                                    <div class="mt-4 text-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Xác nhận thanh toán</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Hủy tour --}}
                <div class="modal fade" id="cancelModal{{ $tour['id'] }}" tabindex="-1" aria-labelledby="cancelModalLabel{{ $tour['id'] }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="cancelModalLabel{{ $tour['id'] }}">
                                    <i class="bi bi-exclamation-triangle"></i> Xác nhận hủy tour
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Bạn có chắc chắn muốn <strong class="text-danger">hủy tour {{ $tour['tourId'] }}</strong> không?<br>
                                Sau khi hủy, bạn sẽ không thể hoàn tác.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                                <form method="POST" action="{{ route('user.tour.cancel', $tour['id']) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center text-muted fs-5">
            <i class="bi bi-card-list"></i> Không có tour nào để hiển thị.
        </div>
    @endif
</div>
@endsection
