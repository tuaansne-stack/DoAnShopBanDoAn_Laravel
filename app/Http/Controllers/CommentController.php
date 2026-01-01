<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment/review.
     * User can only review products from their completed orders.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:hoadon,id',
            'product_id' => 'required|integer|exists:monan,id',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        // Verify order belongs to user and is completed
        $order = Order::where('id', $request->order_id)
            ->where('user_id', $user->id)
            ->where('trangthai', 'Hoàn tất')
            ->first();

        if (!$order) {
            return back()->with('error', 'Bạn không thể đánh giá đơn hàng này.');
        }

        // Verify product is in this order
        $hasProduct = $order->orderItems()->where('monan_id', $request->product_id)->exists();
        if (!$hasProduct) {
            return back()->with('error', 'Sản phẩm không có trong đơn hàng này.');
        }

        // Check if already reviewed this product for this order
        $existingComment = Comment::where('user_id', $user->id)
            ->where('monan_id', $request->product_id)
            ->where('hoadon_id', $request->order_id)
            ->exists();

        if ($existingComment) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này trong đơn hàng này rồi.');
        }

        // Create comment
        Comment::create([
            'monan_id' => $request->product_id,
            'user_id' => $user->id,
            'hoadon_id' => $request->order_id,
            'danhgia' => $request->rating,
            'noidung' => $request->content,
            'ngaytao' => now(),
            'trangthai' => 'Chờ duyệt',
        ]);

        return back()->with('success', 'Đánh giá của bạn đã được gửi và đang chờ duyệt. Cảm ơn bạn!');
    }
}
