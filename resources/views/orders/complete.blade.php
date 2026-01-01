@extends('layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')
<section class="order-complete-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <i class="fas fa-check-circle fa-5x text-success"></i>
                        </div>
                        <h2 class="mb-3">Cảm ơn bạn đã đặt hàng!</h2>
                        <p class="lead mb-4">Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.</p>
                        
                        <div class="alert alert-info mb-4">
                            <strong>Mã đơn hàng:</strong> #{{ $order->id }}<br>
                            <strong>Tổng tiền:</strong> {{ format_currency($order->tongtien) }}
                        </div>

                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>Xem chi tiết đơn hàng
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-utensils me-2"></i>Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

