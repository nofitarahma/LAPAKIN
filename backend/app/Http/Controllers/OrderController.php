<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * GET /api/checkout
     * Ambil ringkasan pesanan dari keranjang user yang sedang login.
     * Sesuai sequence diagram: requestRingkasanPesanan(customerId)
     */
    public function checkout(): JsonResponse
    {
        $cart = Cart::getCartByUser(auth()->id());

        // Activity diagram: cek keranjang kosong
        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json([
                'message' => 'Keranjang kosong',
            ], 422);
        }

        $items = $cart->cartItems->map(fn($item) => [
            'product_id'   => $item->product_id,
            'product_name' => $item->product->productName,
            'price'        => $item->product->price,
            'quantity'     => $item->quantity,
            'subtotal'     => $item->subtotal,
        ]);

        return response()->json([
            'items'       => $items,
            'total_price' => $cart->cartItems->sum('subtotal'),
        ]);
    }

    /**
     * POST /api/checkout
     * Buat pesanan dari keranjang user yang sedang login.
     * Sesuai sequence diagram: createOrder(orderData)
     */
    public function createOrder(Request $request): JsonResponse
    {
        // Activity diagram: validasi data pemesanan
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'phone'   => 'required|string|max:20',
        ], [
            'name.required'    => 'Nama penerima harus diisi',
            'address.required' => 'Alamat pengiriman harus diisi',
            'phone.required'   => 'Nomor telepon harus diisi',
        ]);

        $cart = Cart::getCartByUser(auth()->id());

        // Activity diagram: cek keranjang kosong sebelum simpan
        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json([
                'message' => 'Keranjang kosong',
            ], 422);
        }

        // Sequence diagram: OrderController → OrderModel: simpanPesanan(orderData)
        $order = Order::createOrderFromCart($cart, $validated);

        // Activity diagram: tampilkan nomor pesanan & instruksi pembayaran
        return response()->json([
            'id'               => $order->id,
            'message'          => 'Pesanan berhasil dibuat',
            'order_number'     => $order->order_number,
            'total_amount'     => $order->total_price,
            'status'           => $order->status,
            'items'            => $order->orderDetails->map(fn($d) => [
                'product_name' => $d->product->productName,
                'quantity'     => $d->quantity,
                'price'        => $d->price,
                'subtotal'     => $d->subtotal,
            ]),
            'payment_instruction' => 'Silakan transfer ke rekening BCA 1234567890 a/n LAPAKIN dengan nominal tepat sesuai total.',
        ], 201);
    }
}
