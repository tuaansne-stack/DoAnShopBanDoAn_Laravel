@extends('admin.layouts.app')

@section('title', 'Quản lý giới thiệu')

@section('content')
<div class="page-header">
    <h1 class="page-title">Quản lý giới thiệu</h1>
    <a href="{{ route('admin.about.create') }}" class="btn btn-pink">
        <i class="fas fa-plus me-1"></i> Thêm mục mới
    </a>
</div>

<!-- Search & Filter -->
<div class="card">
    <div class="card-body py-3">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Tiêu đề..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Hiện" {{ request('status') == 'Hiện' ? 'selected' : '' }}>Hiện</option>
                    <option value="Ẩn" {{ request('status') == 'Ẩn' ? 'selected' : '' }}>Ẩn</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-pink w-100">
                    <i class="fas fa-search me-1"></i> Tìm kiếm
                </button>
            </div>
        </form>
    </div>
</div>

<!-- About Table -->
<div class="card">
    <div class="card-header">
        <span>Danh sách mục giới thiệu</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th style="width: 70px;">Hình Ảnh</th>
                        <th>Tiêu Đề</th>
                        <th style="width: 80px;">Thứ Tự</th>
                        <th style="width: 100px;">Trạng Thái</th>
                        <th style="width: 120px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($abouts as $about)
                        <tr>
                            <td>{{ $about->id }}</td>
                            <td>
                                @if($about->hinhanh)
                                    <img src="/storage/uploads/{{ $about->hinhanh }}" alt="{{ $about->tieude }}" class="product-img">
                                @else
                                    <div class="product-img-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $about->tieude }}</td>
                            <td>{{ $about->thutu }}</td>
                            <td>
                                <span class="badge {{ $about->trangthai == 'Hiện' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $about->trangthai }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.about.edit', $about->id) }}" class="btn btn-action-edit" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.about.destroy', $about->id) }}" method="POST" class="d-inline" data-confirm="Bạn có chắc muốn xóa nội dung này?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-action-delete" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Không có mục giới thiệu nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(method_exists($abouts, 'hasPages') && $abouts->hasPages())
        <div class="card-footer bg-white">
            {{ $abouts->withQueryString()->links('vendor.pagination.admin') }}
        </div>
    @endif
</div>
@endsection
