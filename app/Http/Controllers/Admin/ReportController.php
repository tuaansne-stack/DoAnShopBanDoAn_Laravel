<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate = $request->end_date ?? date('Y-m-d');
        $viewType = $request->view_type ?? 'day';

        // Get sales data based on view type
        if ($viewType == 'day') {
            $salesData = Order::select(
                    DB::raw('DATE(ngaylap) as date'),
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(tongtien) as revenue')
                )
                ->whereBetween('ngaylap', [$startDate, $endDate . ' 23:59:59'])
                ->whereIn('trangthai', ['Đã xác nhận', 'Đang giao', 'Hoàn tất'])
                ->groupBy(DB::raw('DATE(ngaylap)'))
                ->orderBy('date')
                ->get();
        } elseif ($viewType == 'week') {
            $salesData = Order::select(
                    DB::raw('YEARWEEK(ngaylap, 3) as yearweek'),
                    DB::raw('MIN(DATE(ngaylap)) as week_start'),
                    DB::raw('MAX(DATE(ngaylap)) as week_end'),
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(tongtien) as revenue')
                )
                ->whereBetween('ngaylap', [$startDate, $endDate . ' 23:59:59'])
                ->whereIn('trangthai', ['Đã xác nhận', 'Đang giao', 'Hoàn tất'])
                ->groupBy(DB::raw('YEARWEEK(ngaylap, 3)'))
                ->orderBy('yearweek')
                ->get();
        } else {
            $salesData = Order::select(
                    DB::raw('YEAR(ngaylap) as year'),
                    DB::raw('MONTH(ngaylap) as month'),
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(tongtien) as revenue')
                )
                ->whereBetween('ngaylap', [$startDate, $endDate . ' 23:59:59'])
                ->whereIn('trangthai', ['Đã xác nhận', 'Đang giao', 'Hoàn tất'])
                ->groupBy(DB::raw('YEAR(ngaylap)'), DB::raw('MONTH(ngaylap)'))
                ->orderBy('year')
                ->orderBy('month')
                ->get();
        }

        // Calculate totals
        $totalRevenue = $salesData->sum('revenue');
        $totalOrders = $salesData->sum('order_count');
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Total products sold
        $totalProductsSold = DB::table('chitiethoadon')
            ->join('hoadon', 'chitiethoadon.hoadon_id', '=', 'hoadon.id')
            ->whereBetween('hoadon.ngaylap', [$startDate, $endDate . ' 23:59:59'])
            ->whereIn('hoadon.trangthai', ['Đã xác nhận', 'Đang giao', 'Hoàn tất'])
            ->sum('chitiethoadon.soluong');

        // Format chart data
        $chartLabels = [];
        $chartRevenues = [];
        $chartOrders = [];

        foreach ($salesData as $data) {
            if ($viewType == 'day') {
                $chartLabels[] = date('d/m', strtotime($data->date));
            } elseif ($viewType == 'week') {
                $chartLabels[] = date('d/m', strtotime($data->week_start)) . ' - ' . date('d/m', strtotime($data->week_end));
            } else {
                $chartLabels[] = sprintf('%02d/%d', $data->month, $data->year);
            }
            $chartRevenues[] = (float) $data->revenue;
            $chartOrders[] = (int) $data->order_count;
        }

        // Top 5 selling products
        $topProducts = DB::table('chitiethoadon')
            ->join('monan', 'chitiethoadon.monan_id', '=', 'monan.id')
            ->join('hoadon', 'chitiethoadon.hoadon_id', '=', 'hoadon.id')
            ->whereBetween('hoadon.ngaylap', [$startDate, $endDate . ' 23:59:59'])
            ->whereIn('hoadon.trangthai', ['Đã xác nhận', 'Đang giao', 'Hoàn tất'])
            ->select(
                'monan.id',
                'monan.tenmon',
                DB::raw('SUM(chitiethoadon.soluong) as total_quantity'),
                DB::raw('SUM(chitiethoadon.soluong * chitiethoadon.gia) as total_revenue')
            )
            ->groupBy('monan.id', 'monan.tenmon')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'viewType',
            'salesData',
            'totalRevenue',
            'totalOrders',
            'avgOrderValue',
            'totalProductsSold',
            'chartLabels',
            'chartRevenues',
            'chartOrders',
            'topProducts'
        ));
    }
}
