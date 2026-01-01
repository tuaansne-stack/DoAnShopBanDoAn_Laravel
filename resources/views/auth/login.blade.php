@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-5">
            <div class="col-md-5 col-lg-4">

                <!-- Auth Card -->
                <div class="auth-card">
                    <div class="auth-card-header text-center">
                        <h4 class="mb-1">Chào mừng trở lại!</h4>
                        <p class="text-muted mb-0">Đăng nhập để tiếp tục mua sắm</p>
                    </div>
                    
                    <div class="auth-card-body">
                        @if($errors->any())
                            <div class="alert alert-danger py-2">
                                @foreach($errors->all() as $error)
                                    <div class="small">{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <!-- Email -->
                            <div class="auth-input-group">
                                <label for="email" class="auth-label">Email</label>
                                <div class="auth-input-wrapper">
                                    <i class="fas fa-envelope auth-input-icon"></i>
                                    <input type="email" class="auth-input @error('email') is-invalid @enderror" 
                                        id="email" name="email" required
                                        value="{{ old('email') }}" placeholder="example@email.com">
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="auth-input-group">
                                <div class="d-flex justify-content-between">
                                    <label for="password" class="auth-label">Mật khẩu</label>
                                </div>
                                <div class="auth-input-wrapper">
                                    <i class="fas fa-lock auth-input-icon"></i>
                                    <input type="password" class="auth-input @error('password') is-invalid @enderror" 
                                        id="password" name="password" required
                                        placeholder="••••••••">
                                    <button type="button" class="auth-toggle-password" onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="auth-input-group">
                                <label class="auth-checkbox">
                                    <input type="checkbox" name="remember">
                                    <span class="checkmark"></span>
                                    <span class="label-text">Ghi nhớ đăng nhập</span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="auth-submit-btn">
                                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                            </button>
                        </form>

                        <div class="auth-footer">
                            <p>Chưa có tài khoản? <a href="{{ route('register') }}" class="auth-link">Đăng ký ngay</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .auth-page {
        background: linear-gradient(135deg, #ffeef5 0%, #fff5f8 50%, #fff 100%);
        min-height: 100vh;
    }
    
    .auth-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(255, 92, 141, 0.1);
        overflow: hidden;
    }
    
    .auth-card-header {
        padding: 2rem 2rem 1rem;
    }
    
    .auth-card-header h4 {
        color: #333;
        font-weight: 600;
    }
    
    .auth-card-body {
        padding: 1rem 2rem 2rem;
    }
    
    .auth-input-group {
        margin-bottom: 1.25rem;
    }
    
    .auth-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #555;
        margin-bottom: 0.5rem;
    }
    
    .auth-input-wrapper {
        position: relative;
    }
    
    .auth-input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 0.9rem;
        transition: color 0.3s;
    }
    
    .auth-input {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 2.75rem;
        border: 2px solid #eee;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s;
        background: #fafafa;
    }
    
    .auth-input:focus {
        outline: none;
        border-color: var(--primary-color, #ff5c8d);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(255, 92, 141, 0.1);
    }
    
    .auth-input:focus + .auth-input-icon,
    .auth-input-wrapper:focus-within .auth-input-icon {
        color: var(--primary-color, #ff5c8d);
    }
    
    .auth-input::placeholder {
        color: #bbb;
    }
    
    .auth-toggle-password {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #aaa;
        cursor: pointer;
        padding: 0;
        transition: color 0.3s;
    }
    
    .auth-toggle-password:hover {
        color: var(--primary-color, #ff5c8d);
    }
    
    .auth-checkbox {
        display: flex;
        align-items: center;
        cursor: pointer;
        font-size: 0.875rem;
        color: #666;
    }
    
    .auth-checkbox input {
        width: 18px;
        height: 18px;
        margin-right: 0.5rem;
        accent-color: var(--primary-color, #ff5c8d);
    }
    
    .auth-submit-btn {
        width: 100%;
        padding: 0.875rem;
        background: linear-gradient(135deg, var(--gradient-start, #ff5c8d), var(--gradient-end, #ff92b7));
        border: none;
        border-radius: 12px;
        color: #fff;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .auth-submit-btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(255, 92, 141, 0.3);
    }
    
    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
    }
    
    .auth-footer p {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
    }
    
    .auth-link {
        color: var(--primary-color, #ff5c8d);
        font-weight: 600;
        text-decoration: none;
    }
    
    .auth-link:hover {
        text-decoration: underline;
    }
    
    .auth-input.is-invalid {
        border-color: #dc3545;
    }
</style>
@endpush

@push('scripts')
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.parentElement.querySelector('.auth-toggle-password i');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
@endsection
