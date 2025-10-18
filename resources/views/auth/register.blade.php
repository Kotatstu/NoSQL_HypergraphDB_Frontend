<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            background: linear-gradient(135deg, #48c6ef, #6f86d6);
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

        .btn-auth {
            background: linear-gradient(135deg, #48c6ef, #6f86d6);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-auth:hover {
            transform: scale(1.03);
            background: linear-gradient(135deg, #3eb3d6, #5e73c2);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .password-toggle { cursor: pointer; }
        .text-error { color: #dc3545; font-size: 0.875rem; margin-top: 4px; }
    </style>
</head>

<body>
<div class="auth-card">
    <div class="text-center mb-4">
        <i data-lucide="user-plus" style="width:40px; height:40px; color:#6f86d6;"></i>
        <h3>Tạo tài khoản</h3>
        <p class="text-muted">Điền thông tin của bạn để bắt đầu</p>
    </div>

    {{-- Hiện thông báo lỗi hoặc thành công --}}
    @if(session('error'))
        <div class="alert alert-danger py-2">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        {{-- Họ tên --}}
        <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i data-lucide="user"></i>
                </span>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control border-start-0" placeholder="Nhập họ tên" required>
            </div>
            @error('name')
                <div class="text-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i data-lucide="mail"></i>
                </span>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control border-start-0" placeholder="Nhập email" required>
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
                <span class="input-group-text bg-white password-toggle" onclick="togglePassword('password', 'togglePassword1')">
                    <i id="togglePassword1" data-lucide="eye-off"></i>
                </span>
            </div>
            @error('password')
                <div class="text-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Xác nhận mật khẩu --}}
        <div class="mb-3">
            <label class="form-label">Xác nhận mật khẩu</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i data-lucide="lock"></i>
                </span>
                <input type="password" name="password_confirmation" id="confirm_password" class="form-control border-start-0" placeholder="Nhập lại mật khẩu" required>
                <span class="input-group-text bg-white password-toggle" onclick="togglePassword('confirm_password', 'togglePassword2')">
                    <i id="togglePassword2" data-lucide="eye-off"></i>
                </span>
            </div>
            {{-- Lỗi xác nhận mật khẩu --}}
            @if($errors->has('password'))
                <div class="text-error">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <button type="submit" class="btn btn-auth w-100 mt-3">
            <i data-lucide="user-plus"></i> Đăng ký
        </button>

        <div class="text-center mt-3">
            <span>Đã có tài khoản?</span>
            <a href="{{ route('login.post') }}" class="fw-semibold text-decoration-none">Đăng nhập</a>
        </div>
    </form>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === "password") {
            input.type = "text";
            icon.setAttribute("data-lucide", "eye");
        } else {
            input.type = "password";
            icon.setAttribute("data-lucide", "eye-off");
        }
        lucide.createIcons();
    }

    lucide.createIcons();
</script>
</body>
</html>
