<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInfo extends Model
{
    use HasFactory;

    protected $table = 'thongtinthanhtoan';

    protected $fillable = [
        'pttt_id',
        'ten_nganhang',
        'so_taikhoan',
        'ten_chutaikhoan',
        'chi_nhanh',
        'noi_dung_mau',
        'ma_nganhang',
    ];

    /**
     * Get the payment method that owns the payment info.
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'pttt_id');
    }
}

