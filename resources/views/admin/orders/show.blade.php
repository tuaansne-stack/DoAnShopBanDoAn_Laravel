@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title mb-0">Đơn hàng #{{ $order->id }}</h1>
        <small class="text-primary">Ngày đặt: {{ $order->ngaylap ? $order->ngaylap->format('d/m/Y H:i') : 'N/A' }}</small>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Quay lại
        </a>
        <a href="{{ route('admin.orders.print', $order->id) }}" class="btn btn-outline-primary" target="_blank">
            <i class="fas fa-print me-1"></i> In đơn hàng
        </a>
        
        @if($order->trangthai == 'Chờ xác nhận')
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="Đã xác nhận">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check me-1"></i> Xác nhận đơn hàng
                </button>
            </form>
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="d-inline" data-confirm="Bạn có chắc muốn hủy đơn hàng này?">
                @csrf
                <input type="hidden" name="status" value="Đã hủy">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-times me-1"></i> Hủy đơn hàng
                </button>
            </form>
        @elseif($order->trangthai == 'Đã xác nhận')
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="Đang giao">
                <button type="submit" class="btn btn-info text-white">
                    <i class="fas fa-truck me-1"></i> Chuyển sang đang giao
                </button>
            </form>
        @elseif($order->trangthai == 'Đang giao')
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="Hoàn tất">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle me-1"></i> Đánh dấu hoàn tất
                </button>
            </form>
        @endif
        
        @if(!$order->dathanhtoan && $order->trangthai != 'Đã hủy')
            <form action="{{ route('admin.orders.payment', $order->id) }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="dathanhtoan" value="1">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-dollar-sign me-1"></i> Xác nhận thanh toán
                </button>
            </form>
        @endif
    </div>
</div>

