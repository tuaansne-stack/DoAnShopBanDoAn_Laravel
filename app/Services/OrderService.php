<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderItem;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create order from cart.
     */
    public function createOrder($cartItems, $shippingAddress, $shippingMethodId, $paymentMethodId, $notes = null)
    {
        try {
            DB::beginTransaction();

            $subtotal = $cartItems->sum(function($item) {
                return $item->soluong * $item->product->gia;
            });

            $shippingMethod = ShippingMethod::findOrFail($shippingMethodId);
            $total = $subtotal + $shippingMethod->gia_vanchuyen;

            $order = Order::create([
                'user_id' => Auth::id(),
                'tongtien' => $total,
                'ghichu' => $notes,
                'diachi_giaohang' => $shippingAddress,
                'trangthai' => 'Chờ xác nhận',
                'pttt_id' => $paymentMethodId,
                'ptvc_id' => $shippingMethodId,
                'dathanhtoan' => false,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'hoadon_id' => $order->id,
                    'monan_id' => $item->monan_id,
                    'soluong' => $item->soluong,
                    'gia' => $item->product->gia,
                ]);
            }

            $this->addOrderHistory($order->id, null, 'Chờ xác nhận', Auth::user()->hoten, 'Đơn hàng mới được tạo');

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update order status.
     */
    public function updateOrderStatus($orderId, $newStatus, $changedBy, $note = null)
    {
        try {
            DB::beginTransaction();

            $order = Order::findOrFail($orderId);
            $oldStatus = $order->trangthai;

            $order->update(['trangthai' => $newStatus]);

            $this->addOrderHistory($orderId, $oldStatus, $newStatus, $changedBy, $note);

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Add order history.
     */
    public function addOrderHistory($orderId, $oldStatus, $newStatus, $changedBy, $note = null)
    {
        return OrderHistory::create([
            'hoadon_id' => $orderId,
            'trang_thai_cu' => $oldStatus,
            'trang_thai_moi' => $newStatus,
            'nguoi_thay_doi' => $changedBy,
            'ghi_chu' => $note,
        ]);
    }

    /**
     * Cancel order.
     */
    public function cancelOrder($orderId)
    {
        $order = Order::where('user_id', Auth::id())
            ->findOrFail($orderId);

        if (!in_array($order->trangthai, ['Chờ xác nhận', 'Đã xác nhận'])) {
            throw new \Exception('Không thể hủy đơn hàng ở trạng thái này.');
        }

        return $this->updateOrderStatus(
            $orderId,
            'Đã hủy',
            Auth::user()->hoten,
            'Khách hàng hủy đơn hàng'
        );
    }
}

