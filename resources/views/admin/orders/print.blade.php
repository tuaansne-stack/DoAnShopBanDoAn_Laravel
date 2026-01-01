<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Preview - Đơn hàng #{{ $order->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .print-header {
            background: #fff;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .print-header h4 {
            margin: 0;
            font-weight: 600;
        }
        .invoice-container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .invoice-title {
            text-align: center;
            color: #1976d2;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .invoice-meta {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }
        .invoice-meta .order-date {
            color: #1976d2;
        }
        .info-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .info-card-header {
            background: #f8f9fa;
            padding: 10px 15px;
            font-weight: 600;
            border-bottom: 1px solid #e0e0e0;
            border-radius: 8px 8px 0 0;
        }
        .info-card-body {
            padding: 15px;
        }
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
        .products-table th {
            background: #f8f9fa;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #666;
        }
        .products-table td {
            vertical-align: middle;
        }
        .product-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
        }
        .summary-row {
            display: flex;
            justify-content: flex-end;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .summary-row:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.1rem;
        }
        .summary-label {
            width: 150px;
            text-align: right;
            padding-right: 20px;
        }
        .summary-value {
            width: 100px;
            text-align: right;
            color: #333;
        }
        .badge-paid {
            background: #d4edda;
            color: #155724;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
        }
        .badge-unpaid {
            background: #fff3cd;
            color: #856404;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
        }
        .thank-you {
            text-align: center;
            color: #1976d2;
            font-style: italic;
            margin: 30px 0 20px;
        }
        .signature-section {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
            padding-top: 20px;
        }
        .signature-box {
            text-align: center;
        }
        .signature-box .title {
            font-weight: 600;
            margin-bottom: 60px;
        }
        .signature-box .sign-line {
            color: #999;
            font-style: italic;
            font-size: 0.85rem;
        }

        @media print {
            @page {
                margin: 5mm;
                size: A4;
            }
            body { 
                background: #fff; 
                font-size: 11px;
            }
            .print-header { display: none !important; }
            .invoice-container {
                box-shadow: none;
                margin: 0;
                padding: 10px;
                max-width: 100%;
            }
            .invoice-title { font-size: 1.4rem; margin-bottom: 0; }
            .invoice-meta { margin-bottom: 15px; }
            .info-card { margin-bottom: 10px; }
            .info-card-header { padding: 6px 10px; font-size: 0.85rem; }
            .info-card-body { padding: 8px 10px; }
            .customer-avatar { width: 35px; height: 35px; font-size: 0.9rem; }
            .products-table th, .products-table td { padding: 5px 8px; font-size: 0.8rem; }
            .product-img { width: 30px; height: 30px; }
            .summary-row { padding: 4px 0; font-size: 0.85rem; }
            .thank-you { margin: 15px 0 10px; font-size: 0.9rem; }
            .signature-section { margin-top: 20px; padding-top: 10px; }
            .signature-box .title { margin-bottom: 40px; font-size: 0.85rem; }
            .signature-box .sign-line { font-size: 0.75rem; }
        }
    </style>
</head>
<body>
    <!-- Print Header (Not printed) -->
    <div class="print-header">
        <h4>Print Preview</h4>
        <div>
            <button class="btn btn-primary me-2" onclick="window.print()">
                <i class="fas fa-print me-1"></i> Print
            </button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i> Close
            </a>
        </div>
    </div>

    <!-- Invoice Content -->
    <div class="invoice-container">
        <h1 class="invoice-title">HÓA ĐƠN ĐẶT HÀNG</h1>
        <div class="invoice-meta">
            <div>Mã đơn hàng: <strong>#{{ $order->id }}</strong></div>
            <div class="order-date">Ngày đặt: {{ $order->ngaylap->format('d/m/Y H:i') }}</div>
        </div>

        <!-- Customer & Shipping Info -->
        <div class="row">
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header">Thông tin khách hàng</div>
                    <div class="info-card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="customer-avatar me-3">
                                {{ strtoupper(substr($order->user->hoten ?? 'K', 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold">{{ $order->user->hoten ?? 'N/A' }}</div>
                                <small class="text-muted">Khách hàng thành viên</small>
                            </div>
                        </div>
                        <div><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</div>
                        <div><strong>Số điện thoại:</strong> {{ $order->user->sdt ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header">Thông tin giao hàng</div>
                    <div class="info-card-body">
                        <div><strong>Người nhận:</strong> {{ $order->user->hoten ?? 'N/A' }}</div>
                        <div><strong>Số điện thoại:</strong> {{ $order->user->sdt ?? 'N/A' }}</div>
                        <div><strong>Địa chỉ:</strong> {{ $order->diachi_giaohang ?? 'N/A' }}</div>
                        <div><strong>Ghi chú:</strong> {{ $order->ghichu ?? 'Không có' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="info-card">
            <div class="info-card-header">Sản phẩm đặt mua</div>
            <div class="info-card-body p-0">
                <table class="table products-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Ảnh</th>
                            <th>Sản phẩm</th>
                            <th class="text-center" style="width: 100px;">Đơn giá</th>
                            <th class="text-center" style="width: 80px;">Số lượng</th>
                            <th class="text-end" style="width: 120px;">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    @if($item->product && $item->product->hinhanh)
                                        <img src="/storage/uploads/{{ $item->product->hinhanh }}" class="product-img">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 6px;">
                                            <i class="fas fa-utensils text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $item->product->tenmon ?? 'N/A' }}</td>
                                <td class="text-center">{{ number_format($item->gia, 0, ',', '.') }} đ</td>
                                <td class="text-center text-primary fw-bold">{{ $item->soluong }}</td>
                                <td class="text-end">{{ number_format($item->gia * $item->soluong, 0, ',', '.') }} đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="p-3">
                    @php
                        $subtotal = $order->orderItems->sum(fn($i) => $i->gia * $i->soluong);
                        $shipping = $order->shippingMethod->gia_vanchuyen ?? 0;
                    @endphp
                    <div class="summary-row">
                        <div class="summary-label">Tạm tính:</div>
                        <div class="summary-value">{{ number_format($subtotal, 0, ',', '.') }} đ</div>
                    </div>
                    <div class="summary-row">
                        <div class="summary-label">Phí vận chuyển:</div>
                        <div class="summary-value">{{ number_format($shipping, 0, ',', '.') }} đ</div>
                    </div>
                    <div class="summary-row">
                        <div class="summary-label">Tổng cộng:</div>
                        <div class="summary-value text-danger">{{ number_format($order->tongtien, 0, ',', '.') }} đ</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="info-card">
            <div class="info-card-header">Thông tin thanh toán</div>
            <div class="info-card-body">
                <div><strong>Phương thức thanh toán:</strong> {{ $order->paymentMethod->ten_pttt ?? 'N/A' }}</div>
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

        <!-- Thank You -->
        <p class="thank-you">Cảm ơn bạn đã mua hàng tại Food Shop!</p>

        <!-- Signature -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="title">Người mua hàng</div>
                <div class="sign-line">(Ký, ghi rõ họ tên)</div>
            </div>
            <div class="signature-box">
                <div class="title">Người bán hàng</div>
                <div class="sign-line">(Ký, ghi rõ họ tên)</div>
            </div>
        </div>
    </div>
</body>
</html>
