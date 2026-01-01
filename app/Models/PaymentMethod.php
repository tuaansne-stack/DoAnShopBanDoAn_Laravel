<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'phuongthucthanhtoan';

    protected $fillable = [
        'ten_pttt',
        'trangthai',
        'mota',
    ];

    protected $casts = [
        'trangthai' => 'boolean',
    ];

    /**
     * Get the orders for the payment method.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'pttt_id');
    }

    /**
     * Get the payment info for the payment method.
     */
    public function paymentInfo()
    {
        return $this->hasMany(PaymentInfo::class, 'pttt_id');
    }

    /**
     * Scope a query to only include active payment methods.
     */
    public function scopeActive($query)
    {
        return $query->where('trangthai', true);
    }
}

