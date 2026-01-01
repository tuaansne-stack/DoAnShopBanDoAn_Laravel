<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Admin Panel</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --sidebar-bg: #f0f4fd;
            --sidebar-active: #e91e63;
            --primary-pink: #e91e63;
            --primary-pink-light: #fce4ec;
            --card-shadow: 0 2px 10px rgba(0,0,0,0.08);
            --border-color: #e8e8e8;
        }
        
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
            margin: 0;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 220px;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding: 0;
            z-index: 100;
            overflow-y: auto;
        }
        
        .sidebar-brand {
            padding: 20px 15px;
            color: var(--primary-pink);
        }
        
        .sidebar-brand h4 {
            font-weight: 700;
            margin: 0;
            font-size: 1.3rem;
        }
        
        .sidebar-brand small {
            font-size: 0.7rem;
            color: #888;
        }
        
        .sidebar-menu { padding: 0; }
        
        .sidebar-heading {
            padding: 15px 20px 5px;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            font-weight: 600;
        }
        
        .sidebar .nav-link {
            padding: 10px 20px;
            color: #555;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
            font-size: 0.9rem;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(233, 30, 99, 0.08);
            color: var(--primary-pink);
        }
        
        .sidebar .nav-link.active {
            background: rgba(233, 30, 99, 0.12);
            color: var(--primary-pink);
            border-left-color: var(--primary-pink);
            font-weight: 600;
        }
        
        .sidebar .badge {
            font-size: 0.65rem;
            padding: 3px 6px;
        }
        
        /* Content area */
        .content-wrapper {
            margin-left: 220px;
            min-height: 100vh;
        }
        
        /* Topbar */
        .topbar {
            background: #fff;
            padding: 12px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        
        .topbar-title {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }
        
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .topbar-user-info {
            text-align: right;
            font-size: 0.8rem;
        }
        
        .topbar-user-info .name {
            font-weight: 600;
            color: #333;
        }
        
        .topbar-user-info .email {
            color: #888;
            font-size: 0.7rem;
        }
        
        .topbar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .topbar-left {
            display: flex;
            align-items: center;
        }
        
        .notification-bell {
            position: relative;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            cursor: pointer;
        }
        
        .notification-bell:hover {
            color: var(--primary-pink);
        }
        
        .notification-bell .notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: #e53935;
            color: #fff;
            font-size: 0.6rem;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Main content */
        .main-content {
            padding: 20px 25px;
        }
        
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .page-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #333;
            margin: 0;
        }
        
        /* Cards */
        .card {
            background: #fff;
            border: none;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            margin-bottom: 20px;
        }
        
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 15px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .card-body { padding: 20px; }
        
        /* Stat cards */
        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .stat-card .stat-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 5px;
            color: #333;
        }
        
        .stat-card .stat-content p {
            margin: 0;
            font-size: 0.8rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-card .stat-content small {
            font-size: 0.7rem;
            color: #999;
        }
        
        .stat-card .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        .stat-card.blue .stat-icon { background: #e3f2fd; color: #1976d2; }
        .stat-card.green .stat-icon { background: #e8f5e9; color: #388e3c; }
        .stat-card.yellow .stat-icon { background: #fff8e1; color: #f57c00; }
        .stat-card.purple .stat-icon { background: #f3e5f5; color: #7b1fa2; }
        
        .stat-card.blue .stat-content p { color: #1976d2; }
        .stat-card.green .stat-content p { color: #388e3c; }
        .stat-card.yellow .stat-content p { color: #f57c00; }
        .stat-card.purple .stat-content p { color: #7b1fa2; }
        
        /* Buttons */
        .btn-pink {
            background: var(--primary-pink);
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .btn-pink:hover {
            background: #c2185b;
            color: #fff;
        }
        
        .btn-outline-pink {
            border: 1px solid var(--primary-pink);
            color: var(--primary-pink);
            background: transparent;
        }
        
        .btn-outline-pink:hover {
            background: var(--primary-pink);
            color: #fff;
        }
        
        /* Tables */
        .table {
            margin: 0;
            font-size: 0.85rem;
        }
        
        .table thead th {
            background: #f8f9fc;
            border-bottom: 1px solid var(--border-color);
            padding: 12px 15px;
            font-weight: 600;
            color: #555;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        
        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .table tbody tr:hover {
            background: #fafafa;
        }
        
        /* Action buttons */
        .action-btns {
            display: flex;
            gap: 5px;
        }
        
        .action-btns .btn {
            width: 30px;
            height: 30px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            border-radius: 5px;
        }
        
        .btn-action-view { background: #e3f2fd; color: #1976d2; border: none; }
        .btn-action-edit { background: #fff3e0; color: #f57c00; border: none; }
        .btn-action-delete { background: #ffebee; color: #e53935; border: none; }
        
        /* Badges */
        .badge-status {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-pending { background: #fff3e0; color: #f57c00; }
        .badge-confirmed { background: #e3f2fd; color: #1976d2; }
        .badge-shipping { background: #fce4ec; color: #e91e63; }
        .badge-completed { background: #e8f5e9; color: #388e3c; }
        .badge-canceled { background: #ffebee; color: #e53935; }
        
        /* Forms */
        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #555;
            margin-bottom: 5px;
        }
        
        .form-control, .form-select {
            font-size: 0.85rem;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 3px rgba(233, 30, 99, 0.1);
        }
        
        /* Alerts */
        .alert {
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            padding: 12px 15px;
        }
        
        /* Admin Pagination - Modern Style */
        .admin-pagination {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 15px 0;
        }
        
        .admin-pagination .pagination-info {
            font-size: 0.85rem;
            color: #666;
        }
        
        .admin-pagination .pagination-buttons {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .admin-pagination .pagination-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 14px;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            background: #fff;
            color: #333;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .admin-pagination .pagination-btn:hover:not(.disabled):not(.active) {
            background: #f5f5f5;
            border-color: #ccc;
        }
        
        .admin-pagination .pagination-btn.active {
            background: #1a1a1a;
            border-color: #1a1a1a;
            color: #fff;
        }
        
        .admin-pagination .pagination-btn.disabled {
            color: #bbb;
            background: #f8f8f8;
            cursor: not-allowed;
            border-color: #eee;
        }
        
        .admin-pagination .pagination-btn.prev,
        .admin-pagination .pagination-btn.next {
            padding: 0 18px;
            font-weight: 500;
        }
        
        .admin-pagination .pagination-dots {
            padding: 0 8px;
            color: #666;
            font-size: 0.9rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-pagination {
                flex-direction: column;
                text-align: center;
            }
            
            .admin-pagination .pagination-buttons {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .admin-pagination .pagination-btn {
                min-width: 32px;
                height: 32px;
                padding: 0 10px;
                font-size: 0.8rem;
            }
        }
        
        @media (max-width: 480px) {
            .admin-pagination .pagination-btn {
                min-width: 28px;
                height: 28px;
                padding: 0 8px;
                font-size: 0.75rem;
                border-radius: 14px;
            }
            
            .admin-pagination .pagination-btn.prev,
            .admin-pagination .pagination-btn.next {
                padding: 0 12px;
            }
        }
        
        /* Product image in table */
        .product-img {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            object-fit: cover;
        }
        
        .product-img-placeholder {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ccc;
        }
        
        /* Popular products list */
        .popular-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .popular-item:last-child { border-bottom: none; }
        
        .popular-item img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 12px;
        }
        
        .popular-item .info h6 {
            margin: 0;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .popular-item .info small {
            color: #888;
            font-size: 0.75rem;
        }
        
        /* Mobile Menu Toggle */
        .mobile-menu-btn {
            display: none;
            width: 40px;
            height: 40px;
            border: none;
            background: none;
            font-size: 1.2rem;
            color: #666;
            cursor: pointer;
        }
        
        /* Table Responsive */
        .table-responsive-admin {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Notification Dropdown */
        .notification-dropdown {
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        
        .notification-dropdown .dropdown-header {
            font-weight: 600;
            color: #333;
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        .notification-dropdown .dropdown-item:hover {
            background: #f8f9fc;
        }
        
        /* ===== ADMIN RESPONSIVE - FULL ===== */
        
        /* Tablet & Small Laptop */
        @media (max-width: 992px) {
            .mobile-menu-btn { display: flex; align-items: center; justify-content: center; }
            .sidebar { 
                display: none; 
                position: fixed;
                top: 0;
                left: 0;
                width: 250px;
                height: 100vh;
                z-index: 1000;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.show { display: block; transform: translateX(0); }
            .sidebar-overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.5); z-index: 999; display: none; }
            .sidebar-overlay.show { display: block; }
            .content-wrapper { margin-left: 0; }
            .topbar { padding: 10px 15px; }
            .topbar-title { font-size: 0.85rem; margin: 0; }
            .topbar-user-info { display: none; }
            .main-content { padding: 12px; }
        }
        
        /* Mobile Landscape & Tablet Portrait */
        @media (max-width: 768px) {
            .main-content { padding: 10px; }
            
            /* Stat Cards Row - equal gaps */
            .row {
                margin-left: -5px;
                margin-right: -5px;
            }
            .row .col-md-3,
            .row .col-lg-3,
            .row .col-xl-3,
            .row [class*="col-"] {
                flex: 0 0 50%;
                max-width: 50%;
                padding-left: 5px;
                padding-right: 5px;
                margin-bottom: 10px;
            }
            .stat-card { 
                padding: 10px; 
                margin-bottom: 0;
                border-radius: 8px;
                height: 100%;
            }
            .stat-card .stat-icon { 
                width: 32px; 
                height: 32px; 
                font-size: 0.85rem; 
            }
            .stat-card .stat-content h3 { 
                font-size: 1.1rem; 
                margin: 0;
            }
            .stat-card .stat-content p { 
                font-size: 0.65rem; 
                margin: 0 0 2px 0;
            }
            .stat-card .stat-content a { 
                font-size: 0.6rem; 
            }
            
            /* Cards */
            .card { margin-bottom: 10px; border-radius: 8px; }
            .card-header { padding: 10px 12px; font-size: 0.8rem; }
            .card-body { padding: 10px; }
            
            /* Tables */
            .table { font-size: 0.7rem; margin-bottom: 0; }
            .table thead th { 
                padding: 6px 4px; 
                font-size: 0.65rem; 
                white-space: nowrap;
            }
            .table tbody td { 
                padding: 6px 4px; 
                vertical-align: middle;
            }
            .table img { width: 30px !important; height: 30px !important; }
            
            /* Action Buttons */
            .action-btns { display: flex; flex-wrap: nowrap; gap: 2px; justify-content: center; }
            .action-btns .btn { 
                width: 24px; 
                height: 24px; 
                padding: 0;
                font-size: 0.65rem; 
            }
            
            /* Badges */
            .badge { font-size: 0.6rem; padding: 3px 6px; }
            
            /* Page Header */
            .page-header { 
                flex-direction: column; 
                align-items: flex-start !important; 
                gap: 8px;
                margin-bottom: 10px !important;
            }
            .page-title { font-size: 1rem; margin: 0; }
            .btn-pink { padding: 5px 10px; font-size: 0.75rem; }
            
            /* Sidebar */
            .sidebar-brand h4 { font-size: 1rem; }
            .sidebar .nav-link { padding: 8px 12px; font-size: 0.8rem; }
            .sidebar .nav-link i { font-size: 0.9rem; width: 20px; }
        }
        
        /* Mobile Portrait */
        @media (max-width: 576px) {
            .topbar { padding: 8px 10px; }
            .topbar-left { gap: 5px; }
            .topbar-title { font-size: 0.75rem; }
            .topbar-right { gap: 6px; }
            .notification-bell { width: 30px; height: 30px; font-size: 0.8rem; }
            .topbar-avatar { width: 28px; height: 28px; font-size: 0.65rem; }
            
            .main-content { padding: 8px; }
            
            /* Stat Cards with smaller text */
            .row .col-md-3,
            .row .col-lg-3,
            .row .col-xl-3 {
                padding: 3px;
            }
            .stat-card { padding: 8px; }
            .stat-card .stat-icon { width: 28px; height: 28px; font-size: 0.75rem; }
            .stat-card .stat-content h3 { font-size: 0.95rem; }
            .stat-card .stat-content p { font-size: 0.55rem; }
            
            /* Very compact tables */
            .table { font-size: 0.65rem; }
            .table thead th { padding: 5px 3px; font-size: 0.6rem; }
            .table tbody td { padding: 5px 3px; }
            .table img { width: 25px !important; height: 25px !important; }
            
            .action-btns .btn { width: 22px; height: 22px; font-size: 0.6rem; }
            .badge { font-size: 0.55rem; padding: 2px 4px; }
            
            /* Forms */
            .form-control, .form-select { 
                font-size: 0.8rem; 
                padding: 6px 10px;
            }
            .form-label { font-size: 0.75rem; }
            
            /* Modal */
            .modal-title { font-size: 0.95rem; }
            .modal-body { padding: 12px; }
            .modal-footer { padding: 10px 12px; }
            
            /* Notification dropdown */
            .notification-dropdown { min-width: 280px !important; }
        }
        
        /* Extra small phones */
        @media (max-width: 400px) {
            .stat-card .stat-content h3 { font-size: 0.85rem; }
            .stat-card .stat-content p { font-size: 0.5rem; }
            .stat-card .stat-icon { width: 24px; height: 24px; font-size: 0.7rem; }
            .table { font-size: 0.6rem; }
            .table thead th { font-size: 0.55rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
    @php
        $currentPage = request()->route()->getName();
        $pendingOrdersCount = \App\Models\Order::where('trangthai', 'Chờ xác nhận')->count();
        $pendingCommentsCount = \App\Models\Comment::where('trangthai', 'Chờ duyệt')->count();
    @endphp
    
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h4>Food Shop</h4>
            <small>Admin Panel</small>
        </div>
        
        <nav class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ str_contains($currentPage, 'dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                
                <div class="sidebar-heading">Menu Quản Lý</div>
                
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ str_contains($currentPage, 'products') ? 'active' : '' }}">
                        <i class="fas fa-utensils"></i> Món Ăn
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ str_contains($currentPage, 'categories') ? 'active' : '' }}">
                        <i class="fas fa-list"></i> Danh Mục
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ str_contains($currentPage, 'orders') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i> Đơn Hàng
                        @if($pendingOrdersCount > 0)
                            <span class="badge bg-danger ms-auto">{{ $pendingOrdersCount }}</span>
                        @endif
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.comments.index') }}" class="nav-link {{ str_contains($currentPage, 'comments') ? 'active' : '' }}">
                        <i class="fas fa-comments"></i> Bình Luận
                        @if($pendingCommentsCount > 0)
                            <span class="badge bg-danger ms-auto">{{ $pendingCommentsCount }}</span>
                        @endif
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.toppings.index') }}" class="nav-link {{ str_contains($currentPage, 'toppings') ? 'active' : '' }}">
                        <i class="fas fa-cookie"></i> Topping
                    </a>
                </li>
                
                <div class="sidebar-heading">Quản Lý Nội Dung</div>
                
                @if(Auth::user()->isAdmin())
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ str_contains($currentPage, 'users') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Người Dùng
                    </a>
                </li>
                @endif
                
                @if(Auth::user()->isAdmin())
                <li class="nav-item">
                    <a href="{{ route('admin.about.index') }}" class="nav-link {{ str_contains($currentPage, 'about') ? 'active' : '' }}">
                        <i class="fas fa-info-circle"></i> Giới Thiệu
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.news.index') }}" class="nav-link {{ str_contains($currentPage, 'news') ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i> Tin Tức
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.reports.index') }}" class="nav-link {{ str_contains($currentPage, 'reports') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i> Thống Kê Doanh Thu
                    </a>
                </li>
                @endif
                
                <div class="sidebar-heading">Hệ Thống</div>
                
                @if(Auth::user()->isAdmin())
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ str_contains($currentPage, 'settings') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Cài Đặt Website
                    </a>
                </li>
                @endif
                
                <li class="nav-item">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                            <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
                <p class="topbar-title ms-2">@yield('title', 'Dashboard')</p>
            </div>
            
            <div class="topbar-right">
                <div class="dropdown">
                    <div class="notification-bell" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        @if($pendingOrdersCount + $pendingCommentsCount > 0)
                            <span class="notification-badge">{{ $pendingOrdersCount + $pendingCommentsCount }}</span>
                        @endif
                    </div>
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown" style="min-width: 320px; max-height: 400px; overflow-y: auto;">
                        <h6 class="dropdown-header">
                            <i class="fas fa-bell me-2"></i>Thông báo
                        </h6>
                        @php
                            $latestComments = \App\Models\Comment::where('trangthai', 'Chờ duyệt')
                                ->with(['product', 'user'])
                                ->orderBy('ngaytao', 'desc')
                                ->take(5)
                                ->get();
                        @endphp
                        @if($latestComments->count() > 0)
                            @foreach($latestComments as $comment)
                                <a class="dropdown-item py-2" href="{{ route('admin.comments.index') }}">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-size: 0.8rem;">
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <div class="small fw-bold text-truncate" style="max-width: 200px;">{{ $comment->product->tenmon ?? 'Sản phẩm' }}</div>
                                            <div class="small text-muted">{{ $comment->user->hoten ?? 'User' }} - {{ $comment->danhgia }} sao</div>
                                            <div class="small text-muted">{{ $comment->ngaytao->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @elseif($pendingOrdersCount > 0)
                            <a class="dropdown-item py-2" href="{{ route('admin.orders.index') }}">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <div class="ms-2">
                                        <div class="small fw-bold">{{ $pendingOrdersCount }} đơn hàng chờ xác nhận</div>
                                    </div>
                                </div>
                            </a>
                        @else
                            <div class="dropdown-item text-center text-muted py-3">
                                <i class="fas fa-check-circle fa-2x mb-2"></i>
                                <div>Không có thông báo mới</div>
                            </div>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center small" href="{{ $pendingOrdersCount > 0 ? route('admin.orders.index') : route('admin.comments.index') }}">
                            <i class="fas fa-eye me-1"></i>Xem tất cả
                        </a>
                    </div>
                </div>
                
                <div class="topbar-user">
                    <div class="topbar-user-info">
                        <div class="name">{{ Auth::user()->hoten }}</div>
                        <div class="email">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="topbar-avatar">
                        {{ strtoupper(substr(Auth::user()->hoten, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <!-- Confirm Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="confirmModalTitle">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Xác nhận
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="mb-0" id="confirmModalMessage">Bạn có chắc chắn muốn thực hiện hành động này?</p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Hủy
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmModalBtn">
                        <i class="fas fa-check me-1"></i>Xác nhận
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Toast Notification Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div id="adminToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <i class="toast-icon me-2"></i>
                    <span class="toast-message"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    
    <style>
        /* Toast Styles */
        #adminToast {
            min-width: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        #adminToast.toast-error {
            background: linear-gradient(135deg, #e91e63, #c2185b);
            color: #fff;
        }
        #adminToast.toast-success {
            background: linear-gradient(135deg, #4caf50, #388e3c);
            color: #fff;
        }
        #adminToast.toast-warning {
            background: linear-gradient(135deg, #ff9800, #f57c00);
            color: #fff;
        }
        #adminToast.toast-info {
            background: linear-gradient(135deg, #2196f3, #1976d2);
            color: #fff;
        }
        #adminToast .toast-body {
            font-size: 0.9rem;
            font-weight: 500;
            padding: 12px 15px;
        }
        #adminToast .toast-icon {
            font-size: 1.1rem;
        }
    </style>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile menu toggle
        const mobileBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (mobileBtn) {
            mobileBtn.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }
        
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
        
        // Global Toast Notification Function
        function showToast(message, type = 'error') {
            const toast = document.getElementById('adminToast');
            const toastMessage = toast.querySelector('.toast-message');
            const toastIcon = toast.querySelector('.toast-icon');
            
            // Remove previous type classes
            toast.classList.remove('toast-error', 'toast-success', 'toast-warning', 'toast-info');
            toast.classList.add('toast-' + type);
            
            // Set icon based on type
            const icons = {
                'error': 'fas fa-exclamation-circle',
                'success': 'fas fa-check-circle',
                'warning': 'fas fa-exclamation-triangle',
                'info': 'fas fa-info-circle'
            };
            toastIcon.className = 'toast-icon me-2 ' + (icons[type] || icons['error']);
            
            // Set message
            toastMessage.textContent = message;
            
            // Show toast
            const bsToast = new bootstrap.Toast(toast, { autohide: true, delay: 4000 });
            bsToast.show();
        }
        
        // Make showToast globally available
        window.showToast = showToast;
        
        // Custom Confirm Modal Function
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        let confirmCallback = null;
        
        function showConfirm(message, callback, title = 'Xác nhận') {
            document.getElementById('confirmModalMessage').textContent = message;
            document.getElementById('confirmModalTitle').innerHTML = '<i class="fas fa-exclamation-triangle text-warning me-2"></i>' + title;
            confirmCallback = callback;
            confirmModal.show();
        }
        
        document.getElementById('confirmModalBtn').addEventListener('click', function() {
            confirmModal.hide();
            if (confirmCallback) {
                confirmCallback();
            }
        });
        
        // Auto-attach to delete forms with data-confirm attribute
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form[data-confirm]').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const message = this.dataset.confirm;
                    const self = this;
                    showConfirm(message, function() {
                        self.submit();
                    });
                });
            });
            
            // For buttons with data-confirm
            document.querySelectorAll('[data-confirm-btn]').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const message = this.dataset.confirmBtn;
                    const callback = this.dataset.callback;
                    showConfirm(message, function() {
                        if (callback) {
                            eval(callback);
                        }
                    });
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
