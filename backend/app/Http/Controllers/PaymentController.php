<?php

namespace App\Http\Controllers;

use App\Models\PaymentConfirmation;
use App\Models\Order;
use App\Models\TransferAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function getPendingPayments(): JsonResponse
    {
        $payments = PaymentConfirmation::with(['order' => function ($query) {
            $query->with('user');
        }])->latest()->get();

        return response()->json($payments);
    }

    public function getPaymentData($orderId): JsonResponse
    {
        $order = Order::with('orderDetails.product', 'user')->find($orderId);
        
        if (!$order) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        $transferAccount = TransferAccount::first();
        
        if (!$transferAccount) {
            return response()->json(['message' => 'Rekening transfer tidak ditemukan'], 404);
        }

        $items = $order->orderDetails->map(function ($detail) {
            return [
                'product_name' => $detail->product->productName,
                'quantity' => $detail->quantity,
                'price' => $detail->price,
                'subtotal' => $detail->subtotal,
            ];
        });

        return response()->json([
            'order' => [
                'order_number' => $order->order_number,
                'name' => $order->user->name,
                'address' => $order->user->address,
                'phone' => $order->user->phone ?? $order->phone ?? '-',
                'total_price' => $order->total_price,
                'items' => $items,
            ],
            'transfer_account' => [
                'bank_name' => $transferAccount->bank_name,
                'account_number' => $transferAccount->account_number,
                'account_holder_name' => $transferAccount->account_holder_name,
            ],
        ]);
    }

    public function submitPaymentConfirmation(Request $request, $orderId): JsonResponse
    {
        $validated = $request->validate([
            'sender_name'    => 'required|string|max:255',
            'transfer_date'  => 'required|date',
            'proof_of_transfer' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        $order = Order::find($orderId);
        
        if (!$order) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        $payment = PaymentConfirmation::where('order_id', $orderId)->first();
        
        if (!$payment) {
            $payment = new PaymentConfirmation();
            $payment->order_id = $orderId;
        }

        $payment->sender_name = $validated['sender_name'];
        $payment->transfer_date = $validated['transfer_date'];
        
        if ($request->hasFile('proof_of_transfer')) {
            $payment->proof_of_transfer = $request->file('proof_of_transfer')->store('payments', 'public');
        }
        
        $payment->confirmation_status = 'pending';
        $payment->save();

        $order->update(['status' => 'pending']);

        return response()->json(['message' => 'Bukti transfer berhasil dikirim'], 200);
    }

    public function processConfirmation(Request $request, $paymentId): JsonResponse
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:diterima,ditolak',
            ]);

            $payment = PaymentConfirmation::find($paymentId);
            
            if (!$payment) {
                return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
            }

            $payment->update(['confirmation_status' => $validated['status']]);

            $order = Order::find($payment->order_id);
            if ($order) {
                if ($validated['status'] === 'diterima') {
                    $order->update(['status' => 'shipped']);
                } else {
                    $order->update(['status' => 'cancelled']);
                }
            }

            return response()->json([
                'message' => 'Pembayaran ' . ($validated['status'] === 'diterima' ? 'diterima' : 'ditolak'),
                'payment' => $payment,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
