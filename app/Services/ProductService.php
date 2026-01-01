<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     * Get featured products.
     */
    public function getFeaturedProducts($limit = 4)
    {
        return Product::with(['category'])
            ->where('noibat', 1)
            ->where('trangthai', 'Đang bán')
            ->withAvg(['comments' => function($query) {
                $query->where('trangthai', 'Đã duyệt');
            }], 'danhgia')
            ->withCount(['comments' => function($query) {
                $query->where('trangthai', 'Đã duyệt');
            }])
            ->limit($limit)
            ->get();
    }

    /**
     * Get latest products.
     */
    public function getLatestProducts($limit = 8)
    {
        return Product::with(['category'])
            ->where('trangthai', 'Đang bán')
            ->withAvg(['comments' => function($query) {
                $query->where('trangthai', 'Đã duyệt');
            }], 'danhgia')
            ->withCount(['comments' => function($query) {
                $query->where('trangthai', 'Đã duyệt');
            }])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get top rated products.
     */
    public function getTopRatedProducts($limit = 4)
    {
        return Product::with(['category'])
            ->where('trangthai', 'Đang bán')
            ->whereHas('comments', function($query) {
                $query->where('trangthai', 'Đã duyệt');
            })
            ->withAvg(['comments' => function($query) {
                $query->where('trangthai', 'Đã duyệt');
            }], 'danhgia')
            ->withCount(['comments' => function($query) {
                $query->where('trangthai', 'Đã duyệt');
            }])
            ->orderBy('comments_avg_danhgia', 'desc')
            ->orderBy('comments_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Search products.
     */
    public function searchProducts($keyword, $categoryId = null, $perPage = 12)
    {
        $query = Product::with(['category'])
            ->active()
            ->where(function($q) use ($keyword) {
                $q->where('tenmon', 'like', "%{$keyword}%")
                  ->orWhere('mota', 'like', "%{$keyword}%");
            });

        if ($categoryId) {
            $query->where('danhmuc_id', $categoryId);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Upload product image.
     */
    public function uploadImage($file)
    {
        $filename = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('products', $filename, 'public');
        
        return basename($path);
    }

    /**
     * Delete product image.
     */
    public function deleteImage($filename)
    {
        if ($filename && Storage::disk('public')->exists('products/' . $filename)) {
            Storage::disk('public')->delete('products/' . $filename);
        }
    }
}

