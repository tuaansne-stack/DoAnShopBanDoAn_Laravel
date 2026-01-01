<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'binhluan';

    protected $fillable = [
        'monan_id',
        'user_id',
        'hoadon_id',
        'noidung',
        'danhgia',
        'ngaytao',
        'trangthai',
    ];

    protected $casts = [
        'danhgia' => 'integer',
        'ngaytao' => 'datetime',
    ];

    /**
     * Get the product that owns the comment.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'monan_id');
    }

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the order that owns the comment.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'hoadon_id');
    }

    /**
     * Scope a query to only include approved comments.
     */
    public function scopeApproved($query)
    {
        return $query->where('trangthai', 'Đã duyệt');
    }
}