<!-- Customer & Shipping Info -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <span>Thông tin khách hàng</span>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="customer-avatar me-3">
                        {{ strtoupper(substr($order->user->hoten ?? 'K', 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-bold text-primary">{{ $order->user->hoten ?? 'N/A' }}</div>
                        <small class="text-muted">Khách hàng thành viên</small>
                    </div>
                </div>
                <div class="mb-2"><strong>Email:</strong> <span class="text-primary">{{ $order->user->email ?? 'N/A' }}</span></div>
                <div><strong>Số điện thoại:</strong> <span class="text-primary">{{ $order->user->sdt ?? 'N/A' }}</span></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <span>Thông tin giao hàng</span>
            </div>
            <div class="card-body">
                <div class="mb-2"><strong>Người nhận:</strong> <span class="text-primary">{{ $order->user->hoten ?? 'N/A' }}</span></div>
                <div class="mb-2"><strong>Số điện thoại:</strong> <span class="text-primary">{{ $order->user->sdt ?? 'N/A' }}</span></div>
                <div class="mb-2"><strong>Địa chỉ:</strong> <span class="text-muted">{{ $order->diachi_giaohang ?? 'N/A' }}</span></div>
                <div><strong>Ghi chú:</strong> <span class="text-muted">{{ $order->ghichu ?? 'Không có' }}</span></div>
            </div>
        </div>
    </div>
</div>

<!-- Products -->
<div class="card mb-4">
    <div class="card-header">
        <span>Sản phẩm đặt mua</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;">Ảnh</th>
                        <th>Sản phẩm</th>
                        <th class="text-end" style="width: 120px;">Đơn giá</th>
                        <th class="text-center" style="width: 100px;">Số lượng</th>
                        <th class="text-end" style="width: 130px;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td>
                                @if($item->product && $item->product->hinhanh)
                                    <img src="/storage/uploads/{{ $item->product->hinhanh }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 6px;">
                                        <i class="fas fa-utensils text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="text-primary">{{ $item->product->tenmon ?? 'N/A' }}</td>
                            <td class="text-end">{{ number_format($item->gia, 0, ',', '.') }} đ</td>
                            <td class="text-center">{{ $item->soluong }}</td>
                            <td class="text-end text-primary">{{ number_format($item->gia * $item->soluong, 0, ',', '.') }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @php
            $subtotal = $order->orderItems->sum(fn($i) => $i->gia * $i->soluong);
            $shipping = $order->shippingMethod->gia_vanchuyen ?? 0;
        @endphp
        <div class="p-3 border-top">
            <div class="d-flex justify-content-end mb-2">
                <div style="width: 150px;" class="text-end"><strong>Tạm tính:</strong></div>
                <div style="width: 130px;" class="text-end text-primary">{{ number_format($subtotal, 0, ',', '.') }} đ</div>
            </div>
            <div class="d-flex justify-content-end mb-2">
                <div style="width: 150px;" class="text-end"><strong>Phí vận chuyển:</strong></div>
                <div style="width: 130px;" class="text-end text-primary">{{ number_format($shipping, 0, ',', '.') }} đ</div>
            </div>
            <div class="d-flex justify-content-end">
                <div style="width: 150px;" class="text-end"><strong>Tổng cộng:</strong></div>
                <div style="width: 130px;" class="text-end text-danger fw-bold fs-5">{{ number_format($order->tongtien, 0, ',', '.') }} đ</div>
            </div>
        </div>
    </div>
</div>

<!-- Payment & History -->
<div class="row">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <span>Thông tin thanh toán</span>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Phương thức thanh toán:</strong> 
                    <span class="text-primary">{{ $order->paymentMethod->ten_pttt ?? 'N/A' }}</span>
                </div>
                <div>
                    <strong>Trạng thái thanh toán:</strong>
                    @if($order->dathanhtoan)
                        <span class="badge badge-paid">Đã thanh toán</span>
                    @else
                        <span class="badge badge-unpaid">Chưa thanh toán</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <span>Lịch sử đơn hàng</span>
            </div>
            <div class="card-body">
                @php
                    // Xác định các trạng thái đã hoàn thành dựa trên trạng thái hiện tại
                    $statusOrder = ['Chờ xác nhận', 'Đã xác nhận', 'Đang giao', 'Hoàn tất'];
                    $currentIndex = array_search($order->trangthai, $statusOrder);
                    if ($currentIndex === false) $currentIndex = -1; // Đã hủy
                    
                    // Lấy thời gian từ lịch sử
                    $historyTimes = [];
                    if ($order->orderHistory) {
                        foreach ($order->orderHistory as $h) {
                            $historyTimes[$h->trang_thai_moi] = $h->created_at;
                        }
                    }
                @endphp
                
                <div class="order-timeline">
                    @if($order->trangthai == 'Đã hủy')
                        <div class="timeline-item">
                            <div class="timeline-dot" style="background: #dc3545;"></div>
                            <div class="timeline-content">
                                <div class="fw-bold text-danger">Đã hủy</div>
                                <small class="text-muted">{{ isset($historyTimes['Đã hủy']) && $historyTimes['Đã hủy'] ? $historyTimes['Đã hủy']->format('d/m/Y H:i') : '' }}</small>
                                <div class="text-muted small">Đơn hàng đã bị hủy</div>
                            </div>
                        </div>
                    @else
                        @foreach($statusOrder as $index => $status)
                            @if($index <= $currentIndex)
                                @php
                                    $dotColor = match($status) {
                                        'Hoàn tất' => '#28a745',
                                        'Đang giao' => '#6f42c1',
                                        'Đã xác nhận' => '#17a2b8',
                                        default => '#ffc107'
                                    };
                                    $time = $historyTimes[$status] ?? ($status == 'Chờ xác nhận' ? $order->ngaylap : null);
                                @endphp
                                <div class="timeline-item">
                                    <div class="timeline-dot" style="background: {{ $dotColor }};"></div>
                                    <div class="timeline-content">
                                        <div class="fw-bold" style="color: {{ $dotColor }};">{{ $status }}</div>
                                        <small class="text-muted">{{ $time ? $time->format('d/m/Y H:i') : '' }}</small>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .customer-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.2rem;
        font-weight: 600;
    }
    .badge-paid { background: #d4edda; color: #155724; padding: 6px 12px; border-radius: 20px; }
    .badge-unpaid { background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 20px; }
    
    .order-timeline {
        position: relative;
        padding-left: 25px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 15px;
        border-left: 2px solid #e0e0e0;
        padding-left: 20px;
        margin-left: 5px;
    }
    .timeline-item:last-child {
        border-left: none;
        padding-bottom: 0;
    }
    .timeline-dot {
        position: absolute;
        left: -8px;
        top: 0;
        width: 14px;
        height: 14px;
        border-radius: 50%;
    }
    .timeline-content {
        margin-top: -3px;
    }
</style>
@endpush
