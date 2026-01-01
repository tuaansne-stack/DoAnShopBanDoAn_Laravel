@extends('admin.layouts.app')

@section('title', 'Quản lý danh mục')

@section('content')
<div class="page-header">
    <h1 class="page-title">Quản lý danh mục</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-pink">
        <i class="fas fa-plus me-1"></i> Thêm danh mục mới
    </a>
</div>

<div class="card">
    <div class="card-header">
        <span>Danh sách danh mục</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Tên danh mục</th>
                        <th style="width: 120px;">Số món ăn</th>
                        <th style="width: 140px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td><strong>{{ $category->ten_danhmuc }}</strong></td>
                            <td>
                                <span class="badge bg-pink">{{ $category->products_count ?? 0 }} món</span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-action-edit" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" data-confirm="Bạn có chắc muốn xóa danh mục này?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-action-delete" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-action-view" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="fas fa-folder-open fa-2x mb-2"></i>
                                <p class="mb-0">Chưa có danh mục nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($categories->hasPages())
        <div class="card-footer bg-white">
            {{ $categories->links('vendor.pagination.admin') }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .badge.bg-pink {
        background: linear-gradient(135deg, #ff69b4, #ff1493);
        color: #fff;
        font-weight: 500;
        padding: 5px 12px;
        border-radius: 20px;
    }
</style>
@endpush
