<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập tài khoản</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            background: linear-gradient(135deg, #6f86d6, #48c6ef);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.6s ease;
        }

        .auth-card h3 {
            font-weight: 700;
            color: #333;
        }

        .form-control {
            border-radius: 12px;
        }

        .btn-auth {
            background: linear-gradient(135deg, #6f86d6, #48c6ef);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-auth:hover {
            transform: scale(1.03);
            background: linear-gradient(135deg, #5e73c2, #3eb3d6);
        }

        .icon {
            width: 20px;
            height: 20px;
            margin-right: 8px;
            color: #6f86d6;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .text-small {
            font-size: 0.9rem;
        }

        .password-toggle {
            cursor: pointer;
        }

        .text-error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 4px;
        }
    </style>
</head>

<body>
<div class="auth-card">
    <div class="text-center mb-4">
        <i data-lucide="log-in" style="width:40px; height:40px; color:#6f86d6;"></i>
        <h3>Đăng nhập</h3>
        <p class="text-muted">Chào mừng bạn trở lại</p>
    </div>

    {{-- Hiện thông báo thành công / lỗi --}}
    @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger py-2">{{ session('error') }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i data-lucide="mail"></i>
                </span>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control border-start-0" placeholder="Nhập email của bạn" required>
            </div>
            @error('email')
                <div class="text-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Mật khẩu --}}
        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i data-lucide="lock"></i>
                </span>
                <input type="password" name="password" id="password" class="form-control border-start-0" placeholder="Nhập mật khẩu" required>
                <span class="input-group-text bg-white password-toggle" id="togglePassword">
                    <i data-lucide="eye-off"></i>
                </span>
            </div>
            @error('password')
                <div class="text-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nút đăng nhập --}}
        <button type="submit" class="btn btn-auth w-100 mt-3">
            <i data-lucide="log-in"></i> Đăng nhập
        </button>

        {{-- Link đăng ký --}}
        <div class="text-center mt-3 text-small">
            <span>Chưa có tài khoản?</span>
            <a href="{{ route('register.post') }}" class="fw-semibold text-decoration-none">Đăng ký ngay</a>
        </div>
    </form>
</div>

<script>
    lucide.createIcons();

    // Toggle hiển thị mật khẩu
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').setAttribute('data-lucide', type === 'password' ? 'eye-off' : 'eye');
        lucide.createIcons();
    });
</script>
</body>
</html>
