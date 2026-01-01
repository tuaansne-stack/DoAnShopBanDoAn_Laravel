@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<section class="order-detail-section py-5">
    <div class="container">
        <!-- Order Info & Shipping Info -->
        <div class="row mb-4">
            <!-- Order Info -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h6 class="mb-0"><i class="fas fa-file-invoice me-2 text-primary"></i>Thông tin đơn hàng</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td class="text-muted" style="width: 160px;">Mã đơn hàng:</td>
                                <td class="fw-bold text-primary">#{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Ngày đặt hàng:</td>
                                <td>{{ $order->ngaylap ? $order->ngaylap->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tổng tiền:</td>
                                <td class="fw-bold text-danger">{{ format_currency($order->tongtien) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Phương thức thanh toán:</td>
                                <td class="text-primary">{{ $order->paymentMethod->ten_pttt ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Trạng thái thanh toán:</td>
                                <td>
                                    @if($order->dathanhtoan)
                                        <span class="payment-badge paid">Đã thanh toán</span>
                                    @else
                                        <span class="payment-badge unpaid">Chưa thanh toán</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Trạng thái đơn hàng:</td>
                                <td>
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
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Shipping Info -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h6 class="mb-0"><i class="fas fa-truck me-2 text-primary"></i>Thông tin giao hàng</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td class="text-muted" style="width: 160px;">Phương thức vận chuyển:</td>
                                <td class="text-primary">{{ $order->shippingMethod->ten_ptvc ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Người nhận:</td>
                                <td class="fw-bold">{{ $order->user->hoten ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Số điện thoại:</td>
                                <td>{{ $order->user->sdt ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Địa chỉ giao hàng:</td>
                                <td>{{ $order->diachi_giaohang ?? 'N/A' }}</td>
                            </tr>
                            @if($order->ghichu)
                            <tr>
                                <td class="text-muted">Ghi chú:</td>
                                <td>{{ $order->ghichu }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bank Transfer Payment Section (if not paid) -->
        @if(!$order->dathanhtoan)
            @php
                $bankInfo = \Illuminate\Support\Facades\DB::table('thongtinthanhtoan')->first();
            @endphp
            @if($bankInfo)
                <div class="payment-section mb-4">
                    <div class="payment-header d-flex justify-content-between align-items-center p-3">
                        <div>
                            <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Thanh toán đơn hàng</h5>
                            <small>Vui lòng thanh toán đơn hàng để đẩy nhanh quá trình xử lý.</small>
                        </div>
                        <span class="btn-bank-transfer">
                            <i class="fas fa-university me-1"></i> Thanh toán qua ngân hàng
                        </span>
                    </div>
                    
                    <div class="payment-content p-4">
                        <h6 class="text-primary mb-3"><i class="fas fa-info-circle me-1"></i> Thông tin chuyển khoản</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td class="text-muted py-2" style="width: 160px;"><strong>Ngân hàng:</strong></td>
                                        <td class="py-2">{{ $bankInfo->ten_nganhang }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-2"><strong>Số tài khoản:</strong></td>
                                        <td class="py-2 fw-bold text-primary fs-5">{{ $bankInfo->so_taikhoan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-2"><strong>Chủ tài khoản:</strong></td>
                                        <td class="py-2 fw-bold">{{ $bankInfo->ten_chutaikhoan }}</td>
                                    </tr>
                                    @if($bankInfo->chi_nhanh)
                                    <tr>
                                        <td class="text-muted py-2"><strong>Chi nhánh:</strong></td>
                                        <td class="py-2">{{ $bankInfo->chi_nhanh }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="text-muted py-2"><strong>Số tiền:</strong></td>
                                        <td class="py-2 fw-bold text-danger fs-5">{{ format_currency($order->tongtien) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-2"><strong>Nội dung CK:</strong></td>
                                        <td class="py-2"><span class="badge bg-light text-dark border px-3 py-2 fs-6">FOODSHOP{{ $order->id }}</span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 text-center d-flex flex-column justify-content-center">
                                <p class="text-muted mb-2">Quét mã QR để thanh toán</p>
                                @if($bankInfo->ma_nganhang)
                                    <img src="https://img.vietqr.io/image/{{ $bankInfo->ma_nganhang }}-{{ $bankInfo->so_taikhoan }}-compact2.jpg?amount={{ $order->tongtien }}&addInfo=FOODSHOP{{ $order->id }}&accountName={{ urlencode($bankInfo->ten_chutaikhoan) }}" 
                                         alt="QR Code" class="qr-code-img mx-auto">
                                @endif
                            </div>
                        </div>
                        <div class="alert alert-info mt-3 mb-0 d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <span>Sau khi chuyển khoản, vui lòng liên hệ với chúng tôi để xác nhận thanh toán nhanh chóng.</span>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <!-- Products Table -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-shopping-basket me-2 text-primary"></i>Chi tiết đơn hàng</h6>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th colspan="2">Sản phẩm</th>
                            <th class="text-center" style="width: 100px;">Số lượng</th>
                            <th class="text-end" style="width: 120px;">Đơn giá</th>
                            <th class="text-end" style="width: 130px;">Thành tiền</th>
                            @if($order->trangthai == 'Hoàn tất')
                                <th class="text-center" style="width: 100px;">Đánh giá</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            @php
                                $hasReviewed = \App\Models\Comment::where('user_id', auth()->id())
                                    ->where('monan_id', $item->product->id ?? 0)
                                    ->where('hoadon_id', $order->id)
                                    ->exists();
                            @endphp
                            <tr>
                                <td style="width: 60px;">
                                    @if($item->product && $item->product->display_image)
                                        <img src="/storage/uploads/{{ $item->product->display_image }}" style="width: 45px; height: 45px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; border-radius: 8px;">
                                            <i class="fas fa-utensils text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-primary align-middle">{{ $item->product->tenmon ?? 'N/A' }}</td>
                                <td class="text-center align-middle">{{ $item->soluong }}</td>
                                <td class="text-end align-middle">{{ format_currency($item->gia) }}</td>
                                <td class="text-end align-middle text-primary fw-bold">{{ format_currency($item->gia * $item->soluong) }}</td>
                                @if($order->trangthai == 'Hoàn tất')
                                    <td class="text-center align-middle">
                                        @if($hasReviewed)
                                            <span class="reviewed-badge"><i class="fas fa-check"></i> Đã đánh giá</span>
                                        @else
                                            <button type="button" class="review-btn" 
                                                    data-product-id="{{ $item->product->id ?? 0 }}"
                                                    data-product-name="{{ $item->product->tenmon ?? '' }}">
                                                <i class="fas fa-star"></i> Đánh giá
                                            </button>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        @php
                            $subtotal = $order->orderItems->sum(fn($i) => $i->gia * $i->soluong);
                            $shipping = $order->shippingMethod->gia_vanchuyen ?? 0;
                        @endphp
                        <tr>
                            <td colspan="4" class="text-end"><strong>Tổng giá trị sản phẩm:</strong></td>
                            <td class="text-end">{{ format_currency($subtotal) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Phí vận chuyển:</strong></td>
                            <td class="text-end">{{ format_currency($shipping) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Tổng thanh toán:</strong></td>
                            <td class="text-end text-danger fw-bold fs-5">{{ format_currency($order->tongtien) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
            </a>
            <div class="d-flex gap-2">
                @if(in_array($order->trangthai, ['Chờ xác nhận', 'Đã xác nhận']))
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                        <i class="fas fa-times me-1"></i> Hủy đơn hàng
                    </button>
                @endif
                @if($order->trangthai == 'Hoàn tất')
                    <form method="POST" action="{{ route('orders.reorder', $order->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-gradient">
                            <i class="fas fa-redo me-1"></i> Đặt lại đơn hàng
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Cancel Order Modal -->
@if(in_array($order->trangthai, ['Chờ xác nhận', 'Đã xác nhận']))
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>Xác nhận hủy đơn hàng
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-box-open fa-3x text-danger mb-3"></i>
                <h5>Bạn có chắc chắn muốn hủy đơn hàng #{{ $order->id }}?</h5>
                <p class="text-muted mb-0">Sau khi hủy, bạn không thể hoàn tác hành động này.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Không, giữ đơn hàng
                </button>
                <form method="POST" action="{{ route('orders.cancel', $order->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash me-1"></i> Có, hủy đơn hàng
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@push('styles')
<style>
    .order-status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.8rem;
    }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-confirmed { background: #cce5ff; color: #004085; }
    .status-shipping { background: #e2d5f1; color: #5a3d8a; }
    .status-completed { background: #d4edda; color: #155724; }
    .status-canceled { background: #f8d7da; color: #721c24; }
    
    .payment-badge { padding: 4px 10px; border-radius: 15px; font-size: 0.8rem; }
    .payment-badge.paid { background: #d4edda; color: #155724; }
    .payment-badge.unpaid { background: #fff3cd; color: #856404; }
    
    /* Bank Transfer Payment Section */
    .payment-section {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        overflow: hidden;
    }
    .payment-header {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        color: white;
    }
    .payment-header small {
        opacity: 0.9;
    }
    .btn-bank-transfer {
        background: white;
        color: #4facfe;
        padding: 8px 16px;
        border-radius: 25px;
        font-weight: 500;
        font-size: 0.85rem;
    }
    .payment-content {
        background: #f8fbff;
        border: 2px solid #4facfe;
        border-top: none;
        border-radius: 0 0 12px 12px;
    }
    .qr-code-img {
        max-width: 220px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .table tfoot tr:last-child td {
        border-bottom: none;
    }
    
    /* ===== STAR RATING - CLEAN DESIGN ===== */
    .star-rating-box {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 8px;
    }
    .star-rating-box input[type="radio"] {
        display: none;
    }
    .star-rating-box label {
        font-size: 2rem;
        color: #e0e0e0;
        cursor: pointer;
    }
    .star-rating-box label:hover,
    .star-rating-box label:hover ~ label {
        color: #ffc107;
    }
    .star-rating-box input:checked ~ label {
        color: #ffc107;
    }
    
    /* Review Button */
    .review-btn {
        background: none;
        border: 1px solid #ff5c8d;
        color: #ff5c8d;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        cursor: pointer;
    }
    .review-btn:hover {
        background: #ff5c8d;
        color: #fff;
    }
    .reviewed-badge {
        background: #d4edda;
        color: #155724;
        font-size: 0.7rem;
        padding: 4px 8px;
        border-radius: 4px;
    }
    
    /* Review Modal */
    #reviewModal .modal-content {
        border-radius: 12px;
        border: none;
    }
    #reviewModal .modal-header {
        padding: 1rem 1.5rem;
    }
    #reviewModal .modal-body {
        padding: 1rem 1.5rem;
    }
    #reviewModal .modal-footer {
        padding: 1rem 1.5rem;
    }
    #reviewModal .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    #reviewModal .form-control:focus {
        border-color: #ff5c8d;
        box-shadow: 0 0 0 2px rgba(255, 92, 141, 0.1);
    }
    
    /* Submit Review Button - No effects */
    .submit-review-btn {
        background: #ff5c8d;
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
    }
    .submit-review-btn:hover {
        background: #e84d7b;
    }
    
    /* Responsive Order Detail */
    @media (max-width: 768px) {
        .order-detail-section { padding: 1.5rem 0; }
        .order-detail-section .card { margin-bottom: 1rem; }
        .order-detail-section .card-header h6 { font-size: 0.9rem; }
        .order-detail-section .table { font-size: 0.75rem; }
        .order-detail-section .table td,
        .order-detail-section .table th { padding: 6px 4px; white-space: nowrap; }
        .order-detail-section .table img { width: 32px !important; height: 32px !important; }
        .order-status-badge { font-size: 0.7rem; padding: 4px 8px; }
        .payment-badge { font-size: 0.7rem; }
        .payment-header { flex-direction: column; text-align: center; gap: 10px; }
        .payment-header h5 { font-size: 1rem; }
        .btn-bank-transfer { font-size: 0.75rem; padding: 6px 12px; }
        .payment-content { padding: 1rem !important; }
        .payment-content .table td { padding: 6px 0; font-size: 0.8rem; }
        .qr-code-img { max-width: 160px; }
        .review-btn { font-size: 0.65rem; padding: 3px 6px; }
        .star-rating-box label { font-size: 1.5rem; }
        .order-detail-section .table thead th:nth-child(4),
        .order-detail-section .table tbody td:nth-child(4) { display: none; }
    }
    
    @media (max-width: 576px) {
        .order-detail-section .container { padding: 0 10px; }
        .order-detail-section h6 { font-size: 0.85rem; }
        .order-detail-section .text-muted { font-size: 0.7rem; }
        .order-detail-section .table { font-size: 0.7rem; }
        .order-detail-section .table img { width: 28px !important; height: 28px !important; }
        .order-detail-section .btn { font-size: 0.8rem; padding: 8px 12px; }
        .d-flex.gap-2 { flex-direction: column; }
        .d-flex.gap-2 .btn { width: 100%; }
        .review-btn { font-size: 0.6rem; padding: 3px 5px; }
        .reviewed-badge { font-size: 0.55rem; padding: 3px 5px; }
        .star-rating-box label { font-size: 1.3rem; }
    }
</style>
@endpush

<!-- Review Modal -->
@if($order->trangthai == 'Hoàn tất')
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="reviewModalLabel">
                    <i class="fas fa-star text-warning me-2"></i>Đánh giá sản phẩm
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <form method="POST" action="{{ route('comments.store') }}">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="product_id" id="reviewProductId" value="">
                
                <div class="modal-body">
                    <p class="text-center mb-3" id="reviewProductName"></p>
                    
                    <!-- Star Rating -->
                    <div class="text-center mb-3">
                        <label class="form-label">Đánh giá của bạn</label>
                        <div class="star-rating-box">
                            <input type="radio" name="rating" id="star5" value="5" required>
                            <label for="star5"><i class="fas fa-star"></i></label>
                            <input type="radio" name="rating" id="star4" value="4">
                            <label for="star4"><i class="fas fa-star"></i></label>
                            <input type="radio" name="rating" id="star3" value="3">
                            <label for="star3"><i class="fas fa-star"></i></label>
                            <input type="radio" name="rating" id="star2" value="2">
                            <label for="star2"><i class="fas fa-star"></i></label>
                            <input type="radio" name="rating" id="star1" value="1">
                            <label for="star1"><i class="fas fa-star"></i></label>
                        </div>
                    </div>
                    
                    <!-- Comment -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Nhận xét của bạn</label>
                        <textarea class="form-control" name="content" id="content" rows="3" 
                                  placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này... (không bắt buộc)"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="submit-review-btn">
                        <i class="fas fa-paper-plane me-1"></i> Gửi đánh giá
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.review-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        this.blur();
        document.getElementById('reviewProductId').value = this.dataset.productId;
        document.getElementById('reviewProductName').innerHTML = '<strong>' + this.dataset.productName + '</strong>';
        document.querySelectorAll('.star-rating-box input').forEach(i => i.checked = false);
        document.getElementById('content').value = '';
        new bootstrap.Modal(document.getElementById('reviewModal')).show();
    });
});
</script>
@endpush
@endif
@endsection
