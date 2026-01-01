<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'hoadon';

    protected $fillable = [
        'user_id',
        'tongtien',
        'ghichu',
        'diachi_giaohang',
        'trangthai',
        'ngaylap',
        'pttt_id',
        'ptvc_id',
        'dathanhtoan',
        'ma_giaodich',
    ];

    protected $casts = [
        'tongtien' => 'decimal:2',
        'dathanhtoan' => 'boolean',
        'ngaylap' => 'datetime',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the payment method for the order.
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'pttt_id');
    }

    /**
     * Get the shipping method for the order.
     */
    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class, 'ptvc_id');
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'hoadon_id');
    }

    /**
     * Get the order history for the order.
     */
    public function orderHistory()
    {
        return $this->hasMany(OrderHistory::class, 'hoadon_id');
    }
}

