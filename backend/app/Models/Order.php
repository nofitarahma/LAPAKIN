<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'name',
        'address',
        'phone',
        'total_price',
        'status',
    ];

    /* ── Relations ── */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function transferAccount(): BelongsTo
    {
        return $this->belongsTo(TransferAccount::class);
    }

    public function paymentConfirmation()
    {
        return $this->hasOne(PaymentConfirmation::class);
    }

    /* ── Business Logic ── */

    /**
     * Generate unique order number: ORD-YYYYMMDD-XXXXX
     */
    public static function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));
        } while (self::where('order_number', $number)->exists());

        return $number;
    }

    /**
     * Create order + order details from cart, then clear the cart.
     */
    public static function createOrderFromCart(Cart $cart, array $data): self
    {
        $items = $cart->cartItems()->with('product')->get();

        $totalPrice = $items->sum(fn($item) => $item->quantity * $item->product->price);

        $order = self::create([
            'user_id'      => $cart->user_id,
            'order_number' => self::generateOrderNumber(),
            'name'         => $data['name'],
            'address'      => $data['address'],
            'phone'        => $data['phone'],
            'total_price'  => $totalPrice,
            'status'       => 'pending',
        ]);

        foreach ($items as $item) {
            OrderDetail::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
                'subtotal'   => $item->quantity * $item->product->price,
            ]);
        }

        // Kosongkan keranjang setelah order dibuat
        $cart->cartItems()->delete();

        return $order->load('orderDetails.product');
    }
}
