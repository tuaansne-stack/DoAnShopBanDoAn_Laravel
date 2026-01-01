<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Trang chủ') - {{ $settings->shop_info ?? 'Food Shop' }}</title>

    <!-- Favicon -->
    @if(!empty($settings->favicon))
        <link rel="shortcut icon" href="{{ asset('assets/images/' . $settings->favicon) }}">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Slick Slider CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">

    <!-- Custom CSS -->
    @if(file_exists(public_path('css/app.min.css')))
        <link rel="stylesheet" href="{{ mix('css/app.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/notifications.css') }}">
    @endif

    @stack('styles')

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'Trang chủ') - {{ $settings->shop_info ?? 'Food Shop' }}">
    <meta property="og:description" content="{{ $settings->website_info ?? 'Chuyên cung cấp các món ăn ngon và chất lượng cao' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @if(!empty($settings->logo))
        <meta property="og:image" content="{{ asset('assets/images/' . $settings->logo) }}">
    @endif
    <meta property="og:type" content="website">

    <!-- Cart Utils JS -->
</head>

<body>
    @php
        if (!isset($categories)) {
            $categories = \App\Models\Category::limit(6)->get();
        }
    @endphp

    <!-- Top Bar -->
    <div class="top-bar bg-gradient py-1 d-none d-md-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="top-left d-flex align-items-center small">
                        <span class="topbar-text fw-semibold me-3">{{ $settings->shop_info ?? 'Food Shop' }}</span>
                        <span class="topbar-text-muted border-start ps-3">{{ $settings->website_info ?? 'Cửa hàng thực phẩm chính hãng' }}</span>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="top-right d-flex align-items-center justify-content-end small">
                        <!-- Social Icons -->
                        <div class="top-social me-4">
                            @if(!empty($settings->facebook))
                                <a href="{{ $settings->facebook }}" class="topbar-link me-2" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            <a href="#" class="topbar-link me-2" title="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="topbar-link me-2" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="#" class="topbar-link me-2" title="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                            <a href="#" class="topbar-link me-2" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="topbar-link" title="Instagram"><i class="fab fa-instagram"></i></a>
                        </div>
                        <!-- Quick Links -->
                        <div class="top-links d-flex align-items-center border-start ps-4">
                            <a href="{{ route('news.index') }}" class="topbar-link text-decoration-none me-3">Cẩm nang</a>
                            <a href="{{ route('contact') }}" class="topbar-link text-decoration-none me-3">Liên hệ</a>
                            <a href="{{ route('about') }}" class="topbar-link text-decoration-none">Chính sách</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header bg-white shadow-sm">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    @if(!empty($settings->logo))
                        <div class="logo-container">
                            <img src="{{ asset('assets/images/' . $settings->logo) }}" alt="{{ $settings->shop_info ?? 'Food Shop' }}" height="50" class="site-logo">
                        </div>
                    @else
                        <span class="text-gradient fw-bold fs-4">{{ $settings->shop_info ?? 'Food Shop' }}</span>
                    @endif
                </a>

                <!-- Menu Button (Mobile) -->
                <button class="navbar-toggler d-lg-none" type="button" id="mobileMenuToggle" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Links (Desktop) -->
                <div class="collapse navbar-collapse d-none d-lg-block" id="navbarContent">
                    <!-- Main Menu -->
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
                        </li>

                        <!-- Danh mục món ăn dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="menuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Thực đơn
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="menuDropdown">
                                <li><a class="dropdown-item" href="{{ route('products.index') }}"><i class="fas fa-utensils me-2"></i>Tất cả món ăn</a></li>
                                <li><hr class="dropdown-divider"></li>
                                @foreach($categories as $category)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('products.index', ['category' => $category->id]) }}">
                                            {{ $category->ten_danhmuc }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('news.index') }}">Tin tức</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">Giới thiệu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Liên hệ</a>
                        </li>
                    </ul>

                    <!-- User Menu & Cart -->
                    <div class="d-flex align-items-center">
                        <!-- Search Button (Toggle) -->
                        <div class="header-icon-btn me-3 d-none d-lg-block">
                            <a href="#" class="header-icon-link"
                                data-bs-toggle="collapse" data-bs-target="#searchBar" aria-expanded="false">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>

                        <!-- Cart -->
                        <div class="header-icon-btn me-3 d-none d-lg-block">
                            <a href="{{ route('cart.index') }}" class="header-icon-link position-relative">
                                <i class="fas fa-shopping-cart"></i>
                                @auth
                                    @php
                                        $cartCount = \App\Models\Cart::where('user_id', Auth::id())->count();
                                    @endphp
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge" 
                                          style="{{ $cartCount > 0 ? '' : 'display: none;' }}">{{ $cartCount > 0 ? $cartCount : '' }}</span>
                                @endauth
                            </a>
                        </div>

                        <!-- User Account -->
                        @auth
                            <div class="dropdown">
                                <a class="btn btn-outline-primary dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->hoten }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="fas fa-user me-2"></i>Thông tin cá nhân</a></li>
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-clipboard-list me-2"></i>Đơn hàng của tôi</a></li>

                                    @if(Auth::user()->isAdminOrStaff())
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ url('/admin') }}"><i class="fas fa-cogs me-2"></i>{{ Auth::user()->isAdmin() ? 'Quản trị shop' : 'Quản Lý' }}</a></li>
                                    @endif

                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <div class="auth-buttons d-flex align-items-center">
                                <a href="{{ route('login') }}" class="btn btn-outline-primary header-auth-btn me-2">
                                    <i class="fas fa-sign-in-alt me-1"></i> Đăng nhập
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-gradient header-auth-btn">
                                    <i class="fas fa-user-plus me-1"></i> Đăng ký
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Search Bar (Collapsible) -->
        <div class="collapse" id="searchBar">
            <div class="container py-3">
                <form action="{{ route('search') }}" method="GET" class="search-form">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm món ăn, tin tức..." aria-label="Search">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </header>

    <!-- Mobile Sidebar Menu -->
    <div class="mobile-sidebar-overlay" id="mobileSidebarOverlay"></div>
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="mobile-sidebar-header">
            <h5 class="mb-0 text-gradient">{{ $settings->shop_info ?? 'Food Shop' }}</h5>
            <button class="mobile-sidebar-close" id="mobileSidebarClose" aria-label="Close menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mobile-sidebar-body">
            <!-- Main Menu -->
            <ul class="mobile-nav-list">
                <li class="mobile-nav-item">
                    <a class="mobile-nav-link" href="{{ route('home') }}">
                        <i class="fas fa-home me-2"></i>Trang chủ
                    </a>
                </li>

                <!-- Danh mục món ăn dropdown -->
                <li class="mobile-nav-item">
                    <a class="mobile-nav-link mobile-nav-toggle" href="#" data-target="mobileMenuDropdown">
                        <span><i class="fas fa-utensils me-2"></i>Thực đơn</span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="mobile-nav-dropdown" id="mobileMenuDropdown">
                        <li><a class="mobile-nav-link" href="{{ route('products.index') }}"><i class="fas fa-utensils me-2"></i>Tất cả món ăn</a></li>
                        @foreach($categories as $category)
                            <li>
                                <a class="mobile-nav-link" href="{{ route('products.index', ['category' => $category->id]) }}">
                                    {{ $category->ten_danhmuc }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="mobile-nav-item">
                    <a class="mobile-nav-link" href="{{ route('news.index') }}">
                        <i class="fas fa-newspaper me-2"></i>Tin tức
                    </a>
                </li>
                <li class="mobile-nav-item">
                    <a class="mobile-nav-link" href="{{ route('about') }}">
                        <i class="fas fa-info-circle me-2"></i>Giới thiệu
                    </a>
                </li>
                <li class="mobile-nav-item">
                    <a class="mobile-nav-link" href="{{ route('contact') }}">
                        <i class="fas fa-phone me-2"></i>Liên hệ
                    </a>
                </li>
            </ul>

            <!-- Search -->
            <div class="mobile-sidebar-section">
                <form action="{{ route('search') }}" method="GET" class="mobile-search-form">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm món ăn, tin tức..." aria-label="Search">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>

            <!-- Cart -->
            <div class="mobile-sidebar-section">
                <a href="{{ route('cart.index') }}" class="mobile-sidebar-btn">
                    <i class="fas fa-shopping-cart me-2"></i>
                    <span>Giỏ hàng</span>
                    @auth
                        @php
                            $cartCount = \App\Models\Cart::where('user_id', Auth::id())->count();
                        @endphp
                        @if($cartCount > 0)
                            <span class="badge bg-danger ms-auto">{{ $cartCount }}</span>
                        @endif
                    @endauth
                </a>
            </div>

            <!-- User Account -->
            <div class="mobile-sidebar-section">
                @auth
                    <div class="mobile-user-info">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-user-circle fa-2x text-primary me-2"></i>
                            <div>
                                <strong>{{ Auth::user()->hoten }}</strong>
                                <small class="d-block text-muted">{{ Auth::user()->email }}</small>
                            </div>
                        </div>
                        <ul class="mobile-nav-list">
                            <li class="mobile-nav-item">
                                <a class="mobile-nav-link" href="{{ route('profile.index') }}">
                                    <i class="fas fa-user me-2"></i>Thông tin cá nhân
                                </a>
                            </li>
                            <li class="mobile-nav-item">
                                <a class="mobile-nav-link" href="{{ route('orders.index') }}">
                                    <i class="fas fa-clipboard-list me-2"></i>Đơn hàng của tôi
                                </a>
                            </li>
                            @if(Auth::user()->isAdminOrStaff())
                                <li class="mobile-nav-item">
                                    <a class="mobile-nav-link" href="{{ url('/admin') }}">
                                        <i class="fas fa-cogs me-2"></i>{{ Auth::user()->isAdmin() ? 'Quản trị shop' : 'Quản Lý' }}
                                    </a>
                                </li>
                            @endif
                            <li class="mobile-nav-item">
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="mobile-nav-link w-100 text-start border-0 bg-transparent">
                                        <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="mobile-auth-buttons">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-gradient w-100">
                            <i class="fas fa-user-plus me-2"></i> Đăng ký
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <main class="container py-4">
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

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-auto">
        <div class="container">
            <div class="row">
                <!-- Logo & About -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="text-gradient mb-3">{{ $settings->shop_info ?? 'Food Shop' }}</h5>
                    <p class="small">{{ $settings->website_info ?? 'Chuyên cung cấp các món ăn ngon và chất lượng cao.' }}</p>

                    <!-- Social Media -->
                    <div class="footer-social-icons mt-3">
                        @if(!empty($settings->facebook))
                            <a href="{{ $settings->facebook }}" class="footer-social-link" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if(!empty($settings->twitter))
                            <a href="{{ $settings->twitter }}" class="footer-social-link" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if(!empty($settings->email))
                            <a href="mailto:{{ $settings->email }}" class="footer-social-link" title="Email"><i class="fas fa-envelope"></i></a>
                        @endif
                        @if(!empty($settings->pinterest))
                            <a href="{{ $settings->pinterest }}" class="footer-social-link" target="_blank" title="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                        @endif
                        @if(!empty($settings->linkedin))
                            <a href="{{ $settings->linkedin }}" class="footer-social-link" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                        @if(!empty($settings->instagram))
                            <a href="{{ $settings->instagram }}" class="footer-social-link" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if(!empty($settings->zalo))
                            <a href="https://zalo.me/{{ $settings->zalo }}" class="footer-social-link" target="_blank" title="Zalo"><i class="fas fa-phone"></i></a>
                        @endif
                        @if(!empty($settings->tiktok))
                            <a href="{{ $settings->tiktok }}" class="footer-social-link" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
                        @endif
                    </div>
                    
                    <!-- Certification Icon -->
                    <div class="mt-3">
                        <a href="http://online.gov.vn/" target="_blank" rel="noopener" title="Đã đăng ký Bộ Công Thương">
                            <img src="{{ asset('assets/images/logoSaleNoti.png') }}" alt="Đã thông báo Bộ Công Thương" class="footer-certification-icon">
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="mb-3">Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-light text-decoration-none"><i class="fas fa-angle-right me-2"></i>Trang chủ</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-light text-decoration-none"><i class="fas fa-angle-right me-2"></i>Thực đơn</a></li>
                        <li class="mb-2"><a href="{{ route('news.index') }}" class="text-light text-decoration-none"><i class="fas fa-angle-right me-2"></i>Tin tức</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}" class="text-light text-decoration-none"><i class="fas fa-angle-right me-2"></i>Giới thiệu</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}" class="text-light text-decoration-none"><i class="fas fa-angle-right me-2"></i>Liên hệ</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4">
                    <h5 class="mb-3">Thông tin liên hệ</h5>
                    <ul class="list-unstyled">
                        @if(!empty($settings->address))
                            <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>{{ $settings->address }}</li>
                        @endif

                        @if(!empty($settings->hotline))
                            <li class="mb-2"><i class="fas fa-phone-alt me-2"></i>{{ $settings->hotline }}</li>
                        @endif

                        @if(!empty($settings->email))
                            <li class="mb-2"><i class="fas fa-envelope me-2"></i>{{ $settings->email }}</li>
                        @endif

                        <li class="mb-2"><i class="fas fa-clock me-2"></i>Giờ mở cửa: 7:00 - 22:00</li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-top border-secondary pt-3 mt-3 text-center">
                <p class="small mb-0">&copy; {{ date('Y') }} {{ $settings->shop_info ?? 'Food Shop' }}. Bản Quyền Thuộc Về Panther Team</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTopBtn" class="btn btn-gradient rounded-circle position-fixed bottom-0 end-0 m-4 shadow" style="width: 45px; height: 45px; display: none; z-index: 1000;">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Slick Slider JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <!-- Main JS -->
    @if(file_exists(public_path('js/app.min.js')))
        <script src="{{ mix('js/app.min.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/cart-laravel.js') }}"></script>
        <script src="{{ asset('assets/js/form-validation.js') }}"></script>
        <script src="{{ asset('assets/js/effects.js') }}"></script>
    @endif

    @stack('scripts')

    <script>
        // Laravel routes for JavaScript
        window.Laravel = {
            routes: {
                'cart.add': '{{ route("cart.add") }}',
                'cart.update': '{{ route("cart.update", ["id" => ":id"]) }}',
                'cart.remove': '{{ route("cart.remove", ["id" => ":id"]) }}',
                'cart.clear': '{{ route("cart.clear") }}',
                'cart.count': '{{ route("cart.count") }}',
                'login': '{{ route("login") }}',
            },
            csrfToken: '{{ csrf_token() }}',
            isAuthenticated: {{ Auth::check() ? 'true' : 'false' }}
        };

        // Back to top button functionality
        document.addEventListener('DOMContentLoaded', function() {
            var backToTopBtn = document.getElementById('backToTopBtn');

            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopBtn.style.display = 'flex';
                    backToTopBtn.classList.add('d-flex', 'align-items-center', 'justify-content-center');
                    backToTopBtn.style.opacity = '1';
                } else {
                    backToTopBtn.style.opacity = '0';
                    setTimeout(function() {
                        if (window.pageYOffset <= 300) {
                            backToTopBtn.style.display = 'none';
                        }
                    }, 300);
                }
            });

            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Slider initialization
            setTimeout(function() {
                if (typeof $ !== 'undefined' && typeof $.fn.slick === 'function') {
                    var $slider = $('.slide-gioi-thieu');
                    // Only init if slider exists and has slides
                    if ($slider.length && $slider.children().length > 0) {
                        try {
                            $slider.slick({
                                dots: true,
                                arrows: false,
                                autoplay: true,
                                autoplaySpeed: 4000,
                                fade: true,
                                cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
                                speed: 800,
                                responsive: [{
                                    breakpoint: 767,
                                    settings: {
                                        dots: false
                                    }
                                }]
                            });
                        } catch (error) {
                            // Silently ignore slider errors
                        }
                    }
                }
            }, 500);

            // Mobile sidebar menu
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileSidebar = document.getElementById('mobileSidebar');
            const mobileSidebarOverlay = document.getElementById('mobileSidebarOverlay');
            const mobileSidebarClose = document.getElementById('mobileSidebarClose');

            function openMobileSidebar() {
                mobileSidebar.classList.add('show');
                mobileSidebarOverlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function closeMobileSidebar() {
                mobileSidebar.classList.remove('show');
                mobileSidebarOverlay.classList.remove('show');
                document.body.style.overflow = '';
            }

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', openMobileSidebar);
            }

            if (mobileSidebarClose) {
                mobileSidebarClose.addEventListener('click', closeMobileSidebar);
            }

            if (mobileSidebarOverlay) {
                mobileSidebarOverlay.addEventListener('click', closeMobileSidebar);
            }

            // Mobile dropdown toggle
            document.querySelectorAll('.mobile-nav-toggle').forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('data-target');
                    const dropdown = document.getElementById(target);
                    const isActive = this.classList.contains('active');

                    // Close all other dropdowns
                    document.querySelectorAll('.mobile-nav-dropdown').forEach(dd => {
                        if (dd !== dropdown) {
                            dd.classList.remove('show');
                        }
                    });
                    document.querySelectorAll('.mobile-nav-toggle').forEach(t => {
                        if (t !== this) {
                            t.classList.remove('active');
                        }
                    });

                    // Toggle current dropdown
                    if (isActive) {
                        dropdown.classList.remove('show');
                        this.classList.remove('active');
                    } else {
                        dropdown.classList.add('show');
                        this.classList.add('active');
                    }
                });
            });

            // Close sidebar when clicking on nav link (except dropdown toggles)
            document.querySelectorAll('.mobile-nav-link:not(.mobile-nav-toggle)').forEach(link => {
                link.addEventListener('click', function() {
                    if (!this.closest('.mobile-nav-dropdown')) {
                        closeMobileSidebar();
                    }
                });
            });
        });
    </script>

