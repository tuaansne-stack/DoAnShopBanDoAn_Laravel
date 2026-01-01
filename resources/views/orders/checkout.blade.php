@extends('layouts.app')

@section('title', 'Thanh toán đơn hàng')

@section('content')
<section class="checkout-section py-5">
    <div class="container">
        <form id="checkoutForm" method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div class="row">
                <!-- Thông tin thanh toán và giao hàng -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Thông tin giao hàng</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="name" value="{{ $user->hoten }}" readonly>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->sdt ?? '' }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea>
                                <div class="form-text">Vui lòng nhập địa chỉ đầy đủ, chi tiết để việc giao hàng được thuận lợi.</div>
                            </div>

                            <div class="mb-3">
                                <label for="order_notes" class="form-label">Ghi chú đơn hàng</label>
                                <textarea class="form-control" id="order_notes" name="order_notes" rows="3" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay địa điểm giao hàng chi tiết hơn.">{{ old('order_notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Phương thức vận chuyển</h4>
                        </div>
                        <div class="card-body">
                            @foreach($shippingMethods as $method)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="shipping_method" id="shipping_{{ $method->id }}" value="{{ $method->id }}"
                                        {{ $loop->first ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-between" for="shipping_{{ $method->id }}">
                                        <span>{{ $method->ten_ptvc }}</span>
                                        <span class="fw-bold">{{ format_currency($method->gia_vanchuyen) }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Phương thức thanh toán</h4>
                        </div>
                        <div class="card-body">
                        @foreach($paymentMethods as $method)
                                <div class="form-check mb-3">
                                    <input class="form-check-input payment-method-radio" type="radio" name="payment_method" id="payment_{{ $method->id }}" value="{{ $method->id }}"
                                        {{ $loop->first ? 'checked' : '' }}
                                        data-payment-type="{{ $method->id }}">
                                    <label class="form-check-label" for="payment_{{ $method->id }}">
                                        {{ $method->ten_pttt }}
                                    </label>
                                </div>

                                {{-- Bank transfer info removed from checkout as per user request --}}
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Tổng đơn hàng -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Đơn hàng của bạn</h4>
                        </div>
                        <div class="card-body">
                            <div class="order-summary">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold">Sản phẩm</span>
                                    <span class="fw-bold">Thành tiền</span>
                                </div>

                                <hr>

                                @foreach($cartItems as $item)
                                    <div class="checkout-item mb-2">
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $item->product->tenmon }} <span class="text-muted">× {{ $item->soluong }}</span></span>
                                            <span>{{ format_currency($item->total) }}</span>
                                        </div>
                                        @if($item->toppings->count() > 0)
                                        <div class="checkout-item-toppings ms-3">
                                            @foreach($item->toppings as $topping)
                                            <small class="text-muted">+ {{ $topping->tentopping }} (+{{ number_format($topping->gia) }}đ)</small><br>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                @endforeach

                                <hr>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tạm tính:</span>
                                    <span>{{ format_currency($subtotal) }}</span>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Phí vận chuyển:</span>
                                    <span id="shipping-fee">{{ format_currency($shippingFee) }}</span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between mb-4">
                                    <span class="h5">Tổng cộng:</span>
                                    <span class="h5 text-primary" id="total-amount">{{ format_currency($total) }}</span>
                                </div>

                                <button type="submit" class="btn btn-gradient btn-lg w-100">
                                    <i class="fas fa-check-circle me-2"></i>Đặt hàng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment method radio handling (bank transfer info removed)

        // Cập nhật phí vận chuyển và tổng tiền
        const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
        const shippingFeeElement = document.getElementById('shipping-fee');
        const totalAmountElement = document.getElementById('total-amount');
        const subtotal = {{ $subtotal }};

        shippingRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedShippingMethod = document.querySelector('input[name="shipping_method"]:checked');
                const label = selectedShippingMethod.nextElementSibling;
                const shippingFeeText = label.querySelector('span:last-child').textContent;
                const shippingFee = parseInt(shippingFeeText.replace(/\D/g, ''));

                // Cập nhật phí vận chuyển hiển thị
                shippingFeeElement.textContent = new Intl.NumberFormat('vi-VN').format(shippingFee) + ' đ';

                // Cập nhật tổng tiền
                const total = subtotal + shippingFee;
                totalAmountElement.textContent = new Intl.NumberFormat('vi-VN').format(total) + ' đ';
            });
        });
    });
</script>
@endpush

@push('styles')
<style>
    .bank-info-card {
        background: #f8fbff;
        border: 2px solid #4facfe;
        border-radius: 12px;
    }
    .qr-code-checkout {
        max-width: 180px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
</style>
@endpush
@endsection

