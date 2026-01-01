<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderItem;
use App\Models\PaymentInfo;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show checkout form.
     */
    public function checkout()
    {
        $cartItems = Cart::with(['product', 'toppings'])
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $user = Auth::user();
        $subtotal = $cartItems->sum(function($item) {
            return $item->total;
        });

        $paymentMethods = PaymentMethod::active()->get();
        $shippingMethods = ShippingMethod::active()->get();
        $bankInfo = PaymentInfo::all();

        $shippingFee = $shippingMethods->first()->gia_vanchuyen ?? 0;
        $total = $subtotal + $shippingFee;

        return view('orders.checkout', compact(
            'user', 'cartItems', 'subtotal', 'paymentMethods', 
            'shippingMethods', 'bankInfo', 'shippingFee', 'total'
        ));
    }

    /**
     * Place order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipping_method' => 'required|exists:phuongthucvanchuyen,id',
            'payment_method' => 'required|exists:phuongthucthanhtoan,id',
            'order_notes' => 'nullable|string',
        ]);

        $cartItems = Cart::with(['product', 'toppings'])
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        try {
            DB::beginTransaction();

            $subtotal = $cartItems->sum(function($item) {
                return $item->total;
            });

            $shippingMethod = ShippingMethod::findOrFail($request->shipping_method);
            $total = $subtotal + $shippingMethod->gia_vanchuyen;

            $order = Order::create([
                'user_id' => Auth::id(),
                'tongtien' => $total,
                'ghichu' => $request->order_notes,
                'diachi_giaohang' => $request->shipping_address,
                'trangthai' => 'Chờ xác nhận',
                'pttt_id' => $request->payment_method,
                'ptvc_id' => $request->shipping_method,
                'dathanhtoan' => false,
            ]);

            foreach ($cartItems as $item) {
                $orderItem = OrderItem::create([
                    'hoadon_id' => $order->id,
                    'monan_id' => $item->monan_id,
                    'soluong' => $item->soluong,
                    'gia' => $item->product->gia,
                ]);

                // Save toppings for this order item
                foreach ($item->toppings as $topping) {
                    DB::table('chitiethoadon_topping')->insert([
                        'chitiethoadon_id' => $orderItem->id,
                        'topping_id' => $topping->id,
                        'soluong' => $topping->pivot->soluong ?? 1,
                        'gia' => $topping->gia,
                    ]);
                }
            }

            OrderHistory::create([
                'hoadon_id' => $order->id,
                'trang_thai_cu' => null,
                'trang_thai_moi' => 'Chờ xác nhận',
                'nguoi_thay_doi' => Auth::user()->hoten,
                'ghi_chu' => 'Đơn hàng mới được tạo',
            ]);

            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('orders.complete', $order->id)
                ->with('success', 'Đặt hàng thành công! Cảm ơn bạn đã mua hàng tại chúng tôi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã xảy ra lỗi khi đặt hàng: ' . $e->getMessage());
        }
    }

    /**
     * Display user orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['paymentMethod', 'shippingMethod', 'orderItems.product'])
            ->where('user_id', Auth::id());

        // Filter by status if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('trangthai', $request->status);
        }

        $orders = $query->latest()->paginate(5);
        $user = Auth::user();

        return view('orders.index', compact('orders', 'user'));
    }

    /**
     * Display order details.
     */
    public function show($id)
    {
        $order = Order::with(['paymentMethod', 'shippingMethod', 'orderItems.product', 'orderHistory'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // Products the user already reviewed in this order
        $reviewedProductIds = \App\Models\Comment::where('user_id', Auth::id())
            ->where('hoadon_id', $order->id)
            ->pluck('monan_id')
            ->toArray();

        return view('orders.show', compact('order', 'reviewedProductIds'));
    }

    /**
     * Show order complete page.
     */
    public function complete($id)
    {
        $order = Order::with(['orderItems.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('orders.complete', compact('order'));
    }

    /**
     * Cancel order.
     */
    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->findOrFail($id);

        if (!in_array($order->trangthai, ['Chờ xác nhận', 'Đã xác nhận'])) {
            return back()->with('error', 'Không thể hủy đơn hàng ở trạng thái này.');
        }

        try {
            DB::beginTransaction();

            $order->update(['trangthai' => 'Đã hủy']);

            OrderHistory::create([
                'hoadon_id' => $order->id,
                'trang_thai_cu' => $order->getOriginal('trangthai'),
                'trang_thai_moi' => 'Đã hủy',
                'nguoi_thay_doi' => Auth::user()->hoten,
                'ghi_chu' => 'Khách hàng hủy đơn hàng',
            ]);

            DB::commit();

            return back()->with('success', 'Đã hủy đơn hàng thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã xảy ra lỗi khi hủy đơn hàng.');
        }
    }

    /**
     * Re-order.
     */
    public function reorder($id)
    {
        $oldOrder = Order::with('orderItems')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        try {
            DB::beginTransaction();

            foreach ($oldOrder->orderItems as $item) {
                $cartItem = Cart::where('user_id', Auth::id())
                    ->where('monan_id', $item->monan_id)
                    ->first();

                if ($cartItem) {
                    $newQuantity = min($cartItem->soluong + $item->soluong, 10);
                    $cartItem->update(['soluong' => $newQuantity]);
                } else {
                    Cart::create([
                        'user_id' => Auth::id(),
                        'monan_id' => $item->monan_id,
                        'soluong' => $item->soluong,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('cart.index')
                ->with('success', 'Đã thêm các sản phẩm vào giỏ hàng.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã xảy ra lỗi khi đặt lại đơn hàng.');
        }
    }

    /**
     * Submit review for order products.
     */
    public function review(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())
            ->findOrFail($id);

        // Check if order is completed or successful
        if (!in_array($order->trangthai, ['Hoàn tất', 'Đặt hàng thành công', 'Đã giao', 'Hoàn thành'])) {
            return back()->with('error', 'Chỉ có thể đánh giá đơn hàng đã hoàn tất.');
        }

        $request->validate([
            'product_id' => 'required|exists:monan,id',
            'review_content' => 'required|string|min:10',
        ]);

        // Get rating from the request (format: rating_{product_id})
        $ratingKey = 'rating_' . $request->product_id;
        $rating = $request->input($ratingKey);
        
        if (!$rating || !in_array($rating, [1, 2, 3, 4, 5])) {
            return back()->with('error', 'Vui lòng chọn đánh giá từ 1 đến 5 sao.');
        }

        // Check if product is in this order
        $orderItem = $order->orderItems()
            ->where('monan_id', $request->product_id)
            ->first();

        if (!$orderItem) {
            return back()->with('error', 'Sản phẩm không thuộc đơn hàng này.');
        }

        // Check if user already reviewed this product in this order
        $existingReview = \App\Models\Comment::where('monan_id', $request->product_id)
            ->where('user_id', Auth::id())
            ->where('hoadon_id', $order->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Sản phẩm này đã được bạn đánh giá trong đơn hàng này.');
        }

        // Create new review
        \App\Models\Comment::create([
            'monan_id' => $request->product_id,
            'user_id' => Auth::id(),
            'hoadon_id' => $order->id,
            'noidung' => $request->review_content,
            'danhgia' => $rating,
            'trangthai' => 'Đã duyệt', // Cho phép hiển thị ngay
        ]);
        $message = 'Cảm ơn bạn đã đánh giá! Đánh giá đã được ghi nhận.';

        return back()->with('success', $message);
    }
}

