<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }

        $cartItems = $cart->cartItems()->with('product')->get();
        $totalPrice = $cart->cartItems()->sum('subtotal');

        return view('cart.index', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'cart' => $cart,
        ]);
    }

    public function addToCart(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);
        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock < $validated['quantity']) {
            return redirect()->back()->with('error', 'Stok tidak cukup');
        }

        $existingItem = $cart->cartItems()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $existingItem->quantity += $validated['quantity'];
            $existingItem->subtotal = $product->price * $existingItem->quantity;
            $existingItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'subtotal' => $product->price * $validated['quantity'],
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function removeItem(int $cartItemId): RedirectResponse
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cart = $cartItem->cart;
        $user = Auth::user();

        if ($cart->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang');
    }
}
