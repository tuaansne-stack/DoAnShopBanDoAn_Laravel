<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemReviewReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'store_id',
        'content',
    ];

    public function review()
    {
        return $this->belongsTo(OrderItemReview::class, 'review_id');
    }
}

