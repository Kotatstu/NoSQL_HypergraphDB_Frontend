<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang quản trị')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('styles')

    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            color: #212529;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            background-color: #0d6efd !important;
        }

        .navbar-brand, .nav-link {
            color: #ffffff !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #dceeff !important;
        }

        /* Main content */
        main {
            flex: 1; /* chiếm không gian còn lại */
        }

        /* Footer */
        footer {
            background-color: #f8f9fa;
            color: #495057;
            border-top: 1px solid #dee2e6;
            padding: 1rem 0;
        }

        footer span {
            color: #0d6efd;
            font-weight: 600;
        }

        .lucide-icon {
            width: 20px;
            height: 20px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <i data-lucide="layout-dashboard" class="lucide-icon"></i>
                Admin Panel
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-1" href="{{ route('home') }}">
                            <i data-lucide="home"></i> Trang chủ
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="py-4 container">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center">
        © 2025 - Hệ thống đặt tour du lịch | <span>Laravel Framework</span>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>

    @stack('scripts')
</body>
</html>
