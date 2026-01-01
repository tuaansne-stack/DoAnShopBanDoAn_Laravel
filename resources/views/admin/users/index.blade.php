@extends('admin.layouts.app')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="page-header">
    <h1 class="page-title">Quản lý người dùng</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-pink">
        <i class="fas fa-plus me-1"></i> Thêm mới
    </a>
</div>

<!-- Search & Filter -->
<div class="card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-4">
                <label class="form-label small">Tìm kiếm</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Họ tên, email, SĐT..." value="{{ request('search') }}">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small">Trạng thái</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Tất cả</option>
                    <option value="Hoạt động" {{ request('status') == 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="Khóa" {{ request('status') == 'Khóa' ? 'selected' : '' }}>Khóa</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small">Vai trò</label>
                <select name="role" class="form-select form-select-sm">
                    <option value="">Tất cả</option>
                    <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Admin</option>
                    <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Nhân viên</option>
                    <option value="0" {{ request('role') == '0' ? 'selected' : '' }}>Khách hàng</option>
                </select>
            </div>
            <div class="col-12 col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-pink btn-sm flex-grow-1">
                    <i class="fas fa-search me-1"></i> Tìm
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Users List -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-users me-2"></i>Danh sách người dùng</span>
        <span class="badge bg-pink">{{ $users->total() ?? $users->count() }} người dùng</span>
    </div>
    <div class="card-body p-0">
        <!-- Desktop Table -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Họ Tên</th>
                        <th>Email</th>
                        <th style="width: 120px;">SĐT</th>
                        <th style="width: 130px;">Vai trò</th>
                        <th style="width: 100px;">Trạng Thái</th>
                        <th style="width: 100px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="text-muted">{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/uploads/' . $user->avatar) }}" class="rounded-circle me-2" style="width: 35px; height: 35px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 14px; background: linear-gradient(135deg, #e91e63, #c2185b); color: #fff;">
                                            {{ strtoupper(substr($user->hoten, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-medium">{{ $user->hoten }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-muted small">{{ $user->email }}</td>
                            <td class="small">{{ $user->sdt }}</td>
                            <td>
                                @php
                                    $roleClass = match($user->is_admin) {
                                        1 => 'bg-danger',
                                        2 => 'bg-warning text-dark',
                                        default => 'bg-info',
                                    };
                                @endphp
                                <span class="badge {{ $roleClass }}">{{ $user->getRoleName() }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $user->trangthai == 'Hoạt động' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $user->trangthai }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-action-edit" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(Auth::id() != $user->id)
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" data-confirm="Bạn có chắc muốn xóa người dùng này?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-action-delete" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                Không có người dùng nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="d-md-none">
            @forelse($users as $user)
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-start mb-2">
                        @if($user->avatar)
                            <img src="{{ asset('storage/uploads/' . $user->avatar) }}" class="rounded-circle me-3 border shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; font-size: 18px; font-weight: 600; background: linear-gradient(135deg, #e91e63, #c2185b); color: #fff;">
                                {{ strtoupper(substr($user->hoten, 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">{{ $user->hoten }}</div>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                                @php
                                    $roleClass = match($user->is_admin) {
                                        1 => 'bg-danger',
                                        2 => 'bg-warning text-dark',
                                        default => 'bg-info',
                                    };
                                @endphp
                                <span class="badge {{ $roleClass }}">{{ $user->getRoleName() }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="small">
                                    <span class="badge {{ $user->trangthai == 'Hoạt động' ? 'bg-success' : 'bg-secondary' }}">{{ $user->trangthai }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="text-muted small me-3"><i class="fas fa-phone me-1"></i>{{ $user->sdt }}</span>
                                    <div class="action-btns">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-action-edit" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(Auth::id() != $user->id)
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" data-confirm="Bạn có chắc muốn xóa người dùng này?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-action-delete" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-users fa-2x mb-2 d-block"></i>
                    Không có người dùng nào.
                </div>
            @endforelse
        </div>
    </div>
    @if(method_exists($users, 'hasPages') && $users->hasPages())
        <div class="card-footer bg-white">
            {{ $users->withQueryString()->links('vendor.pagination.admin') }}
        </div>
    @endif
</div>
@endsection