<!-- Topping Bottom Sheet -->
<div id="toppingBottomSheet" class="topping-bottom-sheet">
    <div class="topping-sheet-overlay"></div>
    <div class="topping-sheet-content">
        <div class="topping-sheet-header">
            <div class="topping-sheet-handle"></div>
            <h5 class="topping-sheet-title">Chọn topping</h5>
            <button type="button" class="topping-sheet-close">&times;</button>
        </div>
        <div class="topping-sheet-product">
            <img id="sheetProductImage" src="" alt="">
            <div class="topping-sheet-product-info">
                <h6 id="sheetProductName"></h6>
                <span id="sheetProductPrice" class="topping-sheet-price"></span>
            </div>
        </div>
        <div class="topping-sheet-body">
            <div class="topping-sheet-list" id="sheetToppingList">
                <!-- Toppings will be injected here -->
            </div>
        </div>
        <div class="topping-sheet-footer">
            <div class="topping-sheet-total">
                <span>Tổng cộng:</span>
                <span id="sheetTotalPrice" class="topping-sheet-total-price">0 đ</span>
            </div>
            <button type="button" class="topping-sheet-add-btn" id="sheetAddToCartBtn">
                <i class="fas fa-cart-plus"></i> Thêm vào giỏ
            </button>
        </div>
    </div>
