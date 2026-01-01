<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    /**
     * Get cart items for authenticated user.
     */
    public function getCartItems()
    {
        return Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
    }

    /**
     * Calculate cart total.
     */
    public function calculateTotal($cartItems = null)
    {
        if (!$cartItems) {
            $cartItems = $this->getCartItems();
        }

        return $cartItems->sum(function($item) {
            return $item->soluong * $item->product->gia;
        });
    }

    /**
     * Get cart count.
     */
    public function getCartCount()
    {
        return Cart::where('user_id', Auth::id())->count();
    }

    /**
     * Add product to cart.
     */
    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);

        if ($product->trangthai !== 'Đang bán') {
            throw new \Exception('Sản phẩm không tồn tại hoặc đã ngừng kinh doanh.');
        }

        $quantity = min(max($quantity, 1), 10);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('monan_id', $productId)
            ->first();

        if ($cartItem) {
            $newQuantity = min($cartItem->soluong + $quantity, 10);
            $cartItem->update(['soluong' => $newQuantity]);
            return $cartItem;
        }

        return Cart::create([
            'user_id' => Auth::id(),
            'monan_id' => $productId,
            'soluong' => $quantity,
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function updateQuantity($cartItemId, $quantity)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->findOrFail($cartItemId);

        $quantity = min(max($quantity, 1), 10);
        $cartItem->update(['soluong' => $quantity]);

        return $cartItem;
    }

    /**
     * Remove item from cart.
     */
    public function removeItem($cartItemId)
    {
        return Cart::where('user_id', Auth::id())
            ->findOrFail($cartItemId)
            ->delete();
    }

    /**
     * Clear cart.
     */
    public function clearCart()
    {
        return Cart::where('user_id', Auth::id())->delete();
    }
}

