<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'mainImage'])
            ->active()
            ->withAvg('approvedComments', 'danhgia')
            ->withCount('approvedComments');

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('danhmuc_id', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tenmon', 'like', "%{$search}%")
                  ->orWhere('mota', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     */
    public function show(Request $request, $id)
    {
        $product = Product::with(['category', 'approvedComments.user', 'images', 'toppings'])
            ->withAvg('approvedComments', 'danhgia')
            ->withCount('approvedComments')
            ->findOrFail($id);

        // Handle review submission
        if ($request->isMethod('post') && $request->has('submit_review')) {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'review_content' => 'required|string|min:10',
            ]);

            // Check if user already reviewed this product
            $existingReview = \App\Models\Comment::where('monan_id', $product->id)
                ->where('user_id', auth()->id())
                ->first();

            if ($existingReview) {
                // Update existing review
                $existingReview->update([
                    'noidung' => $request->review_content,
                    'danhgia' => $request->rating,
                    'trangthai' => 'Chờ duyệt',
                ]);
            } else {
                // Create new review
                \App\Models\Comment::create([
                    'monan_id' => $product->id,
                    'user_id' => auth()->id(),
                    'noidung' => $request->review_content,
                    'danhgia' => $request->rating,
                    'trangthai' => 'Chờ duyệt',
                ]);
            }

            return redirect()->route('products.show', $product->id)
                ->with('success', 'Cảm ơn bạn đã đánh giá! Đánh giá của bạn đang chờ được kiểm duyệt.');
        }

        $relatedProducts = Product::with(['category', 'images'])
            ->where('danhmuc_id', $product->danhmuc_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}

