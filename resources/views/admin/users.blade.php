@extends('layouts.admin')

@section('title', 'Danh sách người dùng')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Danh sách người dùng</h2>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $user['name'] ?? 'Chưa có tên' }}</td>
                        <td>{{ $user['email'] ?? 'Chưa có email' }}</td>
                        <td>{{ $user['role'] ?? 'Chưa có vai trò' }}</td>

                        <td class="text-center">
                            <a href="{{ route('admin.editUser', $user['email']) }}" class="btn btn-sm btn-primary">Sửa</a>
                            <form action="{{ route('admin.deleteUser', $user['email']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Chưa có người dùng nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
