@extends('layouts.main')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Thông tin cá nhân</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card p-4">
        <p><strong>Họ tên:</strong> {{ $userInfo['name'] ?? 'Chưa có thông tin' }}</p>
        <p><strong>Email:</strong> {{ $userInfo['email'] ?? 'Chưa có thông tin' }}</p>

        <a href="{{ route('main.edit') }}" class="btn btn-primary mt-3">Chỉnh sửa thông tin</a>
    </div>
</div>
@endsection
