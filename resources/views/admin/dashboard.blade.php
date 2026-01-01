@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
</div>

<!-- Stats Cards -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card blue">
            <div class="stat-content">
                <p>Tổng Đơn Hàng</p>
                <h3>{{ number_format($totalOrders) }}</h3>
                <small><i class="fas fa-arrow-up text-success"></i> 0 đơn so với tháng trước</small>
            </div>
            <div class="stat-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card green">
            <div class="stat-content">
                <p>Doanh Thu</p>
                <h3>{{ number_format($totalRevenue, 0, ',', '.') }} đ</h3>
                <small><i class="fas fa-arrow-up text-success"></i> +12.8% so với tháng trước</small>
            </div>
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card yellow">
            <div class="stat-content">
                <p>Món Ăn</p>
                <h3>{{ number_format($totalProducts) }}</h3>
                <small><i class="fas fa-info-circle"></i> 0 món thêm mới tháng này</small>
            </div>
            <div class="stat-icon">
                <i class="fas fa-utensils"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card purple">
            <div class="stat-content">
                <p>Khách Hàng</p>
                <h3>{{ number_format($totalUsers) }}</h3>
                <small><i class="fas fa-users"></i> 0 khách so với tháng trước</small>
            </div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
</div>

<!-- Order Status Chart -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <span>Trạng thái đơn hàng</span>
            </div>
            <div class="card-body">
                <div style="height: 280px; display: flex; align-items: center; justify-content: center;">
                    <canvas id="orderStatusChart" style="max-width: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Popular Products -->
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <span>Đơn hàng gần đây</span>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-pink">xem tất cả</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Khách Hàng</th>
                                <th>Tổng Tiền</th>
                                <th>Trạng Thái</th>
                                <th>Ngày Đặt</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->hoten ?? 'N/A' }}</td>
                                    <td>{{ number_format($order->tongtien, 0, ',', '.') }} đ</td>
                                    <td>
                                        @php
                                            $badgeClass = match($order->trangthai) {
                                                'Chờ xác nhận' => 'badge-pending',
                                                'Đã xác nhận' => 'badge-confirmed',
                                                'Đang giao' => 'badge-shipping',
                                                'Hoàn tất' => 'badge-completed',
                                                'Đã hủy' => 'badge-canceled',
                                                default => 'badge-pending'
                                            };
                                        @endphp
                                        <span class="badge-status {{ $badgeClass }}">{{ $order->trangthai }}</span>
                                    </td>
                                    <td>{{ $order->ngaylap->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-action-view">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Không có đơn hàng nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <span>Món ăn phổ biến</span>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-pink">xem tất cả</a>
            </div>
            <div class="card-body">
                @forelse($popularProducts as $product)
                    <div class="popular-item">
                        @if($product->display_image)
                            <img src="/storage/uploads/{{ $product->display_image }}" alt="{{ $product->tenmon }}">
                        @else
                            <div class="product-img-placeholder">
                                <i class="fas fa-utensils"></i>
                            </div>
                        @endif
                        <div class="info">
                            <h6>{{ $product->tenmon }}</h6>
                            <small>Đã bán: {{ number_format($product->quantity_sum ?? 0) }}</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-3">Chưa có dữ liệu.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('orderStatusChart');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($orderStatuses->pluck('trangthai')) !!},
            datasets: [{
                data: {!! json_encode($orderStatuses->pluck('count')) !!},
                backgroundColor: ['#ffc107', '#2196f3', '#e91e63', '#4caf50', '#f44336'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 20, font: { size: 12 } }
                }
            }
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    /* Dashboard Responsive */
    @media (max-width: 768px) {
        /* Stat cards 2 columns */
        .row > .col-xl-3 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 5px;
        }
        .stat-card {
            padding: 12px;
            margin-bottom: 0;
        }
        .stat-card .stat-content p { font-size: 0.65rem; margin-bottom: 2px; }
        .stat-card .stat-content h3 { font-size: 1rem; margin-bottom: 2px; }
        .stat-card .stat-content small { font-size: 0.55rem; display: block; }
        .stat-card .stat-icon { width: 28px; height: 28px; font-size: 0.8rem; }
        
        /* Chart smaller */
        #orderStatusChart { max-width: 280px !important; }
        
        /* Recent orders & Popular products - stack */
        .row > .col-xl-8,
        .row > .col-xl-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        /* Table compact */
        .table { font-size: 0.7rem; }
        .table th, .table td { padding: 6px 4px; }
        .badge-status { font-size: 0.55rem; padding: 3px 6px; }
        
        /* Popular items */
        .popular-item img { width: 35px; height: 35px; }
        .popular-item h6 { font-size: 0.75rem; }
        .popular-item small { font-size: 0.6rem; }
    }
    
    @media (max-width: 576px) {
        .page-title { font-size: 1rem; }
        .row > .col-xl-3 { padding: 3px; }
        .stat-card { padding: 10px 8px; border-radius: 8px; }
        .stat-card .stat-content h3 { font-size: 0.9rem; }
        .stat-card .stat-content p { font-size: 0.55rem; }
        .stat-card .stat-content small { font-size: 0.5rem; }
        .stat-card .stat-icon { width: 24px; height: 24px; font-size: 0.7rem; }
        
        #orderStatusChart { max-width: 220px !important; }
        
        .table { font-size: 0.65rem; }
        .table th, .table td { padding: 5px 3px; }
        .btn-action-view { 
            width: 24px; 
            height: 24px; 
            font-size: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        
        .card-header span { font-size: 0.8rem; }
        .btn-outline-pink { font-size: 0.6rem; padding: 3px 8px; }
    }
    
    @media (max-width: 400px) {
        .stat-card .stat-content h3 { font-size: 0.8rem; }
        .stat-card .stat-content small { display: none; }
    }
</style>
@endpush
