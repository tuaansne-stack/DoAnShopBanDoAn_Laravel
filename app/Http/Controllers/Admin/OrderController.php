<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Order::with(['user', 'paymentMethod', 'shippingMethod']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('trangthai', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status')) {
            if ($request->payment_status === '1') {
                $query->where('dathanhtoan', 1);
            } elseif ($request->payment_status === '0') {
                $query->where('dathanhtoan', 0);
            }
        }

        // Date filter
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('ngaylap', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('ngaylap', '<=', $request->to_date);
        }

        // Search by ID or customer name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('hoten', 'like', '%' . $search . '%');
                  });
            });
        }

        $orders = $query->orderBy('ngaylap', 'desc')->paginate(15);

        // Order status counts
        $orderStats = [
            'pending' => Order::where('trangthai', 'Chờ xác nhận')->count(),
            'confirmed' => Order::where('trangthai', 'Đã xác nhận')->count(),
            'shipping' => Order::where('trangthai', 'Đang giao')->count(),
            'completed' => Order::where('trangthai', 'Hoàn tất')->count(),
            'canceled' => Order::where('trangthai', 'Đã hủy')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'orderStats'));
    }

    public function show($id)
    {
        $order = Order::with([
            'user',
            'paymentMethod',
            'shippingMethod',
            'orderItems.product',
            'orderHistory'
        ])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function print($id)
    {
        $order = Order::with([
            'user',
            'paymentMethod',
            'shippingMethod',
            'orderItems.product'
        ])->findOrFail($id);

        return view('admin.orders.print', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $oldStatus = $order->trangthai;
        $newStatus = $request->status;

        if ($oldStatus === $newStatus) {
            return back()->with('info', 'Trạng thái không thay đổi.');
        }

        try {
            DB::beginTransaction();

            $order->update(['trangthai' => $newStatus]);

            OrderHistory::create([
                'hoadon_id' => $order->id,
                'trang_thai_cu' => $oldStatus,
                'trang_thai_moi' => $newStatus,
                'nguoi_thay_doi' => Auth::user()->hoten,
                'ghi_chu' => $request->note ?? null,
            ]);

            DB::commit();

            return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    public function updatePayment(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $order->update([
            'dathanhtoan' => $request->has('dathanhtoan') ? 1 : 0,
            'ma_giaodich' => $request->ma_giaodich ?? $order->ma_giaodich,
        ]);

        return back()->with('success', 'Cập nhật thanh toán thành công!');
    }

    public function export(Request $request)
    {
        $query = Order::with(['user', 'paymentMethod', 'shippingMethod', 'orderItems.product']);

        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('ngaylap', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('ngaylap', '<=', $request->to_date);
        }
        if ($request->has('status') && $request->status) {
            $query->where('trangthai', $request->status);
        }

        $orders = $query->orderBy('ngaylap', 'desc')->get();

        $filename = 'orders_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            
            fputcsv($file, ['Mã ĐH', 'Khách hàng', 'Điện thoại', 'Địa chỉ', 'Tổng tiền', 'Trạng thái', 'Thanh toán', 'Ngày đặt']);
            
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->user->hoten ?? 'N/A',
                    $order->user->sdt ?? 'N/A',
                    $order->diachi_giaohang,
                    number_format($order->tongtien, 0, ',', '.') . ' đ',
                    $order->trangthai,
                    $order->dathanhtoan ? 'Đã TT' : 'Chưa TT',
                    $order->ngaylap->format('d/m/Y H:i'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
