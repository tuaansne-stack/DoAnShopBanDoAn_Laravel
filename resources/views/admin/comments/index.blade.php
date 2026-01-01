@extends('admin.layouts.app')

@section('title', 'Quản lý bình luận')

@section('content')
<div class="page-header">
    <h1 class="page-title">Quản lý bình luận</h1>
</div>

<!-- Search & Filter -->
<div class="card">
    <div class="card-body py-3">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Nội dung, sản phẩm..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Chờ duyệt" {{ request('status') == 'Chờ duyệt' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="Đã duyệt" {{ request('status') == 'Đã duyệt' ? 'selected' : '' }}>Đã duyệt</option>
                    <option value="Bị ẩn" {{ request('status') == 'Bị ẩn' ? 'selected' : '' }}>Bị ẩn</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Đánh giá</label>
                <select name="rating" class="form-select">
                    <option value="">Tất cả đánh giá</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} sao</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-pink w-100">
                    <i class="fas fa-search me-1"></i> Tìm kiếm
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Comments Table -->
<div class="card">
    <div class="card-header">
        <span>Danh sách bình luận</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 40px;">ID</th>
                        <th style="width: 120px;">Sản Phẩm</th>
                        <th style="width: 130px;">Người Dùng</th>
                        <th>Nội Dung</th>
                        <th style="width: 90px;">Đánh Giá</th>
                        <th style="width: 80px;">Trạng Thái</th>
                        <th style="width: 90px;">Ngày Tạo</th>
                        <th style="width: 100px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->product->tenmon ?? 'N/A' }}</td>
                            <td>{{ $comment->user->hoten ?? 'N/A' }}</td>
                            <td style="max-width: 200px;">{{ Str::limit($comment->noidung, 50) }}</td>
                            <td style="white-space: nowrap;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $comment->danhgia ? 'text-warning' : 'text-muted' }}" style="font-size: 0.7rem;"></i>
                                @endfor
                            </td>
                            <td>
                                @php
                                    $statusClass = match($comment->trangthai) {
                                        'Chờ duyệt' => 'bg-warning text-dark',
                                        'Đã duyệt' => 'bg-success',
                                        'Bị ẩn' => 'bg-secondary',
                                        default => 'bg-warning text-dark'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $comment->trangthai }}</span>
                            </td>
                            <td>{{ $comment->ngaytao ? $comment->ngaytao->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                <div class="action-btns">
                                    @if($comment->trangthai != 'Đã duyệt')
                                        <form action="{{ route('admin.comments.status', $comment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Đã duyệt">
                                            <button type="submit" class="btn btn-action-view" title="Duyệt">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($comment->trangthai != 'Bị ẩn')
                                        <form action="{{ route('admin.comments.status', $comment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Bị ẩn">
                                            <button type="submit" class="btn btn-action-edit" title="Ẩn">
                                                <i class="fas fa-eye-slash"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="d-inline" data-confirm="Bạn có chắc muốn xóa bình luận này?">
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
                            <td colspan="8" class="text-center py-4 text-muted">Không có bình luận nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(method_exists($comments, 'hasPages') && $comments->hasPages())
        <div class="card-footer bg-white">
            {{ $comments->withQueryString()->links('vendor.pagination.admin') }}
        </div>
    @endif
</div>
@endsection
