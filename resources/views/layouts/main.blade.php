<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelGo - Trang chủ</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            color: #333;
        }

        /* Navbar */
        .navbar {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Banner */
        .banner {
            position: relative;
            height: 420px;
            border-radius: 16px;
            background: url('{{ asset("images/banner.jpg") }}') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-top: 80px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        }

        .banner::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.4);
        }

        .banner h1 {
            position: relative;
            color: #fff;
            font-size: 3rem;
            z-index: 2;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.5);
        }

        /* Tour card */
        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.25s ease-in-out;
            background-color: #fff;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.1);
        }

        .card img {
            height: 220px;
            object-fit: cover;
        }

        .card-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: #0d6efd;
        }

        .price {
            color: #e63946;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .card-text {
            height: 48px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        footer {
            background-color: #212529;
            color: white;
            text-align: center;
            padding: 25px 0;
            margin-top: 60px;
        }

        .btn-tour {
            border-radius: 30px;
            transition: 0.3s;
        }

        .btn-tour:hover {
            background-color: #0d6efd;
            color: white !important;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">TravelGo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tour</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
                </ul>

                <ul class="navbar-nav ms-3">
                    @if(session('loggedIn') && session('user'))
                        <li class="nav-item d-flex align-items-center text-white me-3">
                            <span>Xin chào, <strong>{{ session('user')['name'] ?? 'Người dùng' }}</strong></span>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="btn btn-light btn-sm">Đăng xuất</a>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a href="{{ route('login') }}" class="btn btn-light btn-sm">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Đăng ký</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Banner -->
    <div class="container">
        <div class="banner mb-5">
            <h1>Khám phá thế giới cùng TravelGo</h1>
        </div>

        <!-- Danh sách tour nổi bật -->
        <h2 class="text-center text-primary mb-4">Tour nổi bật</h2>
        <div class="row">
            @foreach ($tours as $tour)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="{{ asset('images/' . $tour['hinhAnh']) }}" alt="{{ $tour['tenTour'] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $tour['tenTour'] }}</h5>
                            <p class="card-text text-muted">{{ $tour['moTa'] }}</p>
                            <p class="price">{{ number_format($tour['gia'], 0, ',', '.') }}₫</p>
                            <a href="/tours/{{ $tour['id'] }}" class="btn btn-outline-primary w-100 btn-tour">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>© 2025 TravelGo. Tất cả bản quyền được bảo lưu.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
