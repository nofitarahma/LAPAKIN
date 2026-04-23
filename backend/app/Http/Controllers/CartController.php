<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);

        $cartItems = $cart->cartItems()->with('product')->get();
        $totalPrice = $cart->cartItems()->sum('subtotal');

        return response()->json([
            'items'      => $cartItems,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function addToCart(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $user    = Auth::user();
        $cart    = $user->cart ?? Cart::create(['user_id' => $user->id]);
        $product = Product::findOrFail($validated['product_id']);

        // Cek stok kosong
        if ($product->stock <= 0) {
            return response()->json(['message' => 'Produk ini sedang habis stok'], 422);
        }

        // Cek apakah quantity yang diminta melebihi stok
        $existingItem = $cart->cartItems()->where('product_id', $product->id)->first();
        $currentQtyInCart = $existingItem ? $existingItem->quantity : 0;
        $totalRequestedQty = $currentQtyInCart + $validated['quantity'];

        if ($product->stock < $totalRequestedQty) {
            return response()->json([
                'message' => "Stok tidak cukup. Stok tersedia: {$product->stock}, sudah di keranjang: {$currentQtyInCart}"
            ], 422);
        }

        if ($existingItem) {
            $existingItem->quantity += $validated['quantity'];
            $existingItem->subtotal  = $product->price * $existingItem->quantity;
            $existingItem->save();
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'quantity'   => $validated['quantity'],
                'subtotal'   => $product->price * $validated['quantity'],
            ]);
        }

        return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang']);
    }

    public function updateQuantity(Request $request, int $cartItemId): JsonResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($cartItemId);
        $user = Auth::user();

        if ($cartItem->cart->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product = $cartItem->product;
        
        // Cek stok kosong
        if ($product->stock <= 0) {
            return response()->json(['message' => 'Produk ini sedang habis stok'], 422);
        }
        
        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'message' => "Stok tidak cukup. Stok tersedia: {$product->stock}"
            ], 422);
        }

        $cartItem->quantity = $validated['quantity'];
        $cartItem->subtotal = $product->price * $validated['quantity'];
        $cartItem->save();

        return response()->json(['message' => 'Jumlah item berhasil diperbarui']);
    }

    public function removeItem(int $cartItemId): JsonResponse
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $user     = Auth::user();

        if ($cartItem->cart->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();
        return response()->json(['message' => 'Item berhasil dihapus dari keranjang']);
    }
}
