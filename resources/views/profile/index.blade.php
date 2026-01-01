@extends('layouts.app')

@section('title', 'Thông tin cá nhân')

@section('content')
<!-- Nội dung chính -->
<section class="profile-section py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <x-user-sidebar active="profile" />
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Thông tin cá nhân -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Thông tin cá nhân</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST" id="profileUpdateForm">
                            @csrf
                            <div class="mb-3">
                                <label for="hoten" class="form-label">Họ tên</label>
                                <input type="text" class="form-control @error('hoten') is-invalid @enderror" 
                                    id="hoten" name="hoten" value="{{ old('hoten', $user->hoten) }}" required>
                                @error('hoten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly disabled>
                                <div class="form-text">Email không thể thay đổi.</div>
                            </div>
                            <div class="mb-3">
                                <label for="sdt" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control @error('sdt') is-invalid @enderror" 
                                    id="sdt" name="sdt" value="{{ old('sdt', $user->sdt ?? '') }}">
                                @error('sdt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Cập nhật thông tin
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Đổi mật khẩu -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Đổi mật khẩu</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.password.update') }}" method="POST" id="changePasswordForm">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                    id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                    id="password" name="password" required>
                                <div class="form-text">Mật khẩu phải có ít nhất 6 ký tự.</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control" 
                                    id="password_confirmation" name="password_confirmation" required>
                            </div>
                            <button type="submit" name="change_password" class="btn btn-warning">
                                <i class="fas fa-key me-2"></i>Đổi mật khẩu
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Các thông tin khác -->
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Hoạt động gần đây</h5>
                    </div>
                    <div class="card-body">
                        <p>Không có hoạt động gần đây.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal thay đổi ảnh đại diện -->
<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avatarModalLabel">Thay đổi ảnh đại diện</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    <div class="text-center mb-4">
                        <!-- Hiển thị ảnh đại diện hiện tại hoặc ảnh mặc định -->
                        <div class="avatar-preview mb-3">
                            @if(!empty($user->avatar))
                                <img src="{{ asset('storage/uploads/' . $user->avatar) }}" 
                                    class="rounded-circle img-thumbnail" 
                                    style="width: 150px; height: 150px; object-fit: cover;" 
                                    alt="Avatar">
                            @else
                                <div class="avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto img-thumbnail" 
                                    style="width: 150px; height: 150px; font-size: 4rem;">
                                    {{ strtoupper(substr($user->hoten, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <!-- Input để chọn file ảnh -->
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Chọn ảnh mới</label>
                            <input class="form-control" type="file" id="avatar" name="avatar" accept="image/*" required>
                            <div class="form-text">Hỗ trợ các định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB.</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật ảnh đại diện</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.querySelector('.avatar-preview');

        if (avatarInput && avatarPreview) {
            avatarInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('rounded-circle', 'img-thumbnail');
                        img.style.width = '150px';
                        img.style.height = '150px';
                        img.style.objectFit = 'cover';

                        // Xóa nội dung hiện tại và thêm ảnh mới
                        avatarPreview.innerHTML = '';
                        avatarPreview.appendChild(img);
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });
</script>
@endpush
@endsection
