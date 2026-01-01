@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<section class="cart-section py-5">
    <div class="container">
        @if($cartItems->isEmpty())
            <!-- Giỏ hàng trống -->
            <div class="empty-cart text-center py-5">
                <div class="empty-cart-icon mb-4">
                    <i class="fas fa-shopping-cart fa-5x text-muted"></i>
                </div>
                <h3 class="mb-3">Giỏ hàng của bạn đang trống</h3>
                <p class="text-muted mb-4">Hãy thêm các món ăn bạn yêu thích vào giỏ hàng và quay lại đây để thanh toán.</p>
                <a href="{{ route('products.index') }}" class="btn btn-gradient btn-lg">
                    <i class="fas fa-utensils me-2"></i>Xem thực đơn ngay
                </a>
            </div>
        @else
            <div class="row">
                <!-- Danh sách sản phẩm -->
                <div class="col-lg-8 mb-4">
                    <div class="cart-items-card card shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-shopping-cart me-2 text-primary"></i>
                                    Giỏ hàng của bạn
                                </h5>
                                <span class="badge bg-primary" id="cart-items-count">{{ $cartItems->count() }} món</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @foreach($cartItems as $item)
                                <div class="cart-item" data-item-id="{{ $item->id }}">
                                    <div class="cart-item-content">
                                        <div class="cart-item-image">
                                            <a href="{{ route('products.show', $item->product->id) }}">
                                                <img src="{{ asset('storage/uploads/' . ($item->product->display_image ?: 'default-food.jpg')) }}" 
                                                    alt="{{ $item->product->tenmon }}" 
                                                    class="img-fluid">
                                            </a>
                                        </div>

                                        <!-- Thông tin sản phẩm -->
                                        <div class="cart-item-info">
                                            <h6 class="cart-item-title">
                                                <a href="{{ route('products.show', $item->product->id) }}">
                                                    {{ $item->product->tenmon }}
                                                </a>
                                            </h6>
                                            <div class="cart-item-price">
                                                {{ format_currency($item->product->gia) }}
                                            </div>
                                            @if($item->toppings->count() > 0)
                                            <div class="cart-item-toppings">
                                                @foreach($item->toppings as $topping)
                                                <span class="cart-topping-badge">
                                                    + {{ $topping->tentopping }} (+{{ number_format($topping->gia) }}đ)
                                                </span>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Điều khiển số lượng -->
                                        <div class="cart-item-quantity">
                                            <div class="quantity-control">
                                                <button type="button" class="qty-btn qty-minus btn-minus" title="Giảm">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" 
                                                    class="qty-input cart-quantity-input" 
                                                    value="{{ $item->soluong }}" 
                                                    min="1" 
                                                    max="10"
                                                    data-item-id="{{ $item->id }}">
                                                <button type="button" class="qty-btn qty-plus btn-plus" title="Tăng">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Thành tiền -->
                                        <div class="cart-item-subtotal">
                                            <div class="subtotal-label">Thành tiền</div>
                                            <div class="subtotal-value cart-item-subtotal">
                                                {{ format_currency($item->total) }}
                                            </div>
                                        </div>

                                        <!-- Nút xóa -->
                                        <div class="cart-item-actions">
                                            <button type="button" class="btn-remove remove-cart-item" data-item-id="{{ $item->id }}" title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="cart-actions-bar mt-3">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua hàng
                        </a>
                        <button type="button" id="clearCartBtn" class="btn btn-outline-danger">
                            <i class="fas fa-trash-alt me-2"></i>Xóa giỏ hàng
                        </button>
                    </div>
                </div>

                <!-- Tổng giỏ hàng -->
                <div class="col-lg-4">
                    <div class="cart-summary card shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-header bg-gradient text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-receipt me-2"></i>Tổng giỏ hàng
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="summary-row">
                                <span class="summary-label">Tạm tính</span>
                                <span class="summary-value" id="cart-total">{{ format_currency($cartTotal) }}</span>
                            </div>
                            <div class="summary-row text-muted">
                                <span class="summary-label">Phí vận chuyển</span>
                                <span class="summary-value">Tính ở bước tiếp theo</span>
                            </div>
                            <hr class="my-3">
                            <div class="summary-row summary-total">
                                <span class="summary-label">Tổng cộng</span>
                                <span class="summary-value text-primary fw-bold" id="cart-total-summary">{{ format_currency($cartTotal) }}</span>
                            </div>
                            <div class="d-grid gap-2 mt-4">
                                <a href="{{ route('orders.checkout') }}" class="btn btn-gradient btn-lg">
                                    <i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Modal xác nhận xóa giỏ hàng -->
<div class="modal fade" id="clearCartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Xác nhận xóa giỏ hàng
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa tất cả sản phẩm khỏi giỏ hàng?</p>
                <p class="text-muted small mb-0">Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" id="confirmClearCart" class="btn btn-danger">
                    <i class="fas fa-trash-alt me-2"></i>Xác nhận xóa
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
@endpush
@endsection
