<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Admin Panel</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --admin-primary: #ff69b4;
            --admin-primary-light: #ffb6c1;
            --admin-primary-dark: #e05a9d;
        }
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #ff69b4 0%, #ffb6c1 50%, #ffc0cb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            padding: 2.5rem;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header h1 {
            background: linear-gradient(135deg, #ff69b4 0%, #e05a9d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 1.8rem;
        }
        .form-control:focus {
            border-color: var(--admin-primary-light);
            box-shadow: 0 0 0 0.25rem rgba(255, 105, 180, 0.25);
        }
        .btn-pink {
            background: linear-gradient(135deg, #ff69b4 0%, #e05a9d 100%);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-pink:hover {
            background: linear-gradient(135deg, #e05a9d 0%, #c44d8a 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 105, 180, 0.4);
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }
        .form-control.with-icon {
            border-left: none;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h1><i class="fas fa-utensils me-2"></i>Food Shop</h1>
            <p class="text-muted">Admin Panel</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                    <input type="email" class="form-control with-icon @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                    <input type="password" class="form-control with-icon @error('password') is-invalid @enderror" 
                           id="password" name="password" placeholder="••••••••" required>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-pink w-100">
                <i class="fas fa-sign-in-alt me-2"></i>Đăng Nhập
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--admin-primary);">
                <i class="fas fa-arrow-left me-1"></i>Quay lại trang chủ
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
