@extends('admin.layouts.app')

@section('title', $user ? 'Sửa người dùng' : 'Thêm người dùng')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $user ? 'Sửa người dùng' : 'Thêm người dùng' }}</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Quay lại
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $user ? route('admin.users.update', $user->id) : route('admin.users.store') }}" enctype="multipart/form-data">
            @csrf
            @if($user) @method('PUT') @endif

            <div class="row">
                <!-- Cột trái: Thông tin cơ bản -->
                <div class="col-lg-6">
                    <h6 class="text-muted mb-3"><i class="fas fa-user me-1"></i> Thông tin cơ bản</h6>
                    
                    <div class="mb-3">
                        <label for="hoten" class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('hoten') is-invalid @enderror" id="hoten" name="hoten" value="{{ old('hoten', $user->hoten ?? '') }}" required placeholder="Nhập họ tên">
                        @error('hoten')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required placeholder="example@email.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="sdt" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('sdt') is-invalid @enderror" id="sdt" name="sdt" value="{{ old('sdt', $user->sdt ?? '') }}" required placeholder="0123 456 789">
                        @error('sdt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu {{ $user ? '' : '<span class="text-danger">*</span>' }}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" {{ $user ? '' : 'required' }} placeholder="{{ $user ? 'Để trống nếu không đổi' : 'Nhập mật khẩu' }}">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Cột phải: Quyền & Trạng thái -->
                <div class="col-lg-6">
                    <h6 class="text-muted mb-3"><i class="fas fa-shield-alt me-1"></i> Quyền & Trạng thái</h6>
                    
                    @if($user && $user->avatar)
                        <div class="text-center mb-3">
                            <img src="{{ asset('storage/uploads/' . $user->avatar) }}" class="rounded-circle border" style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="is_admin" class="form-label">Vai trò</label>
                        @if(Auth::user()->isAdmin() && (!$user || Auth::id() != $user->id))
                            <select class="form-select @error('is_admin') is-invalid @enderror" id="is_admin" name="is_admin">
                                <option value="0" {{ old('is_admin', $user->is_admin ?? 0) == 0 ? 'selected' : '' }}>👤 Khách hàng</option>
                                <option value="2" {{ old('is_admin', $user->is_admin ?? 0) == 2 ? 'selected' : '' }}>👨‍💼 Nhân viên</option>
                                <option value="1" {{ old('is_admin', $user->is_admin ?? 0) == 1 ? 'selected' : '' }}>🛡️ Admin</option>
                            </select>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Admin: full quyền | Nhân viên: xem, thêm, sửa | Khách: không truy cập admin
                            </small>
                        @else
                            @php
                                $roleClass = match($user->is_admin ?? 0) {
                                    1 => 'bg-danger',
                                    2 => 'bg-warning text-dark',
                                    default => 'bg-info',
                                };
                                $roleName = match($user->is_admin ?? 0) {
                                    1 => 'Admin',
                                    2 => 'Nhân viên',
                                    default => 'Khách hàng',
                                };
                            @endphp
                            <div>
                                <span class="badge {{ $roleClass }} fs-6">{{ $roleName }}</span>
                                <small class="text-muted d-block mt-1">Không thể thay đổi vai trò của chính mình</small>
                            </div>
                            <input type="hidden" name="is_admin" value="{{ $user->is_admin ?? 0 }}">
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <label for="trangthai" class="form-label">Trạng thái</label>
                        <select class="form-select" id="trangthai" name="trangthai">
                            <option value="Hoạt động" {{ old('trangthai', $user->trangthai ?? 'Hoạt động') == 'Hoạt động' ? 'selected' : '' }}>✅ Hoạt động</option>
                            <option value="Khóa" {{ old('trangthai', $user->trangthai ?? '') == 'Khóa' ? 'selected' : '' }}>🔒 Khóa</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Ảnh đại diện</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                        <small class="text-muted">Định dạng: JPG, PNG. Tối đa 2MB</small>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i> Hủy
                </a>
                <button type="submit" class="btn btn-pink">
                    <i class="fas fa-save me-1"></i> {{ $user ? 'Cập nhật' : 'Thêm mới' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

