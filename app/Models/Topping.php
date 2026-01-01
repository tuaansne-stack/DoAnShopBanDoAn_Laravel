<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    use HasFactory;

    protected $table = 'topping';

    protected $fillable = [
        'tentopping',
        'gia',
        'hinhanh',
        'trangthai',
    ];

    protected $casts = [
        'trangthai' => 'boolean',
        'gia' => 'decimal:0',
    ];

    /**
     * Lấy các món ăn có topping này
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'monan_topping', 'topping_id', 'monan_id');
    }
}
