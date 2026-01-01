<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $table = 'lichsudonhang';

    protected $fillable = [
        'hoadon_id',
        'trang_thai_cu',
        'trang_thai_moi',
        'ngay_thay_doi',
        'nguoi_thay_doi',
        'ghi_chu',
    ];

    protected $casts = [
        'ngay_thay_doi' => 'datetime',
    ];

    /**
     * Get the order that owns the order history.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'hoadon_id');
    }
}

