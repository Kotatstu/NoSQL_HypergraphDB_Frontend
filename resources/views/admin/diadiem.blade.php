@extends('layouts.admin')

@section('title', 'Danh sách Địa điểm')

@section('content')
<div class="container">
    <h2 class="mb-4">Danh sách Địa điểm</h2>

    @if ($error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    <div class="card">
        <div class="card-body">

            <!-- Nút thêm -->
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.createDiaDiem') }}" class="btn btn-success">+ Thêm Địa Điểm</a>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên địa điểm</th>
                        <th>Mô tả</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($diadiem as $item)
                        <tr>
                            <td>{{ $item['id'] ?? '—' }}</td>
                            <td>{{ $item['tenDiaDiem'] ?? 'Chưa có tên' }}</td>
                            <td>{{ $item['moTa'] ?? '—' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.editDiaDiem', $item['id']) }}" class="btn btn-sm btn-primary">Sửa</a>
                                    <!-- Thêm nút xóa với confirm -->
                                    <form action="{{ route('admin.deleteDiaDiem', $item['id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa địa điểm này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Chưa có địa điểm nào</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
