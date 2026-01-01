@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<section class="orders-section py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <x-user-sidebar active="orders" />
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Bộ lọc trạng thái -->
                <div class="card mb-4">
                    <div class="card-body py-3">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('orders.index') }}" 
                                class="status-filter-btn {{ !request('status') ? 'active' : '' }}">
                                Tất cả
                            </a>
                            <a href="{{ route('orders.index', ['status' => 'Chờ xác nhận']) }}" 
                                class="status-filter-btn pending {{ request('status') == 'Chờ xác nhận' ? 'active' : '' }}">
                                Chờ xác nhận
                            </a>
                            <a href="{{ route('orders.index', ['status' => 'Đã xác nhận']) }}" 
                                class="status-filter-btn confirmed {{ request('status') == 'Đã xác nhận' ? 'active' : '' }}">
                                Đã xác nhận
                            </a>
                            <a href="{{ route('orders.index', ['status' => 'Đang giao']) }}" 
                                class="status-filter-btn shipping {{ request('status') == 'Đang giao' ? 'active' : '' }}">
                                Đang giao
                            </a>
                            <a href="{{ route('orders.index', ['status' => 'Hoàn tất']) }}" 
                                class="status-filter-btn completed {{ request('status') == 'Hoàn tất' ? 'active' : '' }}">
                                Hoàn tất
                            </a>
                            <a href="{{ route('orders.index', ['status' => 'Đã hủy']) }}" 
                                class="status-filter-btn canceled {{ request('status') == 'Đã hủy' ? 'active' : '' }}">
                                Đã hủy
                            </a>
                        </div>
                    </div>
                </div>

                @if($orders->count() > 0)
                    <!-- Danh sách đơn hàng -->
                    @foreach($orders as $order)
                        <div class="card order-card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h6 class="mb-0 fw-bold">Đơn hàng #{{ $order->id }}</h6>
                                    <small class="text-muted">{{ $order->ngaylap ? $order->ngaylap->format('d/m/Y H:i') : 'N/A' }}</small>
                                </div>
                                @php
                                    $statusClass = match($order->trangthai) {
                                        'Chờ xác nhận' => 'status-pending',
                                        'Đã xác nhận' => 'status-confirmed',
                                        'Đang giao' => 'status-shipping',
                                        'Hoàn tất' => 'status-completed',
                                        'Đã hủy' => 'status-canceled',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="order-status-badge {{ $statusClass }}">{{ $order->trangthai }}</span>
                            </div>
                            <div class="card-body">
                                <!-- Products Preview -->
                                <div class="products-preview mb-3">
                                    @foreach($order->orderItems->take(2) as $item)
                                        <div class="product-item d-flex align-items-center mb-2">
                                            @if($item->product && $item->product->hinhanh)
                                                <img src="/storage/uploads/{{ $item->product->hinhanh }}" class="product-thumb me-3">
                                            @else
                                                <div class="product-thumb-placeholder me-3">
                                                    <i class="fas fa-utensils"></i>
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <div class="fw-medium">{{ $item->product->tenmon ?? 'N/A' }}</div>
                                                <small class="text-muted">x{{ $item->soluong }}</small>
                                            </div>
                                            <div class="text-end">
                                                <span class="text-primary">{{ format_currency($item->gia * $item->soluong) }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($order->orderItems->count() > 2)
                                        <div class="text-muted small">
                                            <i class="fas fa-ellipsis-h me-1"></i>
                                            và {{ $order->orderItems->count() - 2 }} sản phẩm khác
                                        </div>
                                    @endif
                                </div>

                                <hr class="my-2">

                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="text-muted">Tổng tiền:</span>
                                        <span class="fw-bold text-danger fs-5 ms-2">{{ format_currency($order->tongtien) }}</span>
                                    </div>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i> Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Phân trang -->
                    <div class="mt-4">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- Không có đơn hàng -->
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-shopping-bag fa-4x text-muted"></i>
                            </div>
                            <h4 class="mb-3">Bạn chưa có đơn hàng nào</h4>
                            <p class="text-muted mb-4">Hãy khám phá các món ăn và đặt đơn hàng đầu tiên của bạn ngay hôm nay.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-gradient">
                                <i class="fas fa-utensils me-2"></i>Xem thực đơn ngay
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .status-filter-btn {
        padding: 8px 16px;
        border-radius: 20px;
        background: #f8f9fa;
        color: #666;
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .status-filter-btn:hover { background: #e9ecef; color: #333; }
    .status-filter-btn.active { background: linear-gradient(135deg, #ff69b4, #ff1493); color: #fff; }
    .status-filter-btn.pending.active { background: #ffc107; color: #000; }
    .status-filter-btn.confirmed.active { background: #17a2b8; color: #fff; }
    .status-filter-btn.shipping.active { background: #6f42c1; color: #fff; }
    .status-filter-btn.completed.active { background: #28a745; color: #fff; }
    .status-filter-btn.canceled.active { background: #dc3545; color: #fff; }

    .order-card { 
        border: none; 
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s;
    }
    .order-card:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.12); transform: translateY(-2px); }
    .order-card .card-header { background: #f8f9fa; border-bottom: 1px solid #eee; }

    .order-status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.8rem;
    }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-confirmed { background: #cce5ff; color: #004085; }
    .status-shipping { background: #e2d5f1; color: #5a3d8a; }
    .status-completed { background: #d4edda; color: #155724; }
    .status-canceled { background: #f8d7da; color: #721c24; }

    .product-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
    }
    .product-thumb-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
    }
</style>
@endpush
@endsection
