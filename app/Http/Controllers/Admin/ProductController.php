<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Product::with(['category', 'images', 'mainImage']);

        // Search
        if ($request->has('search') && $request->search) {
            $query->where('tenmon', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('danhmuc_id', $request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('trangthai', $request->status);
        }

        $products = $query->orderBy('id', 'desc')->paginate(10);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $toppings = Topping::where('trangthai', true)->get();
        return view('admin.products.edit', [
            'product' => null,
            'categories' => $categories,
            'toppings' => $toppings
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenmon' => 'required|string|max:255',
            'danhmuc_id' => 'required|exists:danhmuc,id',
            'gia' => 'required|numeric|min:0',
            'mota' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);

        $data = $request->only(['tenmon', 'danhmuc_id', 'gia', 'giacu', 'mota', 'trangthai', 'noibat']);
        
        // Handle legacy single image (backward compatibility)
        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $extension = $file->getClientOriginalExtension();
            $filename = 'product_' . uniqid() . '.' . $extension;
            $file->storeAs('public/uploads/products', $filename);
            $data['hinhanh'] = 'products/' . $filename;
        }

        $data['noibat'] = $request->has('noibat') ? 1 : 0;

        $product = Product::create($data);

        // Handle multiple images
        if ($request->hasFile('images')) {
            $mainImageIndex = $request->input('main_image', 0);
            foreach ($request->file('images') as $index => $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = 'product_' . uniqid() . '.' . $extension;
                $file->storeAs('public/uploads/products', $filename);
                
                ProductImage::create([
                    'monan_id' => $product->id,
                    'hinhanh' => 'products/' . $filename,
                    'is_main' => ($index == $mainImageIndex),
                    'sort_order' => $index,
                ]);
            }
        }
        // Sync toppings
        if ($request->has('toppings')) {
            $product->toppings()->sync($request->toppings);
        }

        return redirect()->route('admin.products.index')->with('success', 'Thêm món ăn thành công!');
    }

    public function edit($id)
    {
        $product = Product::with(['images', 'toppings'])->findOrFail($id);
        $categories = Category::all();
        $toppings = Topping::where('trangthai', true)->get();
        
        return view('admin.products.edit', compact('product', 'categories', 'toppings'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'tenmon' => 'required|string|max:255',
            'danhmuc_id' => 'required|exists:danhmuc,id',
            'gia' => 'required|numeric|min:0',
            'mota' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);

        $data = $request->only(['tenmon', 'danhmuc_id', 'gia', 'giacu', 'mota', 'trangthai']);
        
        // Handle legacy single image (backward compatibility)
        if ($request->hasFile('hinhanh')) {
            // Delete old image from Laravel storage
            if ($product->hinhanh) {
                Storage::delete('public/uploads/' . $product->hinhanh);
            }
            
            $file = $request->file('hinhanh');
            $extension = $file->getClientOriginalExtension();
            $filename = 'product_' . uniqid() . '.' . $extension;
            $file->storeAs('public/uploads/products', $filename);
            $data['hinhanh'] = 'products/' . $filename;
        }

        $data['noibat'] = $request->has('noibat') ? 1 : 0;

        $product->update($data);

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $existingCount = $product->images()->count();
            foreach ($request->file('images') as $index => $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = 'product_' . uniqid() . '.' . $extension;
                $file->storeAs('public/uploads/products', $filename);
                
                ProductImage::create([
                    'monan_id' => $product->id,
                    'hinhanh' => 'products/' . $filename,
                    'is_main' => ($existingCount == 0 && $index == 0), // Set first as main if no existing images
                    'sort_order' => $existingCount + $index,
                ]);
            }
        }

        // Update main image
        if ($request->has('main_image_id')) {
            // Reset all images to non-main
            $product->images()->update(['is_main' => false]);
            // Set selected image as main
            ProductImage::where('id', $request->main_image_id)->update(['is_main' => true]);
        }

        // Sync toppings
        $product->toppings()->sync($request->toppings ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật món ăn thành công!');
    }

    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);
        
        // Delete all product images from storage
        foreach ($product->images as $image) {
            Storage::delete('public/uploads/' . $image->hinhanh);
        }
        
        // Delete legacy image
        if ($product->hinhanh) {
            Storage::delete('public/uploads/' . $product->hinhanh);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Xóa món ăn thành công!');
    }

    /**
     * Delete a single product image via AJAX
     */
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        
        // Delete file from storage
        Storage::delete('public/uploads/' . $image->hinhanh);
        
        // If this was the main image, set another image as main
        if ($image->is_main) {
            $nextImage = ProductImage::where('monan_id', $image->monan_id)
                ->where('id', '!=', $image->id)
                ->first();
            if ($nextImage) {
                $nextImage->update(['is_main' => true]);
            }
        }
        
        $image->delete();
        
        return response()->json(['success' => true, 'message' => 'Xóa hình ảnh thành công!']);
    }
}