</div>

<style>
/* Topping Bottom Sheet Styles */
.topping-bottom-sheet {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
}
.topping-bottom-sheet.active {
    display: block;
}
.topping-sheet-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(2px);
}
.topping-sheet-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: #fff;
    border-radius: 20px 20px 0 0;
    max-height: 85vh;
    display: flex;
    flex-direction: column;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}
.topping-bottom-sheet.active .topping-sheet-content {
    transform: translateY(0);
}
.topping-sheet-header {
    padding: 12px 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
}
.topping-sheet-handle {
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 4px;
    background: #ddd;
    border-radius: 2px;
}
.topping-sheet-title {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
    color: #333;
}
.topping-sheet-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #999;
    cursor: pointer;
    line-height: 1;
}
.topping-sheet-product {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    gap: 12px;
    background: #f8f9fa;
}
.topping-sheet-product img {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    object-fit: cover;
}
.topping-sheet-product-info h6 {
    margin: 0 0 4px;
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
}
.topping-sheet-price {
    color: var(--primary-color, #ff5c8d);
    font-weight: 600;
    font-size: 0.9rem;
}
.topping-sheet-body {
    flex: 1;
    overflow-y: auto;
    padding: 15px 20px;
    max-height: 40vh;
}
.topping-sheet-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.topping-sheet-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    background: #f8f9fa;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
    border: 2px solid transparent;
}
.topping-sheet-item.selected {
    background: #fff0f5;
    border-color: var(--primary-color, #ff5c8d);
}
.topping-sheet-item img {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    object-fit: cover;
}
.topping-sheet-item-info {
    flex: 1;
}
.topping-sheet-item-name {
    font-weight: 500;
    font-size: 0.9rem;
    color: #333;
}
.topping-sheet-item-price {
    font-size: 0.8rem;
    color: var(--primary-color, #ff5c8d);
    font-weight: 600;
}
.topping-sheet-item-check {
    width: 24px;
    height: 24px;
    border: 2px solid #ddd;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.topping-sheet-item.selected .topping-sheet-item-check {
    background: var(--primary-color, #ff5c8d);
    border-color: var(--primary-color, #ff5c8d);
    color: #fff;
}
.topping-sheet-footer {
    padding: 15px 20px;
    border-top: 1px solid #eee;
    display: flex;
    align-items: center;
    gap: 15px;
    background: #fff;
}
.topping-sheet-total {
    flex: 1;
}
.topping-sheet-total span:first-child {
    display: block;
    font-size: 0.75rem;
    color: #888;
}
.topping-sheet-total-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary-color, #ff5c8d);
}
.topping-sheet-add-btn {
    background: linear-gradient(135deg, #ff6b9d, #ff8a65);
    color: #fff;
    border: none;
    padding: 12px 24px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: transform 0.2s;
}
.topping-sheet-add-btn:active {
    transform: scale(0.95);
}

/* Desktop Styles - Centered Modal */
@media (min-width: 769px) {
    .topping-sheet-content {
        max-width: 480px;
        left: 50%;
        top: 50%;
        bottom: auto;
        transform: translate(-50%, -50%) scale(0.9);
        border-radius: 16px;
        opacity: 0;
        max-height: 80vh;
    }
    .topping-bottom-sheet.active .topping-sheet-content {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }
    .topping-sheet-handle {
        display: none;
    }
    .topping-sheet-header {
        padding: 16px 24px;
    }
    .topping-sheet-title {
        font-size: 1.1rem;
    }
    .topping-sheet-body {
        max-height: 50vh;
    }
    .topping-sheet-footer {
        border-radius: 0 0 16px 16px;
    }
}
</style>

<script>
// Topping Bottom Sheet Controller
(function() {
    const sheet = document.getElementById('toppingBottomSheet');
    if (!sheet) return;
    
    const overlay = sheet.querySelector('.topping-sheet-overlay');
    const closeBtn = sheet.querySelector('.topping-sheet-close');
    const toppingList = document.getElementById('sheetToppingList');
    const totalPriceEl = document.getElementById('sheetTotalPrice');
    const addToCartBtn = document.getElementById('sheetAddToCartBtn');
    
    let currentProduct = null;
    let selectedToppings = [];
    
    // Open bottom sheet
    window.openToppingSheet = function(product) {
        currentProduct = product;
        selectedToppings = [];
        
        // Set product info
        document.getElementById('sheetProductImage').src = product.image;
        document.getElementById('sheetProductName').textContent = product.name;
        document.getElementById('sheetProductPrice').textContent = product.priceFormatted;
        
        // Render toppings
        toppingList.innerHTML = '';
        if (product.toppings && product.toppings.length > 0) {
            product.toppings.forEach(topping => {
                const item = document.createElement('div');
                item.className = 'topping-sheet-item';
                item.dataset.toppingId = topping.id;
                item.dataset.toppingPrice = topping.price;
                item.dataset.toppingName = topping.name;
                item.innerHTML = `
                    ${topping.image ? `<img src="${topping.image}" alt="">` : ''}
                    <div class="topping-sheet-item-info">
                        <div class="topping-sheet-item-name">${topping.name}</div>
                        <div class="topping-sheet-item-price">+${new Intl.NumberFormat('vi-VN').format(topping.price)}đ</div>
                    </div>
                    <div class="topping-sheet-item-check">
                        <i class="fas fa-check" style="font-size: 12px;"></i>
                    </div>
                `;
                item.addEventListener('click', () => toggleTopping(item, topping));
                toppingList.appendChild(item);
            });
        }
        
        updateTotal();
        sheet.classList.add('active');
        document.body.style.overflow = 'hidden';
    };
    
    // Close bottom sheet
    function closeSheet() {
        sheet.classList.remove('active');
        document.body.style.overflow = '';
        currentProduct = null;
        selectedToppings = [];
    }
    
    // Toggle topping selection
    function toggleTopping(item, topping) {
        const index = selectedToppings.findIndex(t => t.id == topping.id);
        if (index > -1) {
            selectedToppings.splice(index, 1);
            item.classList.remove('selected');
        } else {
            selectedToppings.push(topping);
            item.classList.add('selected');
        }
        updateTotal();
    }
    
    // Update total price
    function updateTotal() {
        if (!currentProduct) return;
        let total = currentProduct.price;
        selectedToppings.forEach(t => {
            total += parseInt(t.price);
        });
        totalPriceEl.textContent = new Intl.NumberFormat('vi-VN').format(total) + ' đ';
    }
    
    // Add to cart
    addToCartBtn.addEventListener('click', function() {
        if (!currentProduct) return;
        
        // Prepare toppings data
        const toppingsData = selectedToppings.map(t => ({
            id: t.id,
            name: t.name,
            price: t.price
        }));
        
        // Create a virtual button with toppings data
        const virtualBtn = document.createElement('button');
        virtualBtn.dataset.toppings = JSON.stringify(toppingsData);
        virtualBtn.dataset.productId = currentProduct.id;
        
        // Trigger add to cart
        if (typeof window.addToCartWithToppings === 'function') {
            window.addToCartWithToppings(currentProduct.id, 1, virtualBtn);
        } else {
            // Fallback: find and trigger normal add to cart
            const formData = new FormData();
            formData.append('product_id', currentProduct.id);
            formData.append('quantity', 1);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            
            toppingsData.forEach((topping, index) => {
                formData.append(`toppings[${index}][id]`, topping.id);
                formData.append(`toppings[${index}][name]`, topping.name);
                formData.append(`toppings[${index}][price]`, topping.price);
            });
            
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    closeSheet();
                    // Update cart count
                    const cartBadge = document.querySelector('.cart-badge');
                    if (cartBadge && data.cart_count !== undefined) {
                        cartBadge.textContent = data.cart_count;
                        cartBadge.style.display = data.cart_count > 0 ? 'flex' : 'none';
                    }
                    showCartToast('Đã thêm vào giỏ hàng!');
                } else if (data.requires_auth) {
                    window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
                }
            })
            .catch(err => {
                console.error('Add to cart error:', err);
            });
        }
        
        closeSheet();
    });
    
    // Close events
    overlay.addEventListener('click', closeSheet);
    closeBtn.addEventListener('click', closeSheet);
})();

// Toast notification function
function showCartToast(message) {
    // Create toast container if not exists
    let toastContainer = document.getElementById('cartToastContainer');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'cartToastContainer';
        toastContainer.innerHTML = `
            <style>
                #cartToastContainer {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 99999;
                    pointer-events: none;
                }
                .cart-toast {
                    background: linear-gradient(135deg, #28a745, #20c997);
                    color: #fff;
                    padding: 14px 24px;
                    border-radius: 12px;
                    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.35);
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    font-weight: 500;
                    font-size: 0.95rem;
                    animation: slideInToast 0.3s ease, fadeOutToast 0.3s ease 2s forwards;
                    pointer-events: auto;
                }
                .cart-toast i {
                    font-size: 1.2rem;
                }
                @keyframes slideInToast {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes fadeOutToast {
                    from { opacity: 1; transform: translateX(0); }
                    to { opacity: 0; transform: translateX(100%); }
                }
                @media (max-width: 576px) {
                    #cartToastContainer {
                        top: 10px;
                        right: 10px;
                        left: 10px;
                    }
                    .cart-toast {
                        justify-content: center;
                    }
                }
            </style>
        `;
        document.body.appendChild(toastContainer);
    }
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'cart-toast';
    toast.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
    toastContainer.appendChild(toast);
    
    // Remove after animation
    setTimeout(() => {
        toast.remove();
    }, 2300);
}
</script>
</body>

</html>

