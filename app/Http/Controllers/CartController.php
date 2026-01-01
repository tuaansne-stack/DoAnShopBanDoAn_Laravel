<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the cart.
     */
    public function index()
    {
        $cartItems = Cart::with(['product', 'toppings'])
            ->where('user_id', Auth::id())
            ->get();

        $cartTotal = $cartItems->sum(function($item) {
            return $item->total;
        });

        return view('cart.index', compact('cartItems', 'cartTotal'));
    }

    /**
     * Add product to cart.
     */
    public function add(AddToCartRequest $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.',
                'requires_auth' => true
            ], 401);
        }

        $product = Product::findOrFail($request->product_id);

        if ($product->trangthai !== 'Đang bán') {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm không tồn tại hoặc đã ngừng kinh doanh.'
            ], 400);
        }

        $quantity = min(max($request->quantity ?? 1, 1), 10);
        $toppings = $request->toppings ?? [];

        // Check if same product with same toppings exists
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('monan_id', $product->id)
            ->get();
        
        $matchingCart = null;
        foreach ($existingCart as $cart) {
            $cartToppingIds = $cart->toppings->pluck('id')->sort()->values()->toArray();
            $requestToppingIds = collect($toppings)->pluck('id')->map(fn($id) => (int)$id)->sort()->values()->toArray();
            
            if ($cartToppingIds == $requestToppingIds) {
                $matchingCart = $cart;
                break;
            }
        }

        if ($matchingCart) {
            $newQuantity = min($matchingCart->soluong + $quantity, 10);
            $matchingCart->update(['soluong' => $newQuantity]);
            $wasRecentlyCreated = false;
        } else {
            $wasRecentlyCreated = true;
            $newQuantity = $quantity;
            $cartItem = Cart::create([
                'user_id' => Auth::id(),
                'monan_id' => $product->id,
                'soluong' => $newQuantity,
            ]);
            
            // Attach toppings if any
            if (!empty($toppings)) {
                foreach ($toppings as $topping) {
                    DB::table('giohang_topping')->insert([
                        'giohang_id' => $cartItem->id,
                        'topping_id' => $topping['id'],
                        'soluong' => 1,
                    ]);
                }
            }
        }

        $message = $newQuantity == 10 
            ? 'Đã thêm sản phẩm vào giỏ hàng (số lượng tối đa: 10).'
            : ($wasRecentlyCreated 
                ? 'Đã thêm sản phẩm vào giỏ hàng.' 
                : 'Đã cập nhật số lượng sản phẩm trong giỏ hàng.');

        $cartCount = Cart::where('user_id', Auth::id())->count();

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cartItem = Cart::with(['product', 'toppings'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $cartItem->update(['soluong' => $request->quantity]);
        
        // Refresh to get updated data
        $cartItem->refresh();
        $cartItem->load('toppings');

        // Calculate item subtotal (including toppings)
        $itemSubtotal = $cartItem->total;

        // Calculate cart total
        $cartTotal = Cart::with(['product', 'toppings'])
            ->where('user_id', Auth::id())
            ->get()
            ->sum(function($item) {
                return $item->total;
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật số lượng.',
            'quantity' => $cartItem->soluong,
            'item_subtotal' => $itemSubtotal,
            'cart_total' => $cartTotal,
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function remove($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->findOrFail($id);

        $cartItem->delete();

        $cartCount = Cart::where('user_id', Auth::id())->count();
        
        // Calculate cart total after removal
        $cartTotal = Cart::with(['product', 'toppings'])
            ->where('user_id', Auth::id())
            ->get()
            ->sum(function($item) {
                return $item->total;
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
            'cart_count' => $cartCount,
            'cart_total' => $cartTotal,
        ]);
    }

    /**
     * Clear cart.
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa tất cả sản phẩm khỏi giỏ hàng.',
        ]);
    }

    /**
     * Get cart count.
     */
    public function getCount()
    {
        $count = Cart::where('user_id', Auth::id())->count();

        return response()->json([
            'count' => $count,
        ]);
    }
}

