@extends('layouts.admin')

@section('title', 'Danh sách Hóa đơn')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-start">Danh sách Hóa đơn</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Hóa Đơn</th>
                        <th>ID Đặt Tour</th>
                        <th>Tổng Tiền</th>
                        <th>Phương Thức Thanh Toán</th>
                        <th>Trạng Thái Thanh Toán</th>
                        <th>Chỉnh Sửa</th>
                        <th>Xóa</th> <!-- Thêm cột Xóa -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hoadon as $hoaDon)
                        <tr>
                            <td>{{ $hoaDon['id'] }}</td>
                            <td>{{ $hoaDon['datTourId'] }}</td>
                            <td>{{ number_format($hoaDon['tongTien'], 0, ',', '.') }} VND</td>
                            <td>{{ $hoaDon['phuongThucThanhToan'] }}</td>
                            <td>
                                @if ($hoaDon['trangThaiThanhToan'] == 'Paid')
                                    <span class="badge bg-success">Đã thanh toán</span>
                                @elseif ($hoaDon['trangThaiThanhToan'] == 'Unpaid')
                                    <span class="badge bg-warning">Chưa thanh toán</span>
                                @else
                                    <span class="badge bg-danger">Đã hủy</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.editHoaDon', $hoaDon['id']) }}" class="btn btn-primary">Chỉnh sửa</a>
                            </td>
                            <!-- Thêm nút Xóa -->
                            <td>
                                <form action="{{ route('admin.deleteHoaDon', $hoaDon['id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa hóa đơn này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
