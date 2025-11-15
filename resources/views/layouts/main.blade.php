<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TravelGo')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            color: #333;
        }

        .navbar {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .nav-link.active {
            font-weight: 600;
            border-bottom: 2px solid #fff;
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

    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">TravelGo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tour</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Liên hệ</a>
                    </li>

                    @if(session('loggedIn') && session('user'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.tours') }}">
                                <i class="bi bi-suitcase2-fill me-1"></i> Tour đã đặt
                            </a>
                        </li>
                    @endif
                </ul>

                <ul class="navbar-nav ms-3 align-items-center">
                    @php
                        $user = session('user', null);
                        $role = $user['role'] ?? null;
                        $name = $user['name'] ?? 'Người dùng';
                    @endphp

                    @if($user)
                        <li class="nav-item text-white me-3">
                            <span>Xin chào, <strong>{{ $name }}</strong></span>
                        </li>

                        <li class="nav-item me-2">
                            <a href="{{ route('main.info') }}" class="btn btn-info btn-sm">
                                <i class="bi bi-person-fill"></i> Thông tin cá nhân
                            </a>
                        </li>

                        @if($role === 'admin')
                            <li class="nav-item me-2">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-gear-fill"></i> Quản trị
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="btn btn-light btn-sm">
                                <i class="bi bi-box-arrow-right"></i> Đăng xuất
                            </a>
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

    <main class="container" style="margin-top: 90px;">
        @yield('content')
    </main>

    <footer>
        <p>© 2025 TravelGo. Tất cả bản quyền được bảo lưu.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
