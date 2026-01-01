<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\OrderItemReview;
use App\Models\OrderItemReviewReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    /**
     * POST /api/reviews
     */
    public function store(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'order_item_id' => ['required', 'exists:chitiethoadon,id'],
            'order_id' => ['required', 'exists:hoadon,id'],
            'product_id' => ['required', 'exists:monan,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'content' => ['nullable', 'string'],
            'images' => ['array', 'max:5'],
            'images.*' => ['string'],
            'tags' => ['array'],
            'tags.*' => ['string'],
            'is_anonymous' => ['boolean'],
        ]);

        // Check order item belongs to user and matches product/order
        $orderItem = OrderItem::with('order')
            ->where('id', $validated['order_item_id'])
            ->where('hoadon_id', $validated['order_id'])
            ->where('monan_id', $validated['product_id'])
            ->firstOrFail();

        if ($orderItem->order->user_id !== $userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn không thể đánh giá sản phẩm này.',
            ], 403);
        }

        // Only one review per order_item
        if (OrderItemReview::where('order_item_id', $orderItem->id)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn đã đánh giá món này rồi.',
            ], 422);
        }

        $review = OrderItemReview::create([
            'hoadon_id' => $orderItem->hoadon_id,
            'order_item_id' => $orderItem->id,
            'monan_id' => $orderItem->monan_id,
            'user_id' => $userId,
            'rating' => $validated['rating'],
            'content' => $validated['content'] ?? null,
            'images' => $validated['images'] ?? [],
            'tags' => $validated['tags'] ?? [],
            'is_anonymous' => $validated['is_anonymous'] ?? false,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã gửi đánh giá.',
            'review_id' => $review->id,
        ]);
    }

    /**
     * GET /api/reviews/product/{product_id}
     */
    public function productReviews($productId)
    {
        $reviews = OrderItemReview::with(['user', 'reply'])
            ->where('monan_id', $productId)
            ->latest()
            ->get();

        $total = $reviews->count();
        $average = $total > 0 ? round($reviews->avg('rating'), 1) : 0;
        $breakdown = [
            5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0
        ];
        foreach ($reviews as $r) {
            $breakdown[$r->rating] = ($breakdown[$r->rating] ?? 0) + 1;
        }

        $formatted = $reviews->map(function ($r) {
            return [
                'review_id' => $r->id,
                'order_item_id' => $r->order_item_id,
                'order_id' => $r->hoadon_id,
                'user' => [
                    'user_id' => $r->user_id,
                    'name' => $r->is_anonymous ? 'Ẩn danh' : ($r->user->hoten ?? $r->user->name ?? 'User'),
                    'avatar_url' => $r->is_anonymous ? null : ($r->user->avatar_url ?? null),
                    'is_anonymous' => $r->is_anonymous,
                ],
                'rating' => $r->rating,
                'content' => $r->content,
                'images' => $r->images ?? [],
                'tags' => $r->tags ?? [],
                'created_at' => $r->created_at,
                'store_reply' => $r->reply ? [
                    'reply_id' => $r->reply->id,
                    'content' => $r->reply->content,
                    'created_at' => $r->reply->created_at,
                ] : null,
            ];
        });

        return response()->json([
            'product_id' => $productId,
            'average_rating' => $average,
            'rating_breakdown' => $breakdown,
            'total_reviews' => $total,
            'reviews' => $formatted,
        ]);
    }

    /**
     * POST /api/reviews/{review_id}/reply
     */
    public function reply(Request $request, $reviewId)
    {
        $validated = $request->validate([
            'content' => ['required', 'string'],
        ]);

        $review = OrderItemReview::findOrFail($reviewId);

        if ($review->reply) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đánh giá này đã được phản hồi.',
            ], 422);
        }

        $reply = OrderItemReviewReply::create([
            'review_id' => $review->id,
            'store_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã phản hồi đánh giá.',
            'reply_id' => $reply->id,
        ]);
    }
}

