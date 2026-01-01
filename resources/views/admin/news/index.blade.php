@extends('admin.layouts.app')

@section('title', 'Quản lý tin tức')

@section('content')
<div class="page-header">
    <h1 class="page-title">Quản lý tin tức</h1>
    <a href="{{ route('admin.news.create') }}" class="btn btn-pink">
        <i class="fas fa-plus me-1"></i> Thêm tin tức mới
    </a>
</div>

<!-- Search & Filter -->
<div class="card">
    <div class="card-body py-3">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Tiêu đề tin tức..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Công khai" {{ request('status') == 'Công khai' ? 'selected' : '' }}>Công khai</option>
                    <option value="Bản nháp" {{ request('status') == 'Bản nháp' ? 'selected' : '' }}>Bản nháp</option>
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

<!-- News Table -->
<div class="card">
    <div class="card-header">
        <span>Danh sách tin tức</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th style="width: 60px;">Hình Ảnh</th>
                        <th>Tiêu Đề</th>
                        <th style="width: 90px;">Trạng Thái</th>
                        <th style="width: 100px;">Ngày Đăng</th>
                        <th style="width: 110px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                @if($item->hinhanh)
                                    <img src="/storage/uploads/{{ $item->hinhanh }}" alt="{{ $item->tieude }}" class="product-img">
                                @else
                                    <div class="product-img-placeholder">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $item->tieude }}</td>
                            <td>
                                @php
                                    $badgeClass = match($item->trangthai) {
                                        'Công khai' => 'bg-success',
                                        'Bản nháp' => 'bg-warning text-dark',
                                        'Ẩn' => 'bg-secondary',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ $item->trangthai }}
                                </span>
                            </td>
                            <td>{{ $item->ngaydang ? \Carbon\Carbon::parse($item->ngaydang)->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-action-edit" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('news.show', $item->id) }}" class="btn btn-action-view" target="_blank" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="d-inline" data-confirm="Bạn có chắc muốn xóa tin tức này?">
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
                            <td colspan="6" class="text-center py-4 text-muted">Không có tin tức nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(method_exists($news, 'hasPages') && $news->hasPages())
        <div class="card-footer bg-white">
            {{ $news->withQueryString()->links('vendor.pagination.admin') }}
        </div>
    @endif
</div>
@endsection
