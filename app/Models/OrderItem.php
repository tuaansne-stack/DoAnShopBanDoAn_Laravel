<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'chitiethoadon';

    protected $fillable = [
        'hoadon_id',
        'monan_id',
        'soluong',
        'gia',
    ];

    protected $casts = [
        'soluong' => 'integer',
        'gia' => 'decimal:2',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'hoadon_id');
    }

    /**
     * Get the product that owns the order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'monan_id');
    }

    /**
     * Get the total price for this order item.
     */
    public function getTotalAttribute()
    {
        return $this->soluong * $this->gia;
    }
}

