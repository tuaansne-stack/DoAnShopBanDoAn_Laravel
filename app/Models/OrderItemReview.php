
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'hoadon_id',
        'order_item_id',
        'monan_id',
        'user_id',
        'rating',
        'content',
        'images',
        'tags',
        'is_anonymous',
    ];

    protected $casts = [
        'images' => 'array',
        'tags' => 'array',
        'is_anonymous' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'hoadon_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'monan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reply()
    {
        return $this->hasOne(OrderItemReviewReply::class, 'review_id');
    }
}

