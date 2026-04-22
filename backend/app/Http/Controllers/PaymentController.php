<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\TransferAccount;
use App\Models\PaymentConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Get payment data untuk halaman transfer
     * Sesuai Sequence Diagram: requestDataPembayaran(orderId)
     */
    public function getPaymentData($orderId)
    {
        $order = Order::with('orderDetails.product', 'user')->find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Get transfer account (bisa random atau yang sudah dipilih)
        $transferAccount = TransferAccount::first();

        if (!$transferAccount) {
            return response()->json(['message' => 'Transfer account tidak tersedia'], 404);
        }

        return response()->json([
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'name' => $order->name,
                'address' => $order->address,
                'phone' => $order->phone,
                'total_price' => $order->total_price,
                'status' => $order->status,
                'items' => $order->orderDetails->map(fn($detail) => [
                    'product_name' => $detail->product->product_name,
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'subtotal' => $detail->subtotal,
                ]),
            ],
            'transfer_account' => $transferAccount->displayAccountInfo(),
        ]);
    }

    /**
     * Submit payment confirmation
     * Sesuai Sequence Diagram: submitConfirmation()
     */
    public function submitPaymentConfirmation(Request $request, $orderId)
    {
        $validated = $request->validate([
            'transfer_date' => 'required|date',
            'sender_name' => 'required|string|max:255',
            'proof_of_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Upload proof of transfer
        $file = $request->file('proof_of_transfer');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('payment_proofs', $filename, 'public');

        // Create payment confirmation
        $paymentConfirmation = PaymentConfirmation::create([
            'order_id' => $order->id,
            'transfer_date' => $validated['transfer_date'],
            'sender_name' => $validated['sender_name'],
            'proof_of_transfer' => $filename,
            'confirmation_status' => 'pending',
        ]);

        // Update order status
        $order->update(['status' => 'paid']);

        return response()->json([
            'message' => 'Bukti transfer berhasil dikirim',
            'payment_confirmation' => $paymentConfirmation,
        ], 201);
    }
}
