@extends('layouts.admin')

@section('title', 'Sửa người dùng')

@section('content')
<div class="container">
    <h2 class="mb-4">Sửa người dùng: {{ $user['email'] }}</h2>

    <form action="{{ route('admin.updateUser', $user['email']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Tên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user['name']) }}" required>
        </div>

        <div class="mb-3">
            <label>Email (không đổi)</label>
            <input type="text" class="form-control" value="{{ $user['email'] }}" disabled>
        </div>

        <div class="mb-3">
            <label>Vai trò</label>
            <select name="role" class="form-control">
                <option value="user" {{ $user['role'] == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user['role'] == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Mật khẩu (nếu muốn đổi)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
