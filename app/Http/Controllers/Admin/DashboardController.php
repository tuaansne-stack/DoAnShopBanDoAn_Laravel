<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        // Total orders
        $totalOrders = Order::count();
        
        // Total revenue (excluding cancelled orders)
        $totalRevenue = Order::where('trangthai', '!=', 'Đã hủy')->sum('tongtien');
        
        // Total products
        $totalProducts = Product::count();
        
        // Total users (non-admin)
        $totalUsers = User::where('is_admin', 0)->count();
        
        // Recent orders with user info
        $recentOrders = Order::with('user')
            ->orderBy('ngaylap', 'desc')
            ->limit(5)
            ->get();
        
        // Order statuses for pie chart
        $orderStatuses = Order::select('trangthai', DB::raw('count(*) as count'))
            ->groupBy('trangthai')
            ->get();
        
        // Popular products - using subquery to avoid GROUP BY strict mode issue
        $popularProductIds = DB::table('chitiethoadon')
            ->join('hoadon', function($join) {
                $join->on('chitiethoadon.hoadon_id', '=', 'hoadon.id')
                    ->where('hoadon.trangthai', '!=', 'Đã hủy');
            })
            ->select('chitiethoadon.monan_id', DB::raw('SUM(chitiethoadon.soluong) as quantity_sum'))
            ->groupBy('chitiethoadon.monan_id')
            ->orderByDesc('quantity_sum')
            ->limit(5)
            ->get();
        
        $productIds = $popularProductIds->pluck('monan_id')->toArray();
        $productsMap = Product::whereIn('id', $productIds)->get()->keyBy('id');
        
        $popularProducts = $popularProductIds->map(function($item) use ($productsMap) {
            $product = $productsMap->get($item->monan_id);
            if ($product) {
                $product->quantity_sum = $item->quantity_sum;
                return $product;
            }
            return null;
        })->filter();
        
        // Pending counts for notifications
        $pendingOrdersCount = Order::where('trangthai', 'Chờ xác nhận')->count();
        $pendingCommentsCount = Comment::where('trangthai', 'Chờ duyệt')->count();
        
        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'totalUsers',
            'recentOrders',
            'orderStatuses',
            'popularProducts',
            'pendingOrdersCount',
            'pendingCommentsCount'
        ));
    }
}
