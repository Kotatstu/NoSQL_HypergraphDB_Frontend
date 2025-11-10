<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelGo - Khám phá hành trình của bạn</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: #0d6efd;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
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
        .tour-card img {
            height: 200px;
            object-fit: cover;
            border-radius: 0.5rem 0.5rem 0 0;
        }
        .footer {
            background: #0d6efd;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
        }
        .search-box {
            margin-top: -40px;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">TravelGo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="/">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tour</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
                </ul>
            </div>
        </div>
    </nav>

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
            <div class="col-md-4">
                <input type="text" name="from" class="form-control" placeholder="Điểm khởi hành">
            </div>
            <div class="col-md-4">
                <input type="text" name="to" class="form-control" placeholder="Điểm đến">
            </div>
            <div class="col-md-3">
                <input type="date" name="date" class="form-control">
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
                        <img src="{{ $tour['anhDaiDien'] ?? 'https://placehold.co/400x200' }}" 
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

    <!-- Footer -->
    <div class="footer">
        &copy; 2025 TravelGo. All rights reserved.
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
