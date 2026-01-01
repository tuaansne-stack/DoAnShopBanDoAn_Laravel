<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'monan';

    protected $fillable = [
        'tenmon',
        'mota',
        'gia',
        'giacu',
        'danhmuc_id',
        'trangthai',
        'noibat',
    ];

    protected $casts = [
        'noibat' => 'boolean',
        'gia' => 'integer',
        'giacu' => 'integer',
    ];

    /**
     * Get all images for the product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'monan_id')->ordered();
    }

    /**
     * Get the main image for the product.
     */
    public function mainImage()
    {
        return $this->hasOne(ProductImage::class, 'monan_id')->where('is_main', true);
    }

    /**
     * Get display image - returns main image or first image.
     */
    public function getDisplayImageAttribute()
    {
        // First check for main image from new table (load if not loaded)
        $mainImg = $this->relationLoaded('mainImage') 
            ? $this->getRelation('mainImage') 
            : $this->mainImage()->first();
        
        if ($mainImg) {
            return $mainImg->hinhanh;
        }
        
        // Check for any image from new table
        $images = $this->relationLoaded('images') 
            ? $this->getRelation('images') 
            : $this->images()->get();
        
        if ($images->isNotEmpty()) {
            return $images->first()->hinhanh;
        }
        
        return null;
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'danhmuc_id');
    }

    /**
     * Get the cart items for the product.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'monan_id');
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'monan_id');
    }

    /**
     * Get the comments for the product.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'monan_id');
    }

    /**
     * Get approved comments for the product.
     */
    public function approvedComments()
    {
        return $this->comments()->where('trangthai', 'Đã duyệt');
    }

    /**
     * Get average rating for the product.
     */
    public function getAverageRatingAttribute()
    {
        return $this->approvedComments()->avg('danhgia') ?? 0;
    }

    /**
     * Get rating count for the product.
     */
    public function getRatingCountAttribute()
    {
        return $this->approvedComments()->count();
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('noibat', true)->where('trangthai', 'Đang bán');
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('trangthai', 'Đang bán');
    }

    /**
     * Lấy các toppings của món ăn này
     */
    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'monan_topping', 'monan_id', 'topping_id');
    }
}

