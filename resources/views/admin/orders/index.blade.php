@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')

@section('content')
<!-- Order Status Cards -->
<div class="row mb-4">
    <div class="col">
        <div class="order-stat-card pending">
            <div class="stat-label">Chờ xác nhận</div>
            <div class="stat-number">{{ $orderStats['pending'] }}</div>
            <a href="{{ route('admin.orders.index', ['status' => 'Chờ xác nhận']) }}" class="stat-link">Xem tất cả</a>
        </div>
    </div>
    <div class="col">
        <div class="order-stat-card confirmed">
            <div class="stat-label">Đã xác nhận</div>
            <div class="stat-number">{{ $orderStats['confirmed'] }}</div>
            <a href="{{ route('admin.orders.index', ['status' => 'Đã xác nhận']) }}" class="stat-link">Xem tất cả</a>
        </div>
    </div>
    <div class="col">
        <div class="order-stat-card shipping">
            <div class="stat-label">Đang giao</div>
            <div class="stat-number">{{ $orderStats['shipping'] }}</div>
            <a href="{{ route('admin.orders.index', ['status' => 'Đang giao']) }}" class="stat-link">Xem tất cả</a>
        </div>
    </div>
    <div class="col">
        <div class="order-stat-card completed">
            <div class="stat-label">Hoàn tất</div>
            <div class="stat-number">{{ $orderStats['completed'] }}</div>
            <a href="{{ route('admin.orders.index', ['status' => 'Hoàn tất']) }}" class="stat-link">Xem tất cả</a>
        </div>
    </div>
    <div class="col">
        <div class="order-stat-card canceled">
            <div class="stat-label">Đã hủy</div>
            <div class="stat-number">{{ $orderStats['canceled'] }}</div>
            <a href="{{ route('admin.orders.index', ['status' => 'Đã hủy']) }}" class="stat-link">Xem tất cả</a>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Mã đơn hàng, tên khách hàng..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="Chờ xác nhận" {{ request('status') == 'Chờ xác nhận' ? 'selected' : '' }}>Chờ xác nhận</option>
                    <option value="Đã xác nhận" {{ request('status') == 'Đã xác nhận' ? 'selected' : '' }}>Đã xác nhận</option>
                    <option value="Đang giao" {{ request('status') == 'Đang giao' ? 'selected' : '' }}>Đang giao</option>
                    <option value="Hoàn tất" {{ request('status') == 'Hoàn tất' ? 'selected' : '' }}>Hoàn tất</option>
                    <option value="Đã hủy" {{ request('status') == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Từ ngày</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Đến ngày</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-pink me-2">
                    <i class="fas fa-filter me-1"></i> Lọc
                </button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo me-1"></i> Đặt lại
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Orders Table -->
<div class="card">
    <div class="card-header">
        <span>Danh sách đơn hàng</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="width: 100px;">Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th style="width: 120px;">Ngày đặt</th>
                        <th style="width: 120px;">Tổng tiền</th>
                        <th style="width: 130px;">Thanh toán</th>
                        <th style="width: 110px;">Trạng thái</th>
                        <th style="width: 100px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><strong class="text-primary">#{{ $order->id }}</strong></td>
                            <td>{{ $order->user->hoten ?? 'N/A' }}</td>
                            <td>
                                <div>{{ $order->ngaylap->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $order->ngaylap->format('H:i') }}</small>
                            </td>
                            <td>
                                <strong class="text-danger">{{ number_format($order->tongtien, 0, ',', '.') }} đ</strong>
                            </td>
                            <td>
                                @if($order->dathanhtoan)
                                    <span class="badge badge-paid">Đã thanh toán</span>
                                @else
                                    <span class="badge badge-unpaid">Chưa thanh toán</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = match($order->trangthai) {
                                        'Chờ xác nhận' => 'badge-pending',
                                        'Đã xác nhận' => 'badge-confirmed',
                                        'Đang giao' => 'badge-shipping',
                                        'Hoàn tất' => 'badge-completed',
                                        'Đã hủy' => 'badge-canceled',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $order->trangthai }}</span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-action-view" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <div class="dropdown d-inline">
                                        <button class="btn btn-action-settings" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if($order->trangthai == 'Chờ xác nhận')
                                                <li>
                                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Đã xác nhận">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-check me-1 text-success"></i> Xác nhận đơn hàng
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" data-confirm="Bạn có chắc muốn hủy đơn hàng này?">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Đã hủy">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-times me-1 text-danger"></i> Hủy đơn hàng
                                                        </button>
                                                    </form>
                                                </li>
                                            @elseif($order->trangthai == 'Đã xác nhận')
                                                <li>
                                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Đang giao">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-truck me-1 text-info"></i> Chuyển sang đang giao
                                                        </button>
                                                    </form>
                                                </li>
                                            @elseif($order->trangthai == 'Đang giao')
                                                <li>
                                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Hoàn tất">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-check-circle me-1 text-success"></i> Đánh dấu hoàn tất
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.orders.print', $order->id) }}" target="_blank">
                                                    <i class="fas fa-print me-1"></i> In đơn hàng
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                <p class="mb-0">Không có đơn hàng nào.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
        <div class="card-footer bg-white">
            {{ $orders->withQueryString()->links('vendor.pagination.admin') }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .order-stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border-top: 3px solid;
    }
    .order-stat-card.pending { border-top-color: #ffc107; }
    .order-stat-card.pending .stat-number { color: #ffc107; }
    .order-stat-card.confirmed { border-top-color: #17a2b8; }
    .order-stat-card.confirmed .stat-number { color: #17a2b8; }
    .order-stat-card.shipping { border-top-color: #6f42c1; }
    .order-stat-card.shipping .stat-number { color: #6f42c1; }
    .order-stat-card.completed { border-top-color: #28a745; }
    .order-stat-card.completed .stat-number { color: #28a745; }
    .order-stat-card.canceled { border-top-color: #dc3545; }
    .order-stat-card.canceled .stat-number { color: #dc3545; }
    
    .stat-label { font-size: 0.85rem; color: #666; margin-bottom: 5px; }
    .stat-number { font-size: 2rem; font-weight: 700; }
    .stat-link { font-size: 0.75rem; color: #888; text-decoration: none; }
    .stat-link:hover { color: #ff69b4; }

    .badge-paid { background: #d4edda; color: #155724; padding: 6px 12px; border-radius: 20px; font-weight: 500; }
    .badge-unpaid { background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 20px; font-weight: 500; }
    
    .badge-pending { background: #fff3cd; color: #856404; }
    .badge-confirmed { background: #cce5ff; color: #004085; }
    .badge-shipping { background: #e2d5f1; color: #5a3d8a; }
    .badge-completed { background: #d4edda; color: #155724; }
    .badge-canceled { background: #f8d7da; color: #721c24; }

    .btn-action-settings {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #666;
        padding: 6px 10px;
        border-radius: 6px;
    }
    .btn-action-settings:hover { background: #e9ecef; }
    
    /* Order Stats Responsive */
    @media (max-width: 768px) {
        .row.mb-4 {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -4px;
        }
        .row.mb-4 > .col {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 4px;
        }
        .row.mb-4 > .col:nth-child(5) {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .order-stat-card {
            padding: 12px 8px;
            border-radius: 8px;
        }
        .stat-label { font-size: 0.7rem; }
        .stat-number { font-size: 1.4rem; }
        .stat-link { font-size: 0.65rem; }
    }
    
    @media (max-width: 576px) {
        .row.mb-4 > .col,
        .row.mb-4 > .col:nth-child(5) {
            flex: 0 0 50%;
            max-width: 50%;
        }
        .order-stat-card {
            padding: 10px 6px;
        }
        .stat-label { font-size: 0.6rem; }
        .stat-number { font-size: 1.2rem; }
        .stat-link { font-size: 0.55rem; }
    }
</style>
@endpush
