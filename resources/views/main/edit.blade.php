@extends('layouts.main')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Cập nhật thông tin cá nhân</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card p-4">
        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Họ tên</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $userInfo['name'] ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $userInfo['email'] ?? '') }}" required>
            </div>

            <button type="submit" class="btn btn-success">Cập nhật</button>
            <a href="{{ route('main.info') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection
