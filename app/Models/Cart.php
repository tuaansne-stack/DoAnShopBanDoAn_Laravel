<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'giohang';

    protected $fillable = [
        'user_id',
        'monan_id',
        'soluong',
        'ngay_them',
    ];

    protected $casts = [
        'soluong' => 'integer',
        'ngay_them' => 'datetime',
    ];

    /**
     * Get the user that owns the cart item.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the product that owns the cart item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'monan_id');
    }

    /**
     * Get the toppings for this cart item.
     */
    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'giohang_topping', 'giohang_id', 'topping_id')
                    ->withPivot('soluong');
    }

    /**
     * Get the total price for this cart item (including toppings).
     */
    public function getTotalAttribute()
    {
        $productTotal = $this->soluong * $this->product->gia;
        
        $toppingTotal = $this->toppings->sum(function($topping) {
            return $topping->gia * ($topping->pivot->soluong ?? 1) * $this->soluong;
        });
        
        return $productTotal + $toppingTotal;
    }

    /**
     * Get topping total for this cart item.
     */
    public function getToppingTotalAttribute()
    {
        return $this->toppings->sum(function($topping) {
            return $topping->gia * ($topping->pivot->soluong ?? 1) * $this->soluong;
        });
    }
}

