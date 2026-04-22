<?php

namespace App\Http\Controllers;

use App\Models\PaymentConfirmation;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    /**
     * GET /api/admin/payments/pending
     * Ambil semua payment confirmation yang pending
     */
    public function getPendingPayments()
    {
        $payments = PaymentConfirmation::with('order.user', 'order.orderDetails.product')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($payments);
    }

    /**
     * POST /api/admin/payments/{paymentId}/confirm
     * Konfirmasi atau tolak payment
     */
    public function confirmPayment(Request $request, $paymentId)
    {
        $validated = $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $payment = PaymentConfirmation::find($paymentId);

        if (!$payment) {
            return response()->json(['message' => 'Payment tidak ditemukan'], 404);
        }

        // Update payment confirmation status
        $payment->update(['confirmation_status' => $validated['status']]);

        // Update order status
        if ($validated['status'] === 'diterima') {
            $payment->order->update(['status' => 'confirmed']);
        } elseif ($validated['status'] === 'ditolak') {
            $payment->order->update(['status' => 'rejected']);
        }

        return response()->json([
            'message' => 'Pembayaran berhasil di' . $validated['status'],
            'payment' => $payment,
        ]);
    }
}
