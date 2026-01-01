<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $table = 'phuongthucvanchuyen';

    protected $fillable = [
        'ten_ptvc',
        'gia_vanchuyen',
        'trangthai',
        'mota',
    ];

    protected $casts = [
        'gia_vanchuyen' => 'decimal:2',
        'trangthai' => 'boolean',
    ];

    /**
     * Get the orders for the shipping method.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'ptvc_id');
    }

    /**
     * Scope a query to only include active shipping methods.
     */
    public function scopeActive($query)
    {
        return $query->where('trangthai', true);
    }
}

