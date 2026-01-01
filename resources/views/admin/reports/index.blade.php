@extends('admin.layouts.app')

@section('title', 'Thống Kê Doanh Thu')

@section('content')
<div class="page-header">
    <h1 class="page-title">Thống Kê Doanh Thu</h1>
</div>

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Từ ngày</label>
                <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Đến ngày</label>
                <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Kiểu xem</label>
                <select class="form-select" name="view_type">
                    <option value="day" {{ $viewType == 'day' ? 'selected' : '' }}>Theo ngày</option>
                    <option value="week" {{ $viewType == 'week' ? 'selected' : '' }}>Theo tuần</option>
                    <option value="month" {{ $viewType == 'month' ? 'selected' : '' }}>Theo tháng</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-1"></i> Lọc dữ liệu
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="stat-card blue">
            <div class="stat-content">
                <p>Tổng Doanh Thu</p>
                <h3>{{ number_format($totalRevenue, 0, ',', '.') }} đ</h3>
            </div>
            <div class="stat-icon">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-6">
        <div class="stat-card green">
            <div class="stat-content">
                <p>Tổng Số Đơn Hàng</p>
                <h3>{{ number_format($totalOrders) }}</h3>
            </div>
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-6">
        <div class="stat-card purple">
            <div class="stat-content">
                <p>Tổng Sản Phẩm Bán Được</p>
                <h3>{{ number_format($totalProductsSold) }}</h3>
            </div>
            <div class="stat-icon">
                <i class="fas fa-utensils"></i>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Chart -->
<div class="card mb-4">
    <div class="card-header">
        <span>Biểu đồ doanh thu</span>
    </div>
    <div class="card-body">
        <div style="height: 350px;">
            <canvas id="revenueChart"></canvas>
        </div>
        <div class="text-center mt-3">
            <span class="me-3"><span style="display:inline-block;width:12px;height:12px;background:rgba(255,105,180,0.7);margin-right:5px;"></span> Doanh thu (nghìn VNĐ)</span>
            <span><span style="display:inline-block;width:12px;height:12px;background:rgba(78,205,196,0.7);margin-right:5px;"></span> Số đơn hàng</span>
        </div>
    </div>
</div>

<!-- Top Products & Product Details -->
<div class="row mb-4">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header">
                <span>Top 5 món ăn bán chạy</span>
            </div>
            <div class="card-body">
                <div style="height: 280px;">
                    <canvas id="topProductsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <span>Chi tiết top 5 món ăn</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Món ăn</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-utensils text-muted small"></i>
                                            </div>
                                            {{ $product->tenmon }}
                                        </div>
                                    </td>
                                    <td class="text-center">{{ number_format($product->total_quantity) }}</td>
                                    <td class="text-end">{{ number_format($product->total_revenue, 0, ',', '.') }} đ</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">Không có dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales Report Table -->
<div class="card">
    <div class="card-header">
        <span>Báo cáo doanh thu chi tiết</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th class="text-center">Số đơn hàng</th>
                        <th class="text-end">Doanh thu</th>
                        <th class="text-end">Trung bình/đơn</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salesData as $data)
                        <tr>
                            <td>
                                @if($viewType == 'day')
                                    {{ date('d/m/Y', strtotime($data->date)) }}
                                @elseif($viewType == 'week')
                                    {{ date('d/m/Y', strtotime($data->week_start)) }} - {{ date('d/m/Y', strtotime($data->week_end)) }}
                                @else
                                    {{ sprintf('%02d/%d', $data->month, $data->year) }}
                                @endif
                            </td>
                            <td class="text-center">{{ number_format($data->order_count) }}</td>
                            <td class="text-end">{{ number_format($data->revenue, 0, ',', '.') }} đ</td>
                            <td class="text-end">{{ $data->order_count > 0 ? number_format($data->revenue / $data->order_count, 0, ',', '.') : 0 }} đ</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Không có dữ liệu trong khoảng thời gian này</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($salesData->count() > 0)
                    <tfoot>
                        <tr class="fw-bold bg-light">
                            <td>Tổng cộng</td>
                            <td class="text-center">{{ number_format($totalOrders) }}</td>
                            <td class="text-end">{{ number_format($totalRevenue, 0, ',', '.') }} đ</td>
                            <td class="text-end">{{ number_format($avgOrderValue, 0, ',', '.') }} đ</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Doanh thu (nghìn VNĐ)',
                data: {!! json_encode(array_map(function($v) { return $v / 1000; }, $chartRevenues)) !!},
                backgroundColor: 'rgba(255, 105, 180, 0.7)',
                borderColor: '#ff69b4',
                borderWidth: 1
            }, {
                label: 'Số đơn hàng',
                data: {!! json_encode($chartOrders) !!},
                type: 'line',
                backgroundColor: 'rgba(78, 205, 196, 0.7)',
                borderColor: '#4ecdc4',
                borderWidth: 2,
                yAxisID: 'y1',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Biểu đồ doanh thu và số lượng đơn hàng'
                },
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Doanh thu (nghìn VNĐ)' }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    title: { display: true, text: 'Số đơn hàng' },
                    grid: { drawOnChartArea: false }
                }
            }
        }
    });

    // Top Products Chart
    const productsCtx = document.getElementById('topProductsChart');
    new Chart(productsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topProducts->pluck('tenmon')) !!},
            datasets: [{
                label: 'Số lượng bán ra',
                data: {!! json_encode($topProducts->pluck('total_quantity')) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { beginAtZero: true }
            }
        }
    });
});
</script>
@endpush
